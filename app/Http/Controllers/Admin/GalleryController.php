<?php

namespace App\Http\Controllers\Admin;

use App\Models\GalleryImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class GalleryController extends ResourceController
{
    protected string $model = GalleryImage::class;
    protected string $route = 'admin.gallery';
    protected string $title = 'About page gallery';
    protected string $singular = 'photo';
    protected string $icon = 'image';
    protected array $searchable = ['caption'];
    protected ?string $intro = 'Photos shown in the "Moments from our work" gallery on the About page.';

    protected function fields(): array
    {
        return [
            ['name' => 'path', 'label' => 'Photo', 'type' => 'image', 'folder' => 'gallery', 'required' => true],
            ['name' => 'caption', 'label' => 'Caption', 'type' => 'text', 'help' => 'Describe what is in the photo. This also helps search engines.'],
            ['name' => 'sort_order', 'label' => 'Display order', 'type' => 'number', 'default' => 0, 'section' => 'side'],
            ['name' => 'is_published', 'label' => 'Show on website', 'type' => 'checkbox', 'section' => 'side', 'default' => true],
        ];
    }

    protected function rules(?Model $item): array
    {
        return [
            'path' => [$item ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:6144'],
        ];
    }

    protected function itemTitle(Model $item): string
    {
        return $item->caption ?: 'Photo #'.$item->id;
    }

    protected function columns(): array
    {
        return [
            ['key' => 'path', 'label' => '', 'type' => 'image'],
            ['key' => 'caption', 'label' => 'Caption', 'type' => 'title', 'empty' => 'No caption'],
            ['key' => 'sort_order', 'label' => 'Order'],
            ['key' => 'is_published', 'label' => 'Status', 'type' => 'bool'],
        ];
    }
}
