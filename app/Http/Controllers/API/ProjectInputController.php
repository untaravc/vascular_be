<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Input;
use App\Models\InputDetail;
use App\Models\ProjectInput;
use App\Models\ProjectLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectInputController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id'  => 'required',
            'category_id' => 'required',
            'record_id'   => 'required'
        ]);

        if($validator->fails()){
            $this->response['status'] = false;
            return $this->response;
        }

        $input = Input::whereProjectId($request->project_id)
            ->whereCategoryId($request->category_id)
            ->whereStatus(1)
            ->get();

        $input_details = InputDetail::whereIn('input_id', $input->pluck('id'))
            ->get();

        $project_input = ProjectInput::whereIn('input_id', $input->pluck('id'))
            ->whereRecordId($request->record_id)
            ->get();

        foreach ($input as $item) {
            $value = $project_input->where('input_id', $item->id)->first();
            if($item->type === 'checkbox'){
                if($value){
                    $checkbox_value = explode(',', $value->value_text);
                }else{
                    $checkbox_value = [];
                }

                foreach ($input_details->where('input_id', $item->id) as $detail){

                    $detail->setAttribute('checked', in_array($detail->value, $checkbox_value));
                }
            }

            $item->setAttribute('children', $input_details->where('input_id', $item->id)->flatten());


            if($value){
                $the_value = $value['value_str'] ?: $value['value_text'] ?: null;
                $item->setAttribute('value', $the_value);
            }else{
                $item->setAttribute('value', null);
            }
        }

        $categories = Category::whereParentId($request->category_id)->get();
        $category_inputs = null;
        if($categories->count() > 0){
            $category_inputs = $this->set_category_input($request->project_id, $categories, $request->record_id);
        }

        $this->response['result'] = $input;
        $this->response['categories'] = $category_inputs;
        return $this->response;
    }

    public function store(Request $request)
    {
        $validator = $this->validateData($request);
        if (!$validator['status']) {
            return $validator;
        }

        $input_ids = collect($validator['result'])->pluck('input_id');

        $inputs = Input::whereIn('id', $input_ids)->get();

        foreach ($validator['result'] as $input) {
            $input_prop = $inputs->where('id', $input['input_id'])->first();

        }
    }

    private function validateData($request)
    {
        $inputs = $request->all();
        $status = true;
        for ($i = 0; $i < count($inputs); $i++) {
            if (!isset($inputs[$i]['input_id']) || $inputs[$i]['input_id'] == null) {
                $inputs[$i]['error'] = 'Input id harus diisi.';
                $status = false;
            } else if (!isset($inputs[$i]['record_id']) || $inputs[$i]['record_id'] == null) {
                $inputs[$i]['error'] = 'Record id harus diisi.';
                $status = false;
            } else {
                $inputs[$i]['error'] = null;
            }
        }

        return [
            'status' => $status,
            'result' => $inputs,
        ];
    }

    public function input_logs(Request $request){
        $data['project_logs'] = ProjectLog::with('user')
            ->whereInputId($request->input_id)
            ->whereRecordId($request->record_id)
            ->get();

        $data['input'] = Input::find($request->input_id);

        $this->response['result'] = $data;
        return $this->response;
    }

    private function set_category_input($project_id, $categories, $record_id){
        $input = Input::whereProjectId($project_id)
            ->whereIn('category_id', $categories->pluck('id'))
            ->get();

        $input_details = InputDetail::whereIn('input_id', $input->pluck('id'))
            ->get();

        foreach ($input as $item) {
            $item->setAttribute('children', $input_details->where('input_id', $item->id)->flatten());
        }

        $project_input = ProjectInput::whereIn('input_id', $input->pluck('id'))
            ->whereRecordId($record_id)
            ->get();

        foreach ($input as $item){
            $value = $project_input->where('input_id', $item->id)->first();

            if($value){
                $the_value = $value['value_str'] ?: $value['value_text'] ?: null;
                $item->setAttribute('value', $the_value);
            }else{
                $item->setAttribute('value', null);
            }
        }

        foreach ($categories as $category){
            $category->setAttribute('inputs', $input->where('category_id', $category->id)->flatten());
        }

        return $categories;
    }
}
