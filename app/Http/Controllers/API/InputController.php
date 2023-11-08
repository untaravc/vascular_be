<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Input;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InputController extends Controller
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
        $dataContent = Input::orderByDesc('created_at');
        $dataContent = $this->withFilter($dataContent, $request);
        $dataContent = $dataContent->paginate(25);

        $result = collect($this->response);
        return $result->merge($dataContent);
    }

    public function withFilter($dataContent, $request)
    {
        return $dataContent;
    }

    public function show($id)
    {
        $data = Input::find($id);
        $project = Project::find($data->id);

        $this->response['result'] = $data;
        $this->response['project'] = $project;
        return $this->response;
    }

    public function store(Request $request)
    {
        $request->merge([
            'user_id' => $this->auth['id'],
        ]);
//        return $request;
        $this->validateData($request);

        $project = Project::find($request->project_id);

        if (!$project) {
            $this->response['status'] = false;
            $this->response['text'] = 'No data project.';
            return $this->response;
        }

        $req = new Request();
        $req->project_id = $request->project_id;

        $list_type = $this->properties($req)['result']['types'];

        if (!in_array($request->type, $list_type)) {
            $this->response['status'] = false;
            $this->response['text'] = 'False Type.';
            return $this->response;
        }

        $request->merge([
            'institution_id' => $project->institution_id,
        ]);

        $input = Input::create($request->except('parent_id'));
        $this->response['result'] = $input;
        return $this->response;
    }

    public function validateData($request)
    {
        if ($request->id) {
            $request->validate([
                'name'   => 'required',
                'type'   => 'required',
                'prefix' => 'nullable',
                'suffix' => 'nullable',
                'order'  => 'nullable',
            ]);
        } else {
            $request->validate([
                'name'        => 'required',
                'type'        => 'required',
                'category_id' => 'required',
                'project_id'  => 'required',
                'prefix'      => 'nullable',
                'suffix'      => 'nullable',
                'order'       => 'nullable',
                'user_id'     => 'required',
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'id' => $id
        ]);
        $this->validateData($request);

        $req = new Request();
        $req->project_id = $request->project_id;
        $list_type = $this->properties($req)['result']['types'];
        if (!in_array($request->type, $list_type)) {
            $this->response['status'] = false;
            $this->response['text'] = 'False Type.';
            return $this->response;
        }
        $input = Input::find($id);

        if ($input) {

            $input->update([
                'name'             => $request->name,
                'type'             => $request->type,
                'prefix'           => $request->prefix,
                'suffix'           => $request->suffix,
                'order'            => $request->order,
                'is_currency'      => $request->is_currency,
                'dependency_id'    => $request->dependency_id,
                'dependency_value' => $request->dependency_value,
                'status'           => $request->status,
                'blank_option'     => $request->blank_option,
                'note'          => $request->note,
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
        $patient = Input::find($id);

        // Cek sudah punya
        if ($patient) {
            $patient->delete();
        } else {
            $this->response['status'] = false;
            $this->response['text'] = 'No Data';
        }
        return $this->response;
    }

    public function list(Request $request)
    {
        $request->validate([
            'project_id'  => 'required',
            'category_id' => 'required',
        ]);

        $input = Input::whereProjectId($request->project_id)
            ->whereCategoryId($request->category_id)
            ->when($request->has_details, function ($q) {
                $q->whereHas('input_details');
            })->with('input_details')
            ->get();

        $this->response['result'] = $input;
        return $this->response;
    }

    public function properties(Request $request)
    {
        $data['types'] = [
            'text', // STR
            'password', // STR
            'text-area', // TEXT
            'number', // INT
            'number-float', // DOUBLE

            'month', // STR
            'week', // STR
            'date', // DATETIME
            'datetime-local', // DATETIME

            'select', // input detail STR
            'file', // link & preview STR
            'file-image', // link preview image STR
            'checkbox', // input detail OBJECT
            'radio', // input detail STR
            'color', // STR
            'range', // STR
        ];

        $data['categories'] = Category::whereProjectId($request->project_id)
            ->whereParentId(0)
            ->get();

        $data['sub_categories'] = Category::whereProjectId($request->project_id)
            ->where('parent_id', '!=', 0)
            ->get();

        $this->response['result'] = $data;
        return $this->response;
    }

    public function category_input($input_id)
    {
        $data = Input::whereCategoryId($input_id)
            ->get();

        $this->response['result'] = $data;
        return $this->response;
    }
}
