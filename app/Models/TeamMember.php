<?php

namespace App\Models;

use App\Models\Concerns\Orderable;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use Orderable;

    protected $fillable = [
        'name', 'slug', 'position', 'summary', 'bio', 'credentials', 'email', 'photo',
        'linkedin', 'twitter', 'sort_order', 'is_published', 'show_on_home', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'credentials' => 'array',
        'is_published' => 'boolean',
        'show_on_home' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function url(): string
    {
        return route('team.show', $this->slug);
    }

    public function initials(): string
    {
        return collect(explode(' ', $this->name))->filter()->take(2)
            ->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))->implode('');
    }
}
