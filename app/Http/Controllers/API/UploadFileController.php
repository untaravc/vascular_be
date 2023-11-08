<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UploadFileController extends Controller
{
    public function store(Request $request)
    {
        $this->validateData($request);

        $folder = isset($request->model) ? $request->model : 'files';

        $link = $this->fileUploadProcessing($request, $folder . '/' . date('Ymd'), 'file', true);
        $link = env('APP_URL') . 'storage/' . $link;

        $this->response['result'] = [
            'link' => $link,
            'title' => $request->title,
        ];

        return $this->response;
    }

    public function validateData(Request $request)
    {
        $allowed_file = 'jpg,jpeg,png,pdf';

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:' . $allowed_file,
        ]);

        if ($validator->fails()) {
            $this->response['status'] = false;
            $this->response['errors'] = $validator->errors();
            $this->response['message'] = $validator->errors()->first();
            abort(response($this->response, 422));
        }
    }

    public function fileUploadProcessing(Request $request, $folder_name = 'files', $file_container = 'file', $hashed = false)
    {
        $attachment = 'no image';
        if ($request->hasFile($file_container)) {
            $filenameWithExt = $request->file($file_container)->getClientOriginalName();

            if ($hashed) {
                $filename = Str::random(30);
            } else {
                $filename = str_replace(' ', '_', strtolower(pathinfo($filenameWithExt, PATHINFO_FILENAME)));
            }
            $extension = $request->file($file_container)->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            $attachment = $request->file($file_container)->storeAs($folder_name, $fileNameToStore);
        }

        return $attachment;
    }
}
