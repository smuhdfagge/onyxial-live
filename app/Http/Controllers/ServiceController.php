<?php

namespace App\Http\Controllers;

use App\Models\Highlight;
use App\Models\Page;
use App\Models\Service;
use App\Support\Seo;

class ServiceController extends Controller
{
    public function index()
    {
        $page = Page::for('services');
        $services = Service::published()->ordered()->get();

        $seo = Seo::forPage('services')->crumb($page?->title ?? 'Our Services', route('services.index'))->schema([
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'itemListElement' => $services->values()->map(fn ($s, $i) => [
                '@type' => 'ListItem', 'position' => $i + 1, 'name' => $s->title, 'url' => $s->url(),
            ])->all(),
        ]);

        return view('site.services.index', [
            'page' => $page,
            'seo' => $seo,
            'services' => $services,
            'whyUs' => Highlight::published()->group('why_us')->ordered()->get(),
            'process' => Highlight::published()->group('process')->ordered()->get(),
        ]);
    }

    public function show(Service $service)
    {
        abort_unless($service->is_published, 404);

        $seo = Seo::make()
            ->title($service->meta_title ?: $service->title)
            ->description($service->meta_description ?: ($service->excerpt ?: $service->body))
            ->image($service->image)
            ->crumb('Our Services', route('services.index'))
            ->crumb($service->title, $service->url())
            ->schema([
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $service->title,
                'description' => plain_excerpt($service->excerpt ?: $service->body, 300),
                'url' => $service->url(),
                'provider' => ['@id' => url('/').'#organization'],
                'areaServed' => 'Nigeria',
            ]);

        return view('site.services.show', [
            'service' => $service,
            'seo' => $seo,
            'others' => Service::published()->ordered()->where('id', '!=', $service->id)->get(),
        ]);
    }
}
