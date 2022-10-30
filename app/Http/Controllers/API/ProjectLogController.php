<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProjectLog;
use Illuminate\Http\Request;

class ProjectLogController extends Controller
{
    public function show(Request $request, $id){
        $query['date'] = $request->date ?? date('Y-m-d');
        if($request->nav != 0){
            $query['date'] = date('Y-m-d', strtotime($query['date'] . ' '.$request->nav . 'days'));
        }
        $data = ProjectLog::whereProjectId($id)
            ->with('user', 'input')
            ->orderByDesc('id')
            ->limit(100)
            ->whereDate('created_at', $query['date'])
            ->get();

        $this->response['result'] = $data;
        $this->response['query'] = $query;
        return $this->response;
    }
}
