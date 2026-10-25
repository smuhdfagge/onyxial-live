<?php

namespace App\Http\Controllers\Admin;

use App\Models\Redirect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RedirectController extends ResourceController
{
    protected string $model = Redirect::class;
    protected string $route = 'admin.redirects';
    protected string $title = 'Redirects';
    protected string $singular = 'redirect';
    protected string $icon = 'link';
    protected array $searchable = ['from_path', 'to_path'];
    protected ?string $intro = 'Send visitors from an old address to a new one, so old links and search results keep working. Use 301 for permanent moves.';

    protected function query()
    {
        return Redirect::query()->orderBy('from_path');
    }

    protected function fields(): array
    {
        return [
            ['name' => 'from_path', 'label' => 'Old address', 'type' => 'text', 'required' => true, 'help' => 'The path only, e.g. /old-page'],
            ['name' => 'to_path', 'label' => 'New address', 'type' => 'text', 'required' => true, 'help' => 'A path like /our-services or a full URL.'],
            ['name' => 'status_code', 'label' => 'Type', 'type' => 'select', 'options' => ['301' => '301 — permanent', '302' => '302 — temporary'], 'required' => true],
        ];
    }

    protected function rules(?Model $item): array
    {
        return [
            'from_path' => ['required', 'string', 'max:255', Rule::unique('redirects', 'from_path')->ignore($item?->id)],
            'to_path' => ['required', 'string', 'max:500'],
        ];
    }

    protected function beforeSave(Request $request, Model $item): void
    {
        $item->from_path = Redirect::normalise($request->input('from_path'));
    }

    protected function columns(): array
    {
        return [
            ['key' => 'from_path', 'label' => 'From', 'type' => 'title'],
            ['key' => 'to_path', 'label' => 'To'],
            ['key' => 'status_code', 'label' => 'Type'],
            ['key' => 'hits', 'label' => 'Uses'],
        ];
    }
}
