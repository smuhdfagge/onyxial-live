<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'key', 'title', 'heading', 'intro', 'body', 'banner',
        'meta_title', 'meta_description', 'meta_keywords', 'og_image',
    ];

    public static function for(string $key): ?self
    {
        static $cache = [];

        if (! array_key_exists($key, $cache)) {
            try {
                $cache[$key] = static::where('key', $key)->first();
            } catch (\Throwable $e) {
                $cache[$key] = null;
            }
        }

        return $cache[$key];
    }

    /** Public URL for each fixed page key. */
    public function url(): string
    {
        return match ($this->key) {
            'home' => route('home'),
            'about' => route('about'),
            'services' => route('services.index'),
            'team' => route('team.index'),
            'projects' => route('projects.index'),
            'contacts' => route('contacts'),
            'faq' => route('faq'),
            default => url('/'),
        };
    }
}
