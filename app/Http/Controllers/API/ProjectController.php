<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public $auth = [];

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->auth = Auth::guard()->user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $dataContent = Project::orderBy('name')->with('institution');
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
//        return $this->auth;
        $request->merge([
            'user_id'       => $this->auth['id'],
            'institution_id' => $request->institution_id ?? $this->auth['institution_id'],
        ]);
        $this->validateData($request);

        Project::create($request->all());
        return $this->response;
    }

    public function validateData($request)
    {
        if ($request->id) {
            $request->validate([
                'name'           => 'required',
                'status'         => 'required',
                'role'           => 'required',
                'institution_id' => 'required',
            ]);
        } else {
            $request->validate([
                'name'           => 'required',
                'status'         => 'nullable',
                'role'           => 'required',
                'user_id'       => 'required',
                'institution_id' => 'required',
            ]);
        }

    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'id' => $id
        ]);
        $this->validateData($request);

        $project = Project::find($id);

        if ($project) {
            $project->update($request->all());
            $this->response['text'] = 'Updated!';
            return $this->response;
        } else {
            $this->response['status'] = false;
            $this->response['text'] = 'Data not found.';
            return $this->response;
        }
    }

    public function show($id)
    {
        $project = Project::find($id);

        $this->response['result'] = $project;
        return $this->response;
    }

    public function destroy($id)
    {
        $project = Project::find($id);

        if ($project && $this->auth['id'] === $project->user_id) {
            $project->delete();
        }else{
            $this->response['status'] = false;
            $this->response['text'] = 'No Data';
        }
        return $this->response;
    }
}
