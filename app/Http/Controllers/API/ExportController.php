<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Input;
use App\Models\Project;
use App\Models\ProjectInput;
use App\Models\Record;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function list(Request $request)
    {
        $request->validate([
            'category_parent_id' => 'required',
            'project_id'         => 'required',
        ]);

        $data['categories'] = Category::whereParentId($request->category_parent_id)
            ->get();

        $inputs = Input::whereProjectId($request->project_id)
            ->whereIn('category_id', $data['categories']->pluck('id'))
            ->orderBy('category_id')
            ->orderBy('order')
            ->get();

        foreach ($data['categories'] as $cat){
            $cat->setAttribute('inputs', $inputs->where('category_id', $cat->id)->flatten());
        }

        $this->response['result'] = $data;
        return $this->response;
    }

    public function export(Request $request){
        $input_ids = $request->input_ids;

        $records = Record::whereProjectId($request->project_id)
            ->get();

        $project_input = ProjectInput::whereProjectId($request->project_id)
            ->whereIn('input_id',$input_ids)
            ->get();

        foreach ($records as $record){
            $inputs = Input::whereIn('id', $input_ids)->orderBy('id')->get();
            foreach ($inputs as $input){
                $input->setAttribute('value',
                    $project_input
                        ->where('record_id', $record->id)
                        ->where('input_id', $input->id)
                        ->first()
                );
            }

            $record->setAttribute('inputs', $inputs);
        }

        $this->response['fields'] = $inputs;
        $this->response['result'] = $records;
        return $this->response;
    }
}
