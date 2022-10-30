<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstitutionController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::guard()->user()['role_id'] != 1){
                $this->response['status'] = false;
                $this->response['text'] = 'Unauthorized';
                return response()->json($this->response);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $dataContent = Institution::orderBy('name')->withCount('users','projects');
        $dataContent = $this->withFilter($dataContent, $request);
        $dataContent = $dataContent->paginate(20);

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

        Institution::create($request->all());
        return $this->response;
    }

    public function validateData($request)
    {
        $request->validate([
            'name'    => 'required',
            'address' => 'nullable',
            'status'  => 'required',
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->merge(['id'=>$id]);
        $this->validateData($request);

        $institution = Institution::find($id);

        if ($institution) {
            $institution->update($request->all());
            $this->response['text'] = 'Updated!';
            return $this->response;
        } else {
            $this->response['status'] = false;
            $this->response['text'] = 'No User';
            return $this->response;
        }
    }

    public function show($id)
    {
        $institution = Institution::find($id);

        $this->response['result'] = $institution;
        return $this->response;
    }

    public function destroy($id)
    {
        $institution = Institution::find($id);

        if ($institution) {
            $institution->delete();
        }else{
            $this->response['status'] = false;
            $this->response['text'] = 'No Data';
        }
        return $this->response;
    }

    public function list(){
        $data = Institution::whereStatus(1)
            ->orderBy('name')
            ->get();

        $this->response['result'] = $data;
        return $this->response;
    }
}
