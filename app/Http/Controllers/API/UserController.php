<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInstitution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $dataContent = User::with(['institution',
            'user_institutions',
            'institutions',
        ])
            ->orderBy('name');
        $dataContent = $this->withFilter($dataContent, $request);
        $dataContent = $dataContent->paginate($request->per_page ?? 20);

        $user_institutions = UserInstitution::whereIn('user_id', $dataContent->pluck('id')->toArray())
            ->get();

        foreach ($dataContent as $data) {
            $data->setAttribute('institution_ids',
                $user_institutions->where('user_id', $data['id'])->pluck('institution_id'));
        }

        $result = collect($this->response);
        return $result->merge($dataContent);
    }

    public function withFilter($dataContent, $request)
    {
        if($request->name){
            $dataContent = $dataContent->where('name', 'LIKE', '%'.$request->name.'%');
        }
        return $dataContent;
    }

    public function store(Request $request)
    {
        $this->validateData($request);
        $request->merge([
            'password' => Hash::make($request->password),
        ]);

        $user = User::create($request->all());

        $user->institutions()->sync($request->institution_ids);

        return $this->response;
    }

    public function validateData($request)
    {
        if ($request->id) {
            // Update
            $request->validate([
                'name'           => 'required',
                'email'          => 'required|email|unique:users,id,' . $request->id,
                'password'       => 'nullable',
                'role_id'        => 'required',
                'institution_id' => 'required',
            ]);
        } else {
            $request->validate([
                'name'           => 'required',
                'email'          => 'required|unique:users|email',
                'password'       => 'required|confirmed',
                'role_id'        => 'required',
                'institution_id' => 'required',
            ]);
        }
    }

    public function update(Request $request, $id){
        $request->merge(['id' => $id]);
        $this->validateData($request);

        $user = User::find($request->id);
        if($user){
            if($request->password){
                $request->merge([
                    'password' => Hash::make($request->password),
                ]);
            }

            $user->institutions()->sync($request->institution_ids);

            $user->update($request->all());
            $this->response['text'] = 'Updated!';
        }else{
            $this->response['status'] = false;
            $this->response['text'] = 'No User';
        }

            return $this->response;
        }

    public function show($id){
        $user = User::find($id);

        $this->response['result'] = $user;
        return $this->response;
    }

    public function destroy($id){
        $auth = Auth::guard()->user();
        $user = User::where('id', '!=', 1)->find($id);

        if($user && $auth['role_id'] === 1){
            $user->delete();
        }

        return $this->response;
    }
}
