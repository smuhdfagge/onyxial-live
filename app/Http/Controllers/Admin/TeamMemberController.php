<?php

namespace App\Http\Controllers\Admin;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Model;

class TeamMemberController extends ResourceController
{
    protected string $model = TeamMember::class;
    protected string $route = 'admin.team';
    protected string $title = 'Team members';
    protected string $singular = 'team member';
    protected string $icon = 'users';
    protected ?string $publicRoute = 'team.show';
    protected array $searchable = ['name', 'position'];

    protected function fields(): array
    {
        return [
            ['name' => 'name', 'label' => 'Full name', 'type' => 'text', 'required' => true],
            ['name' => 'position', 'label' => 'Job title', 'type' => 'text', 'required' => true],
            ['name' => 'slug', 'label' => 'Web address', 'type' => 'slug', 'from' => 'name', 'prefix' => '/team/'],
            ['name' => 'summary', 'label' => 'Short introduction', 'type' => 'textarea', 'rows' => 3, 'help' => 'One or two sentences shown at the top of the profile.'],
            ['name' => 'bio', 'label' => 'Biography', 'type' => 'richtext'],
            ['name' => 'credentials', 'label' => 'Education and credentials', 'type' => 'list', 'help' => 'One per line.'],
            ['name' => 'photo', 'label' => 'Photo', 'type' => 'image', 'folder' => 'team', 'section' => 'side', 'help' => 'Portrait photos work best (about 4:5).'],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'section' => 'side'],
            ['name' => 'linkedin', 'label' => 'LinkedIn URL', 'type' => 'url', 'section' => 'side'],
            ['name' => 'twitter', 'label' => 'X (Twitter) URL', 'type' => 'url', 'section' => 'side'],
            ['name' => 'sort_order', 'label' => 'Display order', 'type' => 'number', 'default' => 0, 'section' => 'side'],
            ['name' => 'show_on_home', 'label' => 'Show on home page', 'type' => 'checkbox', 'section' => 'side', 'default' => true],
            ['name' => 'is_published', 'label' => 'Show on website', 'type' => 'checkbox', 'section' => 'side', 'default' => true],
            ['name' => 'meta_title', 'label' => 'SEO title', 'type' => 'text', 'section' => 'seo', 'max' => 70],
            ['name' => 'meta_description', 'label' => 'SEO description', 'type' => 'textarea', 'rows' => 3, 'section' => 'seo', 'max' => 170],
        ];
    }

    protected function columns(): array
    {
        return [
            ['key' => 'photo', 'label' => '', 'type' => 'image', 'round' => true],
            ['key' => 'name', 'label' => 'Name', 'type' => 'title', 'sub' => 'position'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'sort_order', 'label' => 'Order'],
            ['key' => 'is_published', 'label' => 'Status', 'type' => 'bool'],
        ];
    }

    protected function rules(?Model $item): array
    {
        return [
            'name' => ['required', 'string', 'max:190'],
            'position' => ['required', 'string', 'max:190'],
        ];
    }
}
