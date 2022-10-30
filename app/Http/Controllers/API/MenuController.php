<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuRole;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $dataContent = Menu::orderBy('name');
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
        $this->validateData($request);

        Menu::create($request->all());
        return $this->response;
    }

    public function validateData($request)
    {
        $request->validate([
            'name'    => 'required',
            'address' => 'nullable',
            'status'  => 'required',
        ]);
    }

    public function update(Request $request)
    {
        $this->validateData($request);

        $institution = Menu::find($request->id);

        if ($institution) {
            $institution->update($request->all());
            $this->response['text'] = 'Updated!';
            return $this->response;
        } else {
            $this->response['status'] = false;
            $this->response['text'] = 'No User';
            return $this->response;
        }
    }

    public function show($id)
    {
        $institution = Menu::find($id);

        $this->response['result'] = $institution;
        return $this->response;
    }

    public function destroy($id)
    {
        $institution = Menu::find($id);

        if ($institution) {
            $institution->delete();
        }

        return $this->response;
    }

    public function menu()
    {
        $auth = Auth::guard()->user();
        $role_id = $auth['role_id'];

        $menu_role_ids = MenuRole::whereRoleId($role_id)
            ->pluck('menu_id');

        $menus = Menu::whereIn('id', $menu_role_ids)
            ->get();

        $data['menu'] = $menus->where('parent_id', 0)->flatten();

        foreach ($data['menu'] as $main_menu) {
            $submenu = $menus->where('parent_id', $main_menu['id'])->flatten();
            if (count($submenu) > 0) {
                $height = count($submenu) * 40;
                $main_menu->setAttribute('children', $submenu);
                $main_menu->setAttribute('height', $height);
            } else {
                $main_menu->setAttribute('children', null);
            }
        }

        $projects = Project::orderBy('name')
            ->whereStatus(1)
            ->get();

        $project_menu = [];
        foreach ($projects as $project) {
            $child_menu = [];
            $array_id = $menu_role_ids->toArray();
            if(in_array('1001', $array_id)){
                $child_menu[] = [
                    "id"=> 'p'.$project->id.'-inputs',
                    "name"=> "Input",
                    "link"=> "/panel/p/" . $project->id .'/inputs',
                ];
            }

            if(in_array('1002', $array_id)){
                $child_menu[] = [
                    "id"=> 'p'.$project->id.'-records',
                    "name"=> "Records",
                    "link"=> "/panel/p/" . $project->id .'/records',
                ];
            }

            if(in_array('1003', $array_id)){
                $child_menu[] = [
                    "id"=> 'p'.$project->id.'-reports',
                    "name"=> "Reports",
                    "link"=> "/panel/p/" . $project->id .'/reports',
                ];
            }

            if(in_array('1004', $array_id)){
                $child_menu[] = [
                    "id"=> 'p'.$project->id.'-logs',
                    "name"=> "Logs",
                    "link"=> "/panel/p/" . $project->id .'/logs',
                ];
            }

            if(in_array('1005', $array_id)){
                $child_menu[] = [
                    "id"=> 'p'.$project->id.'-setup',
                    "name"=> "Export Data",
                    "link"=> "/panel/p/" . $project->id .'/exports',
                ];
            }

            if(in_array('1006', $array_id)){
                $child_menu[] = [
                    "id"=> 'p'.$project->id.'-setup',
                    "name"=> "Setup",
                    "link"=> "/panel/p/" . $project->id .'/setup',
                ];
            }

            $project_menu[] = [
                "id"        => 'p-' . $project->id,
                "name"      => $project->name,
                "link"      => "#",
                "icon"      => "clipboard-notes",
                "children"  => $child_menu,
            ];
        }

        $data['projects'] = $project_menu;

        $this->response['result'] = $data;
        return $this->response;
    }
}
