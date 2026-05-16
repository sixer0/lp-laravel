<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Models\Project;
use App\Models\ContactSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DashboardController extends AppBaseController
{
    protected function guard(Request $req): ?array
    {
        return session('admin_user_id') ? ['uid'=>session('admin_user_id'), 'role'=>session('admin_role')] : null;
    }

    protected function redirectToLogin(): Response
    {
        return redirect('/admin/login');
    }

    public function show(Request $req): Response
    {
        $g = $this->guard($req);
        if (!$g) return $this->redirectToLogin();

        $stats = [
            'projects_total'    => Project::count(),
            'projects_active'   => Project::where('is_active', true)->count(),
            'messages_unread'   => ContactSubmission::where('status', 'new')->count(),
            'messages_total'    => ContactSubmission::count(),
            'users_total'       => User::count(),
            'recent_projects'   => Project::latest()->take(5)->get(),
            'recent_messages'   => ContactSubmission::latest()->take(5)->get(),
        ];

        return response()->view('admin.dashboard', array_merge($stats, [
            'admin_user' => ['id'=>session('admin_user_id'), 'name'=>session('admin_name'), 'role'=>session('admin_role')],
        ]), 200);
    }
}
