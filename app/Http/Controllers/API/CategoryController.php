<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Input;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $dataContent = Category::orderBy('name');
        $dataContent = $this->withFilter($dataContent, $request);
        $dataContent = $dataContent->paginate(20);

        $result = collect($this->response);
        return $result->merge($dataContent);
    }

    public function withFilter($dataContent, $request)
    {
        return $dataContent;
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if($user->role_id != 1){
            $this->response['status'] = false;
            $this->response['text'] = "Unauthorized";
            return $this->response;
        }

        $this->validateData($request);

        Category::create($request->all());
        return $this->response;
    }

    public function validateData($request)
    {
        $request->validate([
            'project_id' => 'required',
            'name'       => 'required',
            'label'      => 'required',
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        if($user->role_id != 1){
            $this->response['status'] = false;
            $this->response['text'] = "Unauthorized";
            return $this->response;
        }

        $this->validateData($request);

        $project = Category::find($request->id);

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
        $project = Category::find($id);

        $this->response['result'] = $project;
        return $this->response;
    }

    public function destroy($id, Request $request){
        $user = $request->user();
        if($user->role_id != 1){
            $this->response['status'] = false;
            $this->response['text'] = "Unauthorized";
            return $this->response;
        }

        $input = Input::whereCategoryId($id)
            ->first();

        if($input){
            $this->response['status'] = false;
            $this->response['text'] = 'Category has input item.';
            return $this->response;
        }

        Category::find($id)->delete();

        return $this->response;
    }

    public function hierarchy(Request $request)
    {
        $categories = Category::whereProjectId($request->project_id)->get();

        $level_one = $categories->where('parent_id', 0)->flatten();

        foreach ($level_one as $one) {
            $cat_base = $categories->where('parent_id', $one->id)->flatten();
            $cat_cld = $categories->whereIn('parent_id', $cat_base->pluck('id'))->flatten();
            $cats = $cat_base->merge($cat_cld);

            $one->setAttribute('children', $cats);
        }
        $this->response['result'] = $level_one;
        return $this->response;
    }

    public function list(Request $request)
    {
        $categories = Category::when($request->project_id, function ($q) use ($request) {
            $q->whereProjectId($request->project_id)
                ->whereParentId(0);
        })->when($request->parent_id, function ($q) use ($request) {
            $q->whereParentId($request->parent_id);
        })
            ->orderBy('name')
            ->get();

        $this->response['result'] = $categories;
        return $this->response;
    }

    public function sub_list(Request $request){
        $categories = Category::orderBy('name')
            ->when($request->category_id, function ($q) use ($request) {
            $q->whereParentId($request->category_id);
        })->get();

        $this->response['result'] = $categories;
        return $this->response;
    }
}
