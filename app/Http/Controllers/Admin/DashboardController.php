<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Faq;
use App\Models\Message;
use App\Models\Page;
use App\Models\Project;
use App\Models\Service;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            ['label' => 'Services', 'value' => Service::count(), 'icon' => 'briefcase', 'route' => 'admin.services.index'],
            ['label' => 'Projects', 'value' => Project::count(), 'icon' => 'folder', 'route' => 'admin.projects.index'],
            ['label' => 'Team members', 'value' => TeamMember::count(), 'icon' => 'users', 'route' => 'admin.team.index'],
            ['label' => 'Unread messages', 'value' => Message::unread()->count(), 'icon' => 'inbox', 'route' => 'admin.messages.index'],
        ];

        // Enquiries per month for the last 6 months
        $months = collect(range(5, 0))->map(fn ($i) => now()->startOfMonth()->subMonths($i));
        $byMonth = $months->map(fn ($m) => [
            'label' => $m->format('M'),
            'value' => Message::whereBetween('created_at', [$m, $m->copy()->endOfMonth()])->count(),
        ]);

        // Simple content health checks that affect SEO and how the site looks
        $checks = [];
        $missingPhotos = TeamMember::published()->get()->filter(fn ($m) => ! has_media($m->photo))->count();
        if ($missingPhotos) {
            $checks[] = ['text' => $missingPhotos.' team '.str('profile')->plural($missingPhotos).' without a photo', 'route' => route('admin.team.index')];
        }
        $missingProjectImages = Project::published()->get()->filter(fn ($p) => ! has_media($p->image))->count();
        if ($missingProjectImages) {
            $checks[] = ['text' => $missingProjectImages.' '.str('project')->plural($missingProjectImages).' without a main image', 'route' => route('admin.projects.index')];
        }
        $noSeo = Page::whereNull('meta_description')->orWhere('meta_description', '')->count();
        if ($noSeo) {
            $checks[] = ['text' => $noSeo.' '.str('page')->plural($noSeo).' without an SEO description', 'route' => route('admin.pages.index')];
        }
        $hiddenClients = Client::where('is_published', false)->count();
        if ($hiddenClients) {
            $checks[] = ['text' => $hiddenClients.' client '.str('logo')->plural($hiddenClients).' waiting to be confirmed and published', 'route' => route('admin.clients.index')];
        }
        if (! setting('google_analytics_id')) {
            $checks[] = ['text' => 'Google Analytics is not connected yet', 'route' => route('admin.settings.edit').'#seo'];
        }

        return view('admin.dashboard', [
            'counts' => $counts,
            'byMonth' => $byMonth,
            'messages' => Message::latest()->take(6)->get(),
            'projects' => Project::with('category')->latest('updated_at')->take(5)->get(),
            'faqCount' => Faq::count(),
            'checks' => $checks,
        ]);
    }

    public function clearCache()
    {
        try {
            Artisan::call('optimize:clear');
        } catch (\Throwable $e) {
            cache()->flush();
        }

        return back()->with('success', 'Site cache cleared.');
    }
}
