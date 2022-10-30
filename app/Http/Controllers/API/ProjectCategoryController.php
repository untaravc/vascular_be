<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ProjectCategoryController extends Controller
{
    public function index($project_id)
    {
        $data = Category::whereProjectId($project_id)->get();

        $level_one = $data->where('parent_id', 0);
        foreach ($level_one as $one) {
            $one->setAttribute('children', $data->where('parent_id', $one->id)->flatten());
        }

        $this->response['result'] = $level_one;
        return $this->response;
    }

    public function create(Request $request, $project_id)
    {
        $this->validateData($request);

        $category = Category::create([
            'project_id' => $project_id,
            'parent_id'  => $request->parent_id,
            'name'       => $request->name,
            'label'      => $this->create_label($request->name),
        ]);

        $this->response['result'] = $category;
        return $this->response;
    }

    public function validateData($request)
    {
        $request->validate([
            'name' => 'required',
        ]);
    }

    private function create_label($name)
    {
        return str_replace(' ', '_', strtolower($name));
    }

    public function update(Request $request, $project_id, $category_id)
    {
        $this->validateData($request);

        $category = Category::whereProjectId($project_id)
            ->find($category_id);

        if (!$category) {
            $this->response['status'] = false;
            $this->response['text'] = 'No data.';
        }

        $category->update([
            'name'      => $request->name,
            'parent_id' => $request->parent_id,
            'label'     => $this->create_label($request->name),
        ]);

        return $this->response;
    }

    public function destroy($project_id, $category_id){
        // cek question

        // cek children
        $category_children = Category::whereProjectId($project_id)
            ->whereParentId($category_id)
            ->count();

        if($category_children > 0){
            $this->response['status'] = false;
            $this->response['text'] = 'Has children';
            return $this->response;
        }

        $cat = Category::whereProjectId($project_id)
            ->find($category_id);

        if($cat){
            $cat->delete();
        }

        return $this->response;
    }
}
