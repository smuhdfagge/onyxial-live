<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProjectCategory;
use Illuminate\Database\Eloquent\Model;

class ProjectCategoryController extends ResourceController
{
    protected string $model = ProjectCategory::class;
    protected string $route = 'admin.project-categories';
    protected string $title = 'Project sectors';
    protected string $singular = 'sector';
    protected string $icon = 'tag';
    protected array $searchable = ['name'];
    protected ?string $intro = 'Sectors group projects on the Our Projects page and give each group its own page (/portfolio_group/…).';

    protected function query()
    {
        return ProjectCategory::withCount('projects')->orderBy('sort_order')->orderBy('name');
    }

    protected function fields(): array
    {
        return [
            ['name' => 'name', 'label' => 'Sector name', 'type' => 'text', 'required' => true],
            ['name' => 'slug', 'label' => 'Web address', 'type' => 'slug', 'from' => 'name', 'prefix' => '/portfolio_group/'],
            ['name' => 'sort_order', 'label' => 'Display order', 'type' => 'number', 'default' => 0],
        ];
    }

    protected function columns(): array
    {
        return [
            ['key' => 'name', 'label' => 'Sector', 'type' => 'title'],
            ['key' => 'slug', 'label' => 'Address'],
            ['key' => 'projects_count', 'label' => 'Projects'],
            ['key' => 'sort_order', 'label' => 'Order'],
        ];
    }

    protected function rules(?Model $item): array
    {
        return ['name' => ['required', 'string', 'max:190']];
    }
}
