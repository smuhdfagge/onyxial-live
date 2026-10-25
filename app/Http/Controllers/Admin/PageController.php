<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Database\Eloquent\Model;

/** The fixed site pages: banner text, optional body and SEO. Pages can't be added or removed. */
class PageController extends ResourceController
{
    protected string $model = Page::class;
    protected string $route = 'admin.pages';
    protected string $title = 'Pages & SEO';
    protected string $singular = 'page';
    protected string $icon = 'file';
    protected bool $canCreate = false;
    protected bool $canDelete = false;
    protected ?string $publicRoute = 'page';
    protected ?string $intro = 'Banner text, page content and search engine settings for each main page.';

    protected function query()
    {
        return Page::query()->orderBy('id');
    }

    public function publicUrl(Model $item): ?string
    {
        return $item->url();
    }

    protected function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Page name', 'type' => 'text', 'required' => true, 'help' => 'Used in menus and breadcrumbs.'],
            ['name' => 'heading', 'label' => 'Banner heading', 'type' => 'text'],
            ['name' => 'intro', 'label' => 'Banner text', 'type' => 'textarea', 'rows' => 3],
            ['name' => 'body', 'label' => 'Page content', 'type' => 'richtext', 'help' => 'Used on the About page ("Our story") and, if filled in, on the Team page.'],
            ['name' => 'banner', 'label' => 'Banner background image', 'type' => 'image', 'folder' => 'pages', 'section' => 'side', 'help' => 'Optional. Shown faintly behind the navy banner.'],
            ['name' => 'meta_title', 'label' => 'SEO title', 'type' => 'text', 'section' => 'seo', 'max' => 70],
            ['name' => 'meta_description', 'label' => 'SEO description', 'type' => 'textarea', 'rows' => 3, 'section' => 'seo', 'max' => 170],
            ['name' => 'meta_keywords', 'label' => 'Keywords', 'type' => 'text', 'section' => 'seo'],
            ['name' => 'og_image', 'label' => 'Social share image', 'type' => 'image', 'folder' => 'pages', 'section' => 'seo', 'help' => '1200×630 pixels works best on LinkedIn, X, Facebook and WhatsApp.'],
        ];
    }

    protected function columns(): array
    {
        return [
            ['key' => 'title', 'label' => 'Page', 'type' => 'title', 'sub' => 'heading'],
            ['key' => 'meta_title', 'label' => 'SEO title'],
            ['key' => 'updated_at', 'label' => 'Last updated', 'type' => 'date'],
        ];
    }
}
