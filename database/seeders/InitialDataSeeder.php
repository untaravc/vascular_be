<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Input;
use App\Models\Institution;
use App\Models\Menu;
use App\Models\MenuRole;
use App\Models\Patient;
use App\Models\Project;
use App\Models\Record;
use App\Models\Role;
use Illuminate\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // institusi
        $institutions = $this->institutions();
        foreach ($institutions as $institution) {
            Institution::create($institution);
        }

        // menu
        $menus = $this->menu();
        foreach ($menus as $menu) {
            try{
                Menu::create($menu);
            }catch (\Exception $e){}
        }

        // kategori
        $categories = $this->categories();
        foreach ($categories as $category) {
            try{
                Category::create($category);
            }catch (\Exception $e){}
        }

        // role
        $roles = $this->role();
        foreach ($roles as $role) {
            try{
                Role::create($role);
            }catch (\Exception $e){}
        }

        // role
        $menu_roles = $this->menu_role();
        foreach ($menu_roles as $menu_role) {
            try{
                MenuRole::create($menu_role);
            }catch (\Exception $e){}
        }

        // project
        $projects = $this->projects();
        foreach ($projects as $project) {
            try{
                Project::create($project);
            }catch (\Exception $e){}
        }
    }

    private function role()
    {
        return [
            [
                'id'   => 1,
                'name' => 'superadmin',
                'desc' => 'Super Admin',
            ],
            // hanya lihat data dari project tertentu
            [
                'id'   => 2,
                'name' => 'institution-admin',
                'desc' => 'Admin Institusi',
            ],
            // hanya lihat data dari project tertentu
            [
                'id'   => 3,
                'name' => 'project-admin',
                'desc' => 'Admin Project',
            ],
            // hanya lihat data yg dia input
            [
                'id'   => 4,
                'name' => 'project-input',
                'desc' => 'Project Input',
            ],
        ];
    }

    private function institutions()
    {
        return [
            [
                'name'    => 'RS Sardjito',
                'address' => 'Yogyakarta',
                'status'  => 1,
            ],
            [
                'name'    => 'Universitas Gadjah Mada',
                'address' => 'Yogyakarta',
                'status'  => 1,
            ],
        ];
    }

    private function menu()
    {
        return [
            [
                'id'        => 1,
                'name'      => 'Dashboard',
                'link'      => '/panel/home',
                'parent_id' => 0,
                'icon'      => 'dashboard',
                'status'    => 1,
            ],
            [
                'id'        => 2,
                'name'      => 'Data Master',
                'link'      => '#',
                'parent_id' => 0,
                'icon'      => 'server-alt',
                'status'    => 1,
            ],
            [
                'id'        => 3,
                'name'      => 'Project',
                'link'      => '/panel/projects',
                'parent_id' => 2,
                'icon'      => null,
                'status'    => 1,
            ],
            [
                'id'        => 4,
                'name'      => 'User',
                'link'      => '/panel/users',
                'parent_id' => 2,
                'icon'      => null,
                'status'    => 1,
            ],
            [
                'id'        => 5,
                'name'      => 'Role',
                'link'      => '/panel/roles',
                'parent_id' => 2,
                'icon'      => null,
                'status'    => 1,
            ],
            [
                'id'        => 6,
                'name'      => 'Menu Role',
                'link'      => '/panel/menu-roles',
                'parent_id' => 2,
                'icon'      => null,
                'status'    => 1,
            ],
            [
                'id'        => 7,
                'name'      => 'Patients',
                'link'      => '/panel/patients',
                'parent_id' => 2,
                'icon'      => null,
                'status'    => 1,
            ],
            [
                'id'        => 8,
                'name'      => 'Institusi',
                'link'      => '/panel/institutions',
                'parent_id' => 2,
                'icon'      => null,
                'status'    => 1,
            ],
            [
                'id'        => 9,
                'name'      => 'Menu',
                'link'      => '/panel/menus',
                'parent_id' => 2,
                'icon'      => null,
                'status'    => 1,
            ],
        ];
    }

    private function menu_role()
    {
        return [
            ['role_id' => 1, 'menu_id' => 1],
            ['role_id' => 1, 'menu_id' => 2],
            ['role_id' => 1, 'menu_id' => 3],
            ['role_id' => 1, 'menu_id' => 4],
            ['role_id' => 1, 'menu_id' => 5],
            ['role_id' => 1, 'menu_id' => 6],
            ['role_id' => 1, 'menu_id' => 7],
            ['role_id' => 1, 'menu_id' => 8],
            ['role_id' => 1, 'menu_id' => 9],
            ['role_id' => 1, 'menu_id' => 1001],
            ['role_id' => 1, 'menu_id' => 1002],
            ['role_id' => 1, 'menu_id' => 1003],
            ['role_id' => 1, 'menu_id' => 1004],
            ['role_id' => 1, 'menu_id' => 1005],
            ['role_id' => 1, 'menu_id' => 1006],

            ['role_id' => 2, 'menu_id' => 1],
            ['role_id' => 2, 'menu_id' => 2],
            ['role_id' => 2, 'menu_id' => 3],
            ['role_id' => 2, 'menu_id' => 5],
            ['role_id' => 2, 'menu_id' => 6],
            ['role_id' => 2, 'menu_id' => 1001],
            ['role_id' => 2, 'menu_id' => 1002],
            ['role_id' => 2, 'menu_id' => 1003],
            ['role_id' => 2, 'menu_id' => 1004],
            ['role_id' => 2, 'menu_id' => 1005],
            ['role_id' => 2, 'menu_id' => 1006],

            ['role_id' => 3, 'menu_id' => 1],
            ['role_id' => 3, 'menu_id' => 1001],
            ['role_id' => 3, 'menu_id' => 1002],
            ['role_id' => 3, 'menu_id' => 1003],
            ['role_id' => 3, 'menu_id' => 1004],
            ['role_id' => 3, 'menu_id' => 1005],
            ['role_id' => 3, 'menu_id' => 1006],

            ['role_id' => 4, 'menu_id' => 1],
            ['role_id' => 4, 'menu_id' => 1001],
            ['role_id' => 4, 'menu_id' => 1002],
            ['role_id' => 4, 'menu_id' => 1003],
            ['role_id' => 4, 'menu_id' => 1005],
        ];
    }

    private function projects()
    {
        return [
            [
                'id'             => 1,
                'name'           => 'Vascular',
                'status'         => 1,
                'role'           => null,
                'user_id'        => 1,
                'institution_id' => 1,
            ],
        ];
    }

    private function categories()
    {
        return [
            [
                'id'         => 1,
                'project_id' => 1,
                'name'       => 'ALI',
                'label'      => 'ali',
                'parent_id'  => 0,
            ],
            [
                'id'         => 2,
                'project_id' => 1,
                'name'       => 'CVI',
                'label'      => 'cvi',
                'parent_id'  => 0,
            ],
            [
                'id'         => 3,
                'project_id' => 1,
                'name'       => 'AORTA',
                'label'      => 'aorta',
                'parent_id'  => 0,
            ],
        ];
    }

    private function inputs()
    {
        return [
            [
                "name"           => "Tarif",
                "type"           => "number",
                "category_id"    => 1,
                "project_id"     => 1,
                "institution_id" => 1,
                "user_id"        => 1,
                "prefix"         => "Rp",
                "suffix"         => ",00",
                "is_currency"    => 1,
                "order"          => 1,
            ],
            [
                "name"           => "Keterangan",
                "type"           => "test",
                "category_id"    => 1,
                "project_id"     => 1,
                "institution_id" => 1,
                "user_id"        => 1,
                "prefix"         => null,
                "suffix"         => null,
                "is_currency"    => 1,
                "order"          => 1,
            ]
        ];
    }
}
