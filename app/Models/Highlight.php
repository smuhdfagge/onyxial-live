<?php

namespace App\Models;

use App\Models\Concerns\Orderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    use Orderable;

    protected $fillable = ['group', 'title', 'subtitle', 'body', 'icon', 'value', 'sort_order', 'is_published'];

    protected $casts = ['is_published' => 'boolean'];

    public const GROUPS = [
        'stats' => 'Key figures (counters)',
        'why_us' => 'Why choose us',
        'values' => 'Core values',
        'process' => 'Four-step process',
    ];

    public function scopeGroup(Builder $query, string $group): Builder
    {
        return $query->where('group', $group);
    }
}
