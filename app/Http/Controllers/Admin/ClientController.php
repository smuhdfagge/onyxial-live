<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;

class ClientController extends ResourceController
{
    protected string $model = Client::class;
    protected string $route = 'admin.clients';
    protected string $title = 'Clients & partners';
    protected string $singular = 'client';
    protected string $icon = 'building';
    protected array $searchable = ['name'];
    protected ?string $intro = 'Shown in the "Trusted by" logo strip on the home and about pages. Organisations without a logo show their name instead.';

    protected function fields(): array
    {
        return [
            ['name' => 'name', 'label' => 'Organisation name', 'type' => 'text', 'required' => true, 'help' => 'Also used as the logo\'s alternative text for screen readers and search engines.'],
            ['name' => 'url', 'label' => 'Website (optional)', 'type' => 'url'],
            ['name' => 'logo', 'label' => 'Logo', 'type' => 'image', 'folder' => 'clients', 'section' => 'side', 'help' => 'PNG with a transparent background works best.'],
            ['name' => 'sort_order', 'label' => 'Display order', 'type' => 'number', 'default' => 0, 'section' => 'side'],
            ['name' => 'is_published', 'label' => 'Show on website', 'type' => 'checkbox', 'section' => 'side', 'default' => true],
        ];
    }

    protected function columns(): array
    {
        return [
            ['key' => 'logo', 'label' => '', 'type' => 'image', 'contain' => true],
            ['key' => 'name', 'label' => 'Organisation', 'type' => 'title'],
            ['key' => 'sort_order', 'label' => 'Order'],
            ['key' => 'is_published', 'label' => 'Status', 'type' => 'bool'],
        ];
    }
}
