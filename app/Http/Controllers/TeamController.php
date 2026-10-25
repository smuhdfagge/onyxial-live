<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\TeamMember;
use App\Support\Seo;

class TeamController extends Controller
{
    public function index()
    {
        $page = Page::for('team');

        return view('site.team.index', [
            'page' => $page,
            'seo' => Seo::forPage('team')->crumb($page?->title ?? 'Our Team', route('team.index')),
            'team' => TeamMember::published()->ordered()->get(),
        ]);
    }

    public function show(TeamMember $member)
    {
        abort_unless($member->is_published, 404);

        $seo = Seo::make()
            ->title($member->meta_title ?: $member->name.' — '.$member->position)
            ->description($member->meta_description ?: ($member->summary ?: $member->bio))
            ->image($member->photo)
            ->type('profile')
            ->crumb('Our Team', route('team.index'))
            ->crumb($member->name, $member->url())
            ->schema(array_filter([
                '@context' => 'https://schema.org',
                '@type' => 'Person',
                'name' => $member->name,
                'jobTitle' => $member->position,
                'image' => media_url($member->photo),
                'email' => $member->email ? 'mailto:'.$member->email : null,
                'url' => $member->url(),
                'worksFor' => ['@id' => url('/').'#organization'],
                'sameAs' => array_values(array_filter([$member->linkedin, $member->twitter])),
            ]));

        return view('site.team.show', [
            'member' => $member,
            'seo' => $seo,
            'others' => TeamMember::published()->ordered()->where('id', '!=', $member->id)->get(),
        ]);
    }
}
