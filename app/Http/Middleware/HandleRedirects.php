<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * 301/302 redirects managed in the admin (old WordPress URLs etc.).
 * Runs before routing so it also catches paths that look like valid routes.
 */
class HandleRedirects
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isMethod('GET') || $request->is('admin', 'admin/*')) {
            return $next($request);
        }

        $map = Cache::rememberForever(Redirect::CACHE_KEY, function () {
            try {
                return Redirect::query()->get(['id', 'from_path', 'to_path', 'status_code'])
                    ->keyBy('from_path')->map(fn ($r) => [$r->id, $r->to_path, $r->status_code])->all();
            } catch (\Throwable $e) {
                return [];
            }
        });

        $path = Redirect::normalise($request->path());
        if (isset($map[$path])) {
            [$id, $to, $code] = $map[$path];
            Redirect::whereKey($id)->increment('hits');

            return redirect($to, $code);
        }

        return $next($request);
    }
}
