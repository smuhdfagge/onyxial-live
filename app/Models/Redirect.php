<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $fillable = ['from_path', 'to_path', 'status_code', 'hits'];

    public const CACHE_KEY = 'site_redirects';

    protected static function booted(): void
    {
        static::saved(fn () => \Illuminate\Support\Facades\Cache::forget(self::CACHE_KEY));
        static::deleted(fn () => \Illuminate\Support\Facades\Cache::forget(self::CACHE_KEY));
    }

    /** Normalise a path to "/foo/bar" with no trailing slash. */
    public static function normalise(string $path): string
    {
        $path = '/'.trim(parse_url($path, PHP_URL_PATH) ?? $path, '/');

        return $path === '/' ? '/' : rtrim($path, '/');
    }
}
