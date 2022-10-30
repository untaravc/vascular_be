<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuRole;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuRoleController extends Controller
{
    public function index()
    {
        $menus = Menu::get();
        $menu_roles = MenuRole::get();

        foreach ($menus as $menu) {
            $roles = Role::get();
            foreach ($roles as $role) {
                $is_checked = $menu_roles->where('role_id', $role->id)
                    ->where('menu_id', $menu->id)
                    ->first();

                if ($is_checked) {
                    $role['is_checked'] = 1;
                } else {
                    $role['is_checked'] = 0;
                }
            }
            $menu->setAttribute('role', $roles);
        }

        $projects = [
            ['id'=> '1001','name' => 'Project Input'],
            ['id'=> '1002','name' => 'Project Records'],
            ['id'=> '1003','name' => 'Project Reports'],
            ['id'=> '1004','name' => 'Project Logs'],
            ['id'=> '1005','name' => 'Project Export Data'],
            ['id'=> '1006','name' => 'Project Setup'],
        ];

        for ($i = 0; $i < count($projects); $i++){
            $roles = Role::get();
            foreach ($roles as $role) {
                $is_checked = $menu_roles->where('role_id', $role->id)
                    ->where('menu_id', $projects[$i]['id'])
                    ->first();

                if ($is_checked) {
                    $role['is_checked'] = 1;
                } else {
                    $role['is_checked'] = 0;
                }
            }
            $projects[$i]['role'] = $roles;
        }

        $this->response['result'] = $menus;
        $this->response['roles'] = $roles;
        $this->response['project'] = $projects;
        return $this->response;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_checked' => 'required',
            'menu_id'    => 'required',
            'role_id'    => 'required',
        ]);

        if($validator->fails()){
            $this->response['status'] = false;
            return $this->response;
        }

        $menu_role = MenuRole::whereMenuId($request->menu_id)
            ->whereRoleId($request->role_id)
            ->first();

        if($request->is_checked){
            if(!$menu_role){
                $menu_role = MenuRole::create([
                    'menu_id' => $request->menu_id,
                    'role_id' => $request->role_id,
                ]);
            }
        }else{
            if($menu_role){
                $menu_role->delete();
            }
        }

        return $this->response;
    }
}
