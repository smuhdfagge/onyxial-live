<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Support\Seo;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        return $this->listing(null);
    }

    public function category(ProjectCategory $category)
    {
        return $this->listing($category);
    }

    protected function listing(?ProjectCategory $active)
    {
        $page = Page::for('projects');

        $categories = ProjectCategory::whereHas('projects', fn ($q) => $q->published())
            ->orderBy('sort_order')->orderBy('name')->get();

        $projects = Project::published()->with('category')
            ->when($active, fn ($q) => $q->where('project_category_id', $active->id))
            ->ordered()->get();

        $seo = Seo::forPage('projects')->crumb($page?->title ?? 'Our Projects', route('projects.index'));
        if ($active) {
            $seo->title($active->name.' Projects')
                ->description('Onyx Investment Advisory projects in '.$active->name.'.')
                ->crumb($active->name, route('projects.category', $active));
        }

        return view('site.projects.index', compact('page', 'seo', 'categories', 'projects', 'active'));
    }

    public function show(Project $project)
    {
        abort_unless($project->is_published, 404);
        $project->load('category', 'images');
        $project->setRelation('images', $project->images->filter(fn ($i) => has_media($i->path))->values());

        $seo = Seo::make()
            ->title($project->meta_title ?: $project->title)
            ->description($project->meta_description ?: ($project->summary ?: $project->background))
            ->image($project->image)
            ->type('article')
            ->crumb('Our Projects', route('projects.index'))
            ->crumb($project->title, $project->url())
            ->schema(array_filter([
                '@context' => 'https://schema.org',
                '@type' => 'CreativeWork',
                'name' => $project->title,
                'description' => plain_excerpt($project->summary ?: $project->background, 300),
                'url' => $project->url(),
                'image' => media_url($project->image),
                'dateCreated' => $project->start_date?->toDateString(),
                'about' => $project->category?->name,
                'creator' => ['@id' => url('/').'#organization'],
            ]));

        $all = Project::published()->ordered()->get(['id', 'title', 'slug']);
        $index = $all->search(fn ($p) => $p->id === $project->id);
        $prev = $index !== false && $index > 0 ? $all[$index - 1] : null;
        $next = $index !== false && $index < $all->count() - 1 ? $all[$index + 1] : null;

        $related = Project::published()->with('category')->where('id', '!=', $project->id)->ordered()->take(3)->get();

        return view('site.projects.show', compact('project', 'seo', 'prev', 'next', 'related'));
    }
}
