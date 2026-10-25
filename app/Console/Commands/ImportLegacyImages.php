<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class ImportLegacyImages extends Command
{
    protected $signature = 'onyx:import-images
        {--force : Download again even if the file already exists}
        {--base= : Use a different base URL for the old uploads folder (e.g. the old server\'s IP or a temporary domain)}';

    protected $description = 'Download the photos, logos and gallery images from the old WordPress site into /public/uploads';

    public function handle(): int
    {
        $map = require database_path('data/legacy-images.php');
        $base = rtrim((string) $this->option('base'), '/');
        $ok = $skipped = $failed = 0;

        $this->info('Importing '.count($map).' images from the old website…');
        $bar = $this->output->createProgressBar(count($map));

        foreach ($map as $local => $url) {
            $bar->advance();
            $target = public_path($local);

            if (! $this->option('force') && is_file($target) && filesize($target) > 0) {
                $skipped++;
                continue;
            }

            if ($base) {
                $url = preg_replace('#^https?://[^/]+/wp-content/uploads#', $base, $url);
            }

            try {
                $res = Http::timeout(40)->withHeaders(['User-Agent' => 'Onyx site migration'])->get($url);
                $type = (string) $res->header('Content-Type');
                if (! $res->successful() || ! str_starts_with($type, 'image/')) {
                    $failed++;
                    $this->newLine();
                    $this->warn("  Could not fetch {$url} (HTTP {$res->status()})");
                    continue;
                }
                File::ensureDirectoryExists(dirname($target));
                File::put($target, $res->body());
                $ok++;
            } catch (\Throwable $e) {
                $failed++;
                $this->newLine();
                $this->warn("  Could not fetch {$url}: ".$e->getMessage());
            }
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Done: {$ok} downloaded, {$skipped} already there, {$failed} failed.");
        if ($failed) {
            $this->line('Missing images can be uploaded any time from the admin dashboard.');
        }

        return self::SUCCESS;
    }
}
