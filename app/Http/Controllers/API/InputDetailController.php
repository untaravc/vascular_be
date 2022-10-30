<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\InputDetail;
use Illuminate\Http\Request;

class InputDetailController extends Controller
{
    public function index(Request $request)
    {
        $data_content = InputDetail::whereInputId($request->input_id)
            ->get();

        $this->response['result'] = $data_content;
        return $this->response;
    }

    public function store(Request $request)
    {
        $this->validateData($request);

        InputDetail::create($request->all());

        return $this->response;
    }

    public function update(Request $request, $id){
        $this->validateData($request);

        $input_detail = InputDetail::find($id);

        if($input_detail){
            $input_detail->update($request->all());
        }

        return $this->response;
    }

    public function destroy($id)
    {
        $detail = InputDetail::find($id);

        if ($detail) {
            $detail->delete();
        }

        return $this->response;
    }

    public function validateData($request)
    {
        $request->validate([
            'input_id'   => 'required',
            'input_type' => 'required',
            'name'       => 'required',
            'value'      => 'required',
        ]);
    }
}
