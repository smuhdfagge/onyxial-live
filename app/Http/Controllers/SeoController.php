<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Redirect;
use App\Models\Service;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function sitemap()
    {
        $urls = [
            ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => route('about'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('services.index'), 'priority' => '0.9', 'changefreq' => 'monthly'],
            ['loc' => route('projects.index'), 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['loc' => route('team.index'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('contacts'), 'priority' => '0.7', 'changefreq' => 'yearly'],
            ['loc' => route('faq'), 'priority' => '0.6', 'changefreq' => 'monthly'],
        ];

        foreach (Service::published()->ordered()->get() as $s) {
            $urls[] = ['loc' => $s->url(), 'lastmod' => $s->updated_at, 'priority' => '0.8', 'changefreq' => 'monthly'];
        }
        foreach (Project::published()->ordered()->get() as $p) {
            $urls[] = ['loc' => $p->url(), 'lastmod' => $p->updated_at, 'priority' => '0.8', 'changefreq' => 'monthly'];
        }
        foreach (ProjectCategory::whereHas('projects', fn ($q) => $q->published())->get() as $c) {
            $urls[] = ['loc' => route('projects.category', $c), 'priority' => '0.5', 'changefreq' => 'monthly'];
        }
        foreach (TeamMember::published()->ordered()->get() as $m) {
            $urls[] = ['loc' => $m->url(), 'lastmod' => $m->updated_at, 'priority' => '0.6', 'changefreq' => 'yearly'];
        }

        return response()->view('seo.sitemap', compact('urls'))->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots()
    {
        $lines = [
            'User-agent: *',
            'Disallow: /admin',
            'Allow: /',
            '',
            'Sitemap: '.route('sitemap'),
        ];

        if (setting('seo_block_indexing') === '1') {
            $lines = ['User-agent: *', 'Disallow: /'];
        }

        return response(implode("\n", $lines)."\n", 200)->header('Content-Type', 'text/plain');
    }

    /** Old WordPress URLs and admin-defined redirects; otherwise a normal 404 page. */
    public function fallback(Request $request)
    {
        $path = Redirect::normalise($request->path());

        // WordPress leftovers: feeds, uploads and wp-* paths go home rather than 404.
        if (preg_match('#^/(feed|wp-admin|wp-login\.php|wp-content|wp-json|xmlrpc\.php)#', $path)) {
            return redirect('/', 301);
        }

        abort(404);
    }
}
