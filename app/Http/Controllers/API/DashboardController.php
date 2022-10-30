<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function stats()
    {
        $projects = Project::whereStatus(1)
            ->withCount('records')->get();

        $base_cat = Category::whereParentId(0)
            ->whereIn('project_id', $projects->pluck('id'))
            ->withCount('records')
            ->get();

        foreach ($projects as $project) {
            $project->setAttribute('categories', $base_cat->where('project_id', $project->id)->flatten());
        }

        $this->response['result'] = $projects;
        return $this->response;
    }

    public function user()
    {
        $auth = Auth::guard()->user();
        switch ($auth['role_id']) {
            case 1:
                $users = User::with('role')->limit(10)
                    ->get();
                break;
            default:
                $users = User::with('role')
                    ->where('role_id', '>', 1)
                    ->limit(10)
                    ->get();
        }

        $this->response['result'] = $users;
        return $this->response;
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        $this->response['result'] = $user;
        return $this->response;
    }

    public function update_profile(Request $request)
    {
        $user = User::find($request->user()['id']);

        if ($request->password) {
            $request->validate([
                'password' => 'confirmed',
            ]);
        }

        $request->validate([
            'name'  => 'required',
            'email' => 'email',
        ]);

        if ($user) {
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            if ($request->password) {
                $user->update([
                    'password' => $request->password,
                ]);
            }
        }

        $this->response['text'] = 'Profile updated';
        return $this->response;
    }
}
