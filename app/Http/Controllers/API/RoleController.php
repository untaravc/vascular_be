<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $dataContent = Role::withCount('users')->orderBy('name');
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

    public function list(){
        $this->response['result'] = Role::where('id', '!=', 1)
            ->orderBy('name')->get();
        return $this->response;
    }
}
