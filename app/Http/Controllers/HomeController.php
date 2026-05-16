<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends BaseController
{
    /**
     * Landing page with Bootstrap layout
     */
    public function index(): View
    {
        // Try database first, fallback to XML
        $projects = Project::active()
            ->orderBy('order', 'asc')
            ->get();

        // Fallback to XML data if no DB records
        if ($projects->isEmpty()) {
            $projects = $this->loadProjectsFromXml();
        }

        // Captcha defaults (JS will hydrate from /contact/captcha)
        $a = random_int(1, 9);
        $b = random_int(1, 9);
        return view('layouts.guest', compact('projects') + [
            'captcha_question' => "$a + $b",
            'captcha_hash' => md5((string)($a + $b)),
        ]);
    }

    /**
     * Individual project page
     */
    public function project($slug): View
    {
        $project = Project::where('slug', $slug)->first();

        if (!$project) {
            abort(404, 'Project not found');
        }

        return view('project.show', compact('project'));
    }

    /**
     * Load projects from Sitejet XML (fallback)
     */
    protected function loadProjectsFromXml()
    {
        $xmlPath = public_path('modules-1/2849388066.xml');

        if (!file_exists($xmlPath)) {
            return collect([]);
        }

        try {
            $xml = simplexml_load_file($xmlPath);

            if (!$xml) {
                return collect([]);
            }

            return collect((array) $xml->channel->item)->map(function ($item, $index) {
                return (object) [
                    'id' => $index + 1,
                    'name' => (string) $item->title,
                    'slug' => strtolower(str_replace([' ', '-'], '-', (string) $item->title)),
                    'description' => strip_tags((string) $item->description) ?: 'No description available.',
                    'image' => (string) $item->enclosure['url'],
                    'project_url' => (string) $item->link,
                ];
            });
        } catch (\Exception $e) {
            \Log::error('Failed to load XML projects: ' . $e->getMessage());
            return collect([]);
        }
    }
}
