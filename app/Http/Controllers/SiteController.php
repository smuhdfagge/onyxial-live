<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Faq;
use App\Models\GalleryImage;
use App\Models\Highlight;
use App\Models\Page;
use App\Models\Project;
use App\Models\Service;
use App\Models\TeamMember;
use App\Support\Seo;

class SiteController extends Controller
{
    public function home()
    {
        $page = Page::for('home');

        $seo = Seo::forPage('home');
        $seo->title = $page?->meta_title ?: setting('seo_default_title', 'Onyx Investment Advisory Limited');

        return view('site.home', [
            'page' => $page,
            'seo' => $seo,
            'services' => Service::published()->ordered()->get(),
            'projects' => Project::published()->with('category')->orderByDesc('is_featured')->ordered()->take(3)->get(),
            'team' => TeamMember::published()->where('show_on_home', true)->ordered()->take(4)->get(),
            'clients' => Client::published()->ordered()->get(),
            'stats' => Highlight::published()->group('stats')->ordered()->get(),
            'whyUs' => Highlight::published()->group('why_us')->ordered()->get(),
            'process' => Highlight::published()->group('process')->ordered()->get(),
        ]);
    }

    public function about()
    {
        $page = Page::for('about');
        $seo = Seo::forPage('about')->crumb($page?->title ?? 'About Us', route('about'));

        return view('site.about', [
            'page' => $page,
            'seo' => $seo,
            'stats' => Highlight::published()->group('stats')->ordered()->get(),
            'values' => Highlight::published()->group('values')->ordered()->get(),
            'gallery' => GalleryImage::published()->ordered()->get()->filter(fn ($g) => has_media($g->path))->values(),
            'team' => TeamMember::published()->ordered()->get(),
            'clients' => Client::published()->ordered()->get(),
        ]);
    }

    public function faq()
    {
        $page = Page::for('faq');
        $faqs = Faq::published()->ordered()->get();

        $seo = Seo::forPage('faq')->crumb($page?->title ?? 'FAQ', route('faq'))->schema([
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $faqs->map(fn ($f) => [
                '@type' => 'Question',
                'name' => $f->question,
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($f->answer, '<p><br><ul><ol><li><strong><em><a>')],
            ])->values()->all(),
        ]);

        return view('site.faq', compact('page', 'seo', 'faqs'));
    }
}
