<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Project;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
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
        $dataContent = Patient::orderByDesc('created_at');
        $dataContent = $this->withFilter($dataContent, $request);
        $dataContent = $dataContent->paginate(25);

        $result = collect($this->response);
        return $result->merge($dataContent);
    }

    public function withFilter($dataContent, $request)
    {
        if ($request->name) {
            $dataContent = $dataContent->where('name', 'LIKE', '%' . $request->name . '%');
        }
        return $dataContent;
    }

    public function show($id)
    {
        $patient = Patient::find($id);

        $this->response['result'] = $patient;
        return $this->response;
    }

    public function store(Request $request)
    {
        $sanitize_name = $this->sanitize_name($request->name);
        $request->merge([
            'user_id' => $this->auth['id'],
            'name'    => $sanitize_name,
        ]);
        $this->validateData($request);

        $project = Project::find($request->project_id);
        if (!$project) {
            $this->response['status'] = false;
            $this->response['text'] = 'No project data';
            return $this->response;
        }

        $patient = Patient::whereName($sanitize_name)
            ->whereDob($request->dob)
            ->first();

        if (!$patient) {
            $patient = Patient::create([
                "user_id" => $request->user_id,
                "name"    => $request->name,
                "dob"     => $request->dob,
                "address" => $request->address,
            ]);
        }

        $auth = $request->user();

        $record = Record::wherePatientId($patient->id)
            ->whereProjectId($project->id)
            ->first();

        if (!$record) {
            $record = Record::create([
                "patient_id"     => $patient->id,
                "user_id"        => $request->user_id,
                "name"           => $patient->name,
                "dob"            => $patient->dob,
                "project_id"     => $project->id,
                "institution_id" => $auth->institution_id ?? $project->institution_id,
                "category_id"    => $request->category_id,
//                "record_number"  => null,
            ]);
        }else{
            $record->update([
                "category_id"    => $request->category_id,
            ]);
        }

        $this->response['result'] = [
            'record' => $record
        ];
        return $this->response;
    }

    public function validateData($request)
    {
        if ($request->id) {
            // Update
            $request->validate([
                'name' => 'required',
                'dob'  => 'required',
            ]);
        } else {
            $request->validate([
                'name'        => 'required',
                'dob'         => 'required',
                'project_id'  => 'required',
                'user_id'     => 'required',
                'address'     => 'nullable',
                'category_id' => 'required',
            ]);
        }

    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'id' => $id
        ]);
        $this->validateData($request);

        $patient = Patient::find($id);

        if ($patient) {
            $patient->update([
                'name'    => $request->name,
                'dob'     => $request->dob,
                'address' => $request->address,
            ]);
            $this->response['text'] = 'Updated!';
        } else {
            $this->response['status'] = false;
            $this->response['text'] = 'Data not found.';
        }
        return $this->response;
    }

    public function destroy($id)
    {
        $patient = Patient::find($id);

        if ($patient && $this->auth['id'] === $patient->user_id) {
            $patient->delete();
        } else {
            $this->response['status'] = false;
            $this->response['text'] = 'No Data';
        }
        return $this->response;
    }

    public function sanitize_name($name)
    {
        return strtolower(str_replace('  ', ' ', $name));
    }
}
