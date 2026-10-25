<?php

namespace App\Http\Controllers\Admin;

use App\Models\Office;

class OfficeController extends ResourceController
{
    protected string $model = Office::class;
    protected string $route = 'admin.offices';
    protected string $title = 'Offices';
    protected string $singular = 'office';
    protected string $icon = 'map-pin';
    protected array $searchable = ['name', 'address'];
    protected ?string $intro = 'Office addresses on the Contacts page. The first office is also shown in the footer and its map appears on the Contacts page.';

    protected function fields(): array
    {
        return [
            ['name' => 'name', 'label' => 'Office name', 'type' => 'text', 'required' => true],
            ['name' => 'address', 'label' => 'Address', 'type' => 'textarea', 'rows' => 3, 'required' => true],
            ['name' => 'phone', 'label' => 'Phone', 'type' => 'text'],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email'],
            ['name' => 'map_query', 'label' => 'Map search text', 'type' => 'text', 'help' => 'What to search on Google Maps to show this office, e.g. "Sani Zangon Daura Estate, Kado, Abuja". Leave blank for no map.'],
            ['name' => 'sort_order', 'label' => 'Display order', 'type' => 'number', 'default' => 0, 'section' => 'side'],
            ['name' => 'is_published', 'label' => 'Show on website', 'type' => 'checkbox', 'section' => 'side', 'default' => true],
        ];
    }

    protected function columns(): array
    {
        return [
            ['key' => 'name', 'label' => 'Office', 'type' => 'title', 'sub' => 'address'],
            ['key' => 'phone', 'label' => 'Phone'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'is_published', 'label' => 'Status', 'type' => 'bool'],
        ];
    }
}
