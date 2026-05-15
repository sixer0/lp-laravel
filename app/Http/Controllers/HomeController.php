<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Landing page with Bootstrap layout
     */
    public function index(): View
    {
        // Load projects from JSON/Sitejet if available
        $projects = Project::active()
            ->orderBy('order', 'asc')
            ->get()
            ->map(function($p) {
                return (object)[
                    'id' => $p->id,
                    'name' => $p->name,
                    'slug' => $p->slug,
                    'description' => $p->description,
                    'introduction' => $p->description,
                    'image' => $p->image_url,
                    'link' => url("/project/{$p->slug}"),
                    'hours_tag' => $p->hours_tag,
                    'price_tag' => $p->price_tag,
                ];
            });

        // Fallback to XML data if no DB records
        if ($projects->isEmpty()) {
            $projects = $this->loadProjectsFromXml();
        }

        return view('layouts.guest', compact('projects'));
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
    protected function loadProjectsFromXml(): \Illuminate\Support\Collection
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

            return collect((array)$xml->channel->item)->map(function($item, $index) {
                return (object)[
                    'id' => $index + 1,
                    'name' => (string) $item->title,
                    'slug' => strtolower(str_replace([' ', '-'], '-', (string) $item->title)),
                    'description' => strip_tags((string) $item->description) ?: 'No description available.',
                    'introduction' => 'No description available.',
                    'image' => (string) $item->enclosure['url'],
                    'link' => (string) $item->link,
                    'hours_tag' => null,
                    'price_tag' => null,
                ];
            });
        } catch (\Exception $e) {
            \Log::error('Failed to load XML projects: ' . $e->getMessage());
            return collect([]);
        }
    }
}
