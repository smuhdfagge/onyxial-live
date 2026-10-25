<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProjectController extends ResourceController
{
    protected string $model = Project::class;
    protected string $route = 'admin.projects';
    protected string $title = 'Projects';
    protected string $singular = 'project';
    protected string $icon = 'folder';
    protected ?string $publicRoute = 'projects.show';
    protected array $searchable = ['title', 'client', 'summary'];

    protected function query()
    {
        return Project::with('category')->ordered();
    }

    protected function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Project title', 'type' => 'text', 'required' => true],
            ['name' => 'slug', 'label' => 'Web address', 'type' => 'slug', 'prefix' => '/portfolio/', 'help' => 'Leave blank to create it from the title.'],
            ['name' => 'summary', 'label' => 'Short summary', 'type' => 'textarea', 'rows' => 3, 'help' => 'Shown on project cards and at the top of the page.'],
            ['name' => 'background', 'label' => 'The background', 'type' => 'richtext'],
            ['name' => 'solution', 'label' => 'Our approach', 'type' => 'richtext'],
            ['name' => 'facts', 'label' => 'Extra project details', 'type' => 'facts', 'help' => 'Optional label and value pairs, e.g. "Concession" / "30 years".'],
            ['name' => 'image', 'label' => 'Main image', 'type' => 'image', 'folder' => 'projects', 'section' => 'side'],
            ['name' => 'project_category_id', 'label' => 'Sector', 'type' => 'select', 'options' => ['' => '— None —'] + ProjectCategory::orderBy('sort_order')->pluck('name', 'id')->all(), 'section' => 'side'],
            ['name' => 'client', 'label' => 'Client', 'type' => 'text', 'section' => 'side'],
            ['name' => 'location', 'label' => 'Location', 'type' => 'text', 'section' => 'side'],
            ['name' => 'start_date', 'label' => 'Start date', 'type' => 'date', 'section' => 'side'],
            ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => Project::STATUSES, 'section' => 'side', 'required' => true],
            ['name' => 'sort_order', 'label' => 'Display order', 'type' => 'number', 'default' => 0, 'section' => 'side'],
            ['name' => 'is_featured', 'label' => 'Feature on home page', 'type' => 'checkbox', 'section' => 'side'],
            ['name' => 'is_published', 'label' => 'Show on website', 'type' => 'checkbox', 'section' => 'side', 'default' => true],
            ['name' => 'meta_title', 'label' => 'SEO title', 'type' => 'text', 'section' => 'seo', 'max' => 70],
            ['name' => 'meta_description', 'label' => 'SEO description', 'type' => 'textarea', 'rows' => 3, 'section' => 'seo', 'max' => 170],
        ];
    }

    protected function rules(?Model $item): array
    {
        return [
            'title' => ['required', 'string', 'max:190'],
            'project_category_id' => ['nullable', 'exists:project_categories,id'],
        ];
    }

    protected function beforeSave(Request $request, Model $item): void
    {
        $item->project_category_id = $request->input('project_category_id') ?: null;
    }

    protected function columns(): array
    {
        return [
            ['key' => 'image', 'label' => '', 'type' => 'image'],
            ['key' => 'title', 'label' => 'Project', 'type' => 'title', 'sub' => 'client'],
            ['key' => 'category.name', 'label' => 'Sector'],
            ['key' => 'status', 'label' => 'Status', 'type' => 'badge'],
            ['key' => 'is_featured', 'label' => 'Featured', 'type' => 'bool', 'yes' => 'Featured', 'no' => '—'],
            ['key' => 'is_published', 'label' => 'Visible', 'type' => 'bool'],
        ];
    }

    protected function extraPartial(Model $item): ?array
    {
        return $item->exists ? ['admin.projects._images', ['project' => $item->load('images')]] : null;
    }

    protected function beforeDelete(Model $item): void
    {
        foreach ($item->images as $img) {
            $this->deleteUpload($img->path);
        }
    }

    public function addImages(Request $request, Project $project)
    {
        $request->validate([
            'photos' => ['required', 'array', 'max:20'],
            'photos.*' => ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:6144'],
        ], ['photos.required' => 'Choose at least one photo to upload.']);

        $next = (int) $project->images()->max('sort_order');
        foreach ($request->file('photos') as $file) {
            $project->images()->create([
                'path' => $this->storeUpload($file, 'projects/'.$project->slug),
                'sort_order' => ++$next,
            ]);
        }

        return back()->with('success', 'Photos added.')->withFragment('photos');
    }

    public function updateImage(Request $request, Project $project, ProjectImage $image)
    {
        abort_unless($image->project_id === $project->id, 404);
        $data = $request->validate([
            'caption' => ['nullable', 'string', 'max:190'],
            'sort_order' => ['nullable', 'integer'],
        ]);
        $image->update(['caption' => $data['caption'] ?? null, 'sort_order' => $data['sort_order'] ?? $image->sort_order]);

        return back()->with('success', 'Photo updated.')->withFragment('photos');
    }

    public function deleteImage(Project $project, ProjectImage $image)
    {
        abort_unless($image->project_id === $project->id, 404);
        $this->deleteUpload($image->path);
        $image->delete();

        return back()->with('success', 'Photo removed.')->withFragment('photos');
    }
}
