<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;

class ServiceController extends ResourceController
{
    protected string $model = Service::class;
    protected string $route = 'admin.services';
    protected string $title = 'Services';
    protected string $singular = 'service';
    protected string $icon = 'briefcase';
    protected ?string $publicRoute = 'services.show';

    protected function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Service name', 'type' => 'text', 'required' => true],
            ['name' => 'slug', 'label' => 'Web address', 'type' => 'slug', 'prefix' => '/services/', 'help' => 'Leave blank to create it from the name. Changing it changes the page link.'],
            ['name' => 'excerpt', 'label' => 'Short summary', 'type' => 'textarea', 'rows' => 3, 'help' => 'Shown on service cards and as the page intro.'],
            ['name' => 'body', 'label' => 'Full description', 'type' => 'richtext'],
            ['name' => 'points', 'label' => 'What this covers', 'type' => 'list', 'help' => 'One item per line.'],
            ['name' => 'image', 'label' => 'Image', 'type' => 'image', 'folder' => 'services', 'section' => 'side'],
            ['name' => 'icon', 'label' => 'Icon', 'type' => 'icon', 'section' => 'side'],
            ['name' => 'sort_order', 'label' => 'Display order', 'type' => 'number', 'default' => 0, 'section' => 'side', 'help' => 'Lower numbers show first.'],
            ['name' => 'is_published', 'label' => 'Show on website', 'type' => 'checkbox', 'section' => 'side', 'default' => true],
            ['name' => 'meta_title', 'label' => 'SEO title', 'type' => 'text', 'section' => 'seo', 'max' => 70],
            ['name' => 'meta_description', 'label' => 'SEO description', 'type' => 'textarea', 'rows' => 3, 'section' => 'seo', 'max' => 170],
        ];
    }

    protected function columns(): array
    {
        return [
            ['key' => 'image', 'label' => '', 'type' => 'image'],
            ['key' => 'title', 'label' => 'Service', 'type' => 'title'],
            ['key' => 'sort_order', 'label' => 'Order'],
            ['key' => 'is_published', 'label' => 'Status', 'type' => 'bool'],
        ];
    }

    protected function rules(?Model $item): array
    {
        return ['title' => ['required', 'string', 'max:190']];
    }
}
