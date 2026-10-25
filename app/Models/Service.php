<?php

namespace App\Models;

use App\Models\Concerns\Orderable;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use Orderable;

    protected $fillable = [
        'title', 'slug', 'icon', 'excerpt', 'body', 'points', 'image',
        'sort_order', 'is_published', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'points' => 'array',
        'is_published' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function url(): string
    {
        return route('services.show', $this->slug);
    }
}
