<?php

use App\Models\Setting;
use Illuminate\Support\Str;

if (! function_exists('setting')) {
    /** Read a site setting managed from the admin dashboard. */
    function setting(string $key, $default = null)
    {
        return Setting::get($key, $default);
    }
}

if (! function_exists('media_url')) {
    /**
     * Public URL for an uploaded or bundled image.
     * Paths are stored relative to /public (e.g. "uploads/team/aisha.jpg").
     */
    function media_url(?string $path, ?string $fallback = null): ?string
    {
        if (! $path) {
            return $fallback ? asset($fallback) : null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        if (! has_media($path)) {
            return $fallback ? asset($fallback) : null;
        }

        return asset(ltrim($path, '/'));
    }
}

if (! function_exists('has_media')) {
    /** True when an image path is set and the file actually exists (or is a remote URL). */
    function has_media(?string $path): bool
    {
        static $seen = [];

        if (! $path) {
            return false;
        }
        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return true;
        }

        return $seen[$path] ??= is_file(public_path(ltrim($path, '/')));
    }
}

if (! function_exists('plain_excerpt')) {
    function plain_excerpt(?string $html, int $limit = 160): string
    {
        $text = trim(preg_replace('/\s+/', ' ', strip_tags((string) $html)));

        return Str::limit($text, $limit, '…');
    }
}

if (! function_exists('clean_html')) {
    /**
     * Light HTML clean-up for admin-entered rich text.
     * Admins are trusted users, but scripts, iframes and inline event handlers are still removed.
     */
    function clean_html(?string $html): string
    {
        $html = (string) $html;
        $html = preg_replace('#<(script|style|iframe|object|embed)[^>]*>.*?</\1>#is', '', $html);
        $html = preg_replace('#<(script|style|iframe|object|embed)[^>]*/?>#is', '', $html);
        $html = preg_replace('/\son\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);
        $html = preg_replace('/(href|src)\s*=\s*(["\'])\s*javascript:[^"\']*\2/i', '$1="#"', $html);

        return $html;
    }
}

if (! function_exists('social_links')) {
    /** Company social profiles that have a URL set, in display order. */
    function social_links(): array
    {
        $map = [
            'linkedin' => 'LinkedIn',
            'x' => 'X (Twitter)',
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'youtube' => 'YouTube',
        ];
        $out = [];
        foreach ($map as $key => $label) {
            if ($url = setting('social_'.$key)) {
                $out[$key] = ['label' => $label, 'url' => $url];
            }
        }

        return $out;
    }
}
