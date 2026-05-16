<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ProjectController extends AppBaseController
{
    protected function guard(Request $req): ?array
    {
        $uid = session('admin_user_id');
        return $uid ? ['uid'=>$uid, 'role'=>session('admin_role')] : null;
    }

    public function index(Request $req): Response
    {
        $g = $this->guard($req);
        if (!$g) return $this->redirectToLogin();
        $projects = Project::orderBy('order', 'asc')->get();
        return response()->view('admin.projects.list', compact('projects'), 200);
    }

    public function create(Request $req): Response
    {
        $g = $this->guard($req);
        if (!$g) return $this->redirectToLogin();
        return response()->view('admin.projects.form', [
            'project'    => null,
            'form_action'=> route('admin.projects.store'),
        ], 200);
    }

    public function store(Request $req): Response
    {
        $g = $this->guard($req);
        if (!$g) return $this->redirectToLogin();
        $data = $req->validate([
            'name'        => ['required','string','max:255'],
            'description' => ['nullable','string','max:5000'],
            'slug'        => ['nullable','string','max:255','unique:projects,slug'],
            'image'       => ['nullable','url','max:1024'],
            'project_url' => ['nullable','url','max:1024'],
            'hours_tag'   => ['nullable','string','max:80'],
            'price_tag'   => ['nullable','string','max:80'],
            'order'       => ['nullable','integer','min:0'],
            'is_active'   => ['nullable','boolean'],
        ]);
        $data['slug']       = (string) Str::slug($data['name']);
        $data['is_active']  = $req->has('is_active') ? '1' : '0';
        $data['order']      = $req->input('order', Project::max('order') + 1);
        Project::create($data);
        return redirect('/admin/projects')->with('admin_msg', 'Proyek berhasil ditambahkan.');
    }

    public function edit(Request $req, Project $project): Response
    {
        $g = $this->guard($req);
        if (!$g) return $this->redirectToLogin();
        $project = $project; // injected by route model binding
        return response()->view('admin.projects.form', [
            'project'     => $project,
            'form_action' => route('admin.projects.update', $project),
        ], 200);
    }

    public function update(Request $req, Project $project): Response
    {
        $g = $this->guard($req);
        if (!$g) return $this->redirectToLogin();
        $project = $project; // injected by route model binding
        $data = $req->validate([
            'name'        => ['required','string','max:255'],
            'description' => ['nullable','string','max:5000'],
            'slug'        => ['nullable','string','max:255',"unique:projects,slug,".$project->id],
            'image'       => ['nullable','url','max:1024'],
            'project_url' => ['nullable','url','max:1024'],
            'hours_tag'   => ['nullable','string','max:80'],
            'price_tag'   => ['nullable','string','max:80'],
            'order'       => ['nullable','integer','min:0'],
            'is_active'   => ['nullable','boolean'],
        ]);
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        $project->update($data);
        return redirect('/admin/projects')->with('admin_msg', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Request $req, Project $project): Response
    {
        $g = $this->guard($req);
        if (!$g) return $this->redirectToLogin();
        $project->delete();
        return back()->with('admin_msg', 'Proyek dihapus.');
    }

    protected function redirectToLogin(): Response
    {
        return redirect('/admin/login');
    }
}
