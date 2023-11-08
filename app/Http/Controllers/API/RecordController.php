<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Input;
use App\Models\ProjectInput;
use App\Models\ProjectLog;
use App\Models\Record;
use App\Models\UserInstitution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RecordController extends Controller
{
    public function index(Request $request, $project_id)
    {
        $dataContent = Record::orderByDesc('created_at')
            ->with([
                'category',
                'institution'
            ])
            ->whereProjectId($project_id);
        $dataContent = $this->withFilter($dataContent, $request);
        $dataContent = $dataContent->paginate(25);

        $user = $request->user();

        $user_institution = UserInstitution::whereUserId($user['id'])
            ->pluck('institution_id');

        foreach ($dataContent as $data){
            $access = false;
            if(in_array($data->institution_id, $user_institution->toArray())){
                $access = true;
            }
            $data->setAttribute('access', $access);
        }

        $result = collect($this->response);
        return $result->merge($dataContent);
    }

    private function withFilter($dataContent, $request)
    {
        if ($request->project_id) {
            $dataContent = $dataContent->whereProjectId($request->project_id);
        }

        if ($request->category_id) {
            $dataContent = $dataContent->whereCategoryId($request->category_id);
        }

        if ($request->name) {
            $dataContent = $dataContent->where('name', 'LIKE', '%'.$request->name.'%');
        }

        return $dataContent;
    }

    public function store(Request $request)
    {
        $patient_ctrl = new PatientController();
        $sanitize_name = $patient_ctrl->sanitize_name($request->name);

        // check patient


        // check project

        // create record
    }

    public function validateData($request)
    {
        if ($request->id) {
            $request->validate([
                'name' => 'required',
                'dob'  => 'required',
            ]);
        } else {
            $request->validate([
                'name'       => 'required',
                'dob'        => 'required',
                'project_id' => 'required',
                'user_id'    => 'required',
                'address'    => 'nullable',
            ]);
        }

    }

    public function show(Request $request)
    {
        $record = Record::find($request->record_id);
        if(!$record){
            $this->response['status'] = false;
            $this->response['text'] = 'Record tidak ditemukan.';
            return $this->response;
        }
        $categories = Category::whereParentId($record->category_id)
            ->get();

        $inputs = Input::whereIn('category_id', $categories->pluck('id'))
            ->whereStatus(1)
            ->get();

        foreach ($categories as $category) {
            $category->setAttribute('sum', $inputs->where('category_id', $category->id)->count());
        }

        $this->response['result'] = $record;
        $this->response['categories'] = $categories;
        return $this->response;
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input_id'  => 'required',
            'record_id' => 'required',
        ]);

        if ($validator->fails()) {
            $this->response['status'] = false;
            return $this->response;
        }

        $input = Input::find($request->input_id);

        $record = Record::find($request->record_id);

        $project_input = ProjectInput::whereInputId($request->input_id)
            ->whereRecordId($request->record_id)
            ->first();

        $value_str = null;
        $value_text = null;
        switch ($input->type) {
            case 'textarea':
                $value_text = $request->value;
                break;
            case 'checkbox':
                $value_text = $this->checkbox_input($project_input, $request);
                break;
            default:
                $value_str = $request->value;
        }

        $payload = [
            'input_id'   => $input->id,
            'project_id' => $record->project_id,
            'record_id'  => $record->id,
            'value_str'  => $value_str,
            'value_text' => $value_text,
        ];

        if ($project_input) {
            $this->create_log($payload, $project_input, 'update');
            $project_input->update($payload);
        } else {
            $project_input = ProjectInput::create($payload);
            $this->create_log($payload, $project_input, 'create');
        }

        return $this->response;
    }

    public function destroy($id){
        $record = Record::myOwn()->find($id);
        if(!$record){
           $this->response['status'] = false;
           $this->response['text'] = 'Invalid!';
           return $this->response;
        }

        $record->delete();
        return $this->response;
    }

    private function create_log($payload, $project_input, $type)
    {
        $auth = Auth::guard()->user();
        if ($type == 'create') {
            ProjectLog::create([
                'project_id'       => $payload['project_id'],
                'record_id'        => $payload['record_id'],
                'project_input_id' => $project_input->id,
                'input_id'         => $project_input->input_id,
                'user_id'          => $auth['id'],
                'value_from'       => null,
                'value_then'       => $payload['value_str'] ?? $payload['value_text'],
                'is_creator'       => 1,
            ]);
        }else{
            $from = $project_input->value_str ?? $project_input->value_text;
            $to = $payload['value_str'] ?? $payload['value_text'];

            if($from != $to){
                ProjectLog::create([
                    'project_id'       => $payload['project_id'],
                    'record_id'        => $payload['record_id'],
                    'project_input_id' => $project_input->id,
                    'input_id'         => $project_input->input_id,
                    'user_id'          => $auth['id'],
                    'value_from'       => $from,
                    'value_then'       => $to,
                    'is_creator'       => 0,
                ]);
            }
        }
    }

    public function list(Request $request){
        $user = $request->user();

        $user_institutions = UserInstitution::whereUserId($user->id)->pluck('institution_id');

        $data = Record::whereProjectId($request->project_id)
            ->whereIn('institution_id', $user_institutions->toArray())
            ->get();

        $this->response['result'] = $data;
        return $data;
    }

    public function record_project($id){

    }

    public function record_report($record_id){
        $record = Record::find($record_id);
        if(!$record){
            $this->response['status'] = false;
            $this->response['text'] = 'Record tidak ditemukan.';
            return $this->response;
        }

        $categories = Category::whereParentId($record->category_id)
            ->whereProjectId($record->project_id)
            ->get();

        $sub_cats = Category::whereIn('parent_id', $categories->pluck('id'))
            ->get();

        $cat_ids = $categories->merge($sub_cats)->pluck('id');

        $inputs = Input::whereIn('category_id', $cat_ids)
            ->get();

        $project_input = ProjectInput::whereRecordId($record_id)
            ->get();

        foreach ($inputs as $input){
            $input->setAttribute('project_input', $project_input->where('input_id', $input->id)->first());
        }

        foreach ($sub_cats as $cat){
            $cat->setAttribute('input', $inputs->where('category_id', $cat->id)->flatten());
        }

        foreach ($categories as $category) {
            $category->setAttribute('input', $inputs->where('category_id', $category->id)->flatten());
            $category->setAttribute('sub_categories', $sub_cats->where('parent_id', $category->id)->flatten());
        }

        $this->response['result'] = $categories;
        return $this->response;
    }

    public function checkbox_input($project_input, $request){
        if(!$project_input){
            return $request->value;
        }

        $recent_value = $project_input->value_text;
        if($request->checked){
            $recent_value = $recent_value . ',' . $request->value;
        }else{
            $exploded = explode(',', $recent_value);
            $recent_value = array_diff( $exploded, [$request->value]);
            $recent_value = implode(',', $recent_value);
        }

        return $recent_value;
    }
}
