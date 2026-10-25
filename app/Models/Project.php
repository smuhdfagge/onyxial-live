<?php

namespace App\Models;

use App\Models\Concerns\Orderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use Orderable;

    protected $fillable = [
        'project_category_id', 'title', 'slug', 'client', 'location', 'start_date', 'status',
        'summary', 'background', 'solution', 'facts', 'image', 'is_featured', 'is_published',
        'sort_order', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'facts' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public const STATUSES = ['ongoing' => 'Ongoing', 'completed' => 'Completed'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function url(): string
    {
        return route('projects.show', $this->slug);
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst((string) $this->status);
    }
}
