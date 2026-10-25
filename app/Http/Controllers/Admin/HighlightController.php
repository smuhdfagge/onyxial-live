<?php

namespace App\Http\Controllers\Admin;

use App\Models\Highlight;

class HighlightController extends ResourceController
{
    protected string $model = Highlight::class;
    protected string $route = 'admin.highlights';
    protected string $title = 'Highlights';
    protected string $singular = 'highlight';
    protected string $icon = 'star';
    protected array $searchable = ['title', 'body'];
    protected ?string $filterField = 'group';
    protected ?string $intro = 'Short blocks used across the site: key figures, why choose us, core values and the four-step process.';

    public function __construct()
    {
        $this->filterOptions = Highlight::GROUPS;
    }

    protected function query()
    {
        return Highlight::query()->orderBy('group')->orderBy('sort_order');
    }

    protected function fields(): array
    {
        return [
            ['name' => 'group', 'label' => 'Where it appears', 'type' => 'select', 'options' => Highlight::GROUPS, 'required' => true],
            ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
            ['name' => 'subtitle', 'label' => 'Subtitle / number format', 'type' => 'text', 'help' => 'Core values: a one-line statement. Key figures: the display format with # for the number, e.g. "#+", "$#M+", "#k+".'],
            ['name' => 'value', 'label' => 'Number (key figures only)', 'type' => 'text', 'help' => 'The number that counts up, e.g. 500.'],
            ['name' => 'body', 'label' => 'Text', 'type' => 'textarea', 'rows' => 4],
            ['name' => 'icon', 'label' => 'Icon', 'type' => 'icon', 'section' => 'side'],
            ['name' => 'sort_order', 'label' => 'Display order', 'type' => 'number', 'default' => 0, 'section' => 'side'],
            ['name' => 'is_published', 'label' => 'Show on website', 'type' => 'checkbox', 'section' => 'side', 'default' => true],
        ];
    }

    protected function columns(): array
    {
        return [
            ['key' => 'group', 'label' => 'Section', 'type' => 'map', 'map' => Highlight::GROUPS],
            ['key' => 'title', 'label' => 'Title', 'type' => 'title'],
            ['key' => 'sort_order', 'label' => 'Order'],
            ['key' => 'is_published', 'label' => 'Status', 'type' => 'bool'],
        ];
    }
}
