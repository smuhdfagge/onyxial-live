<?php

namespace App\Support;

use App\Models\Page;

/**
 * Collects everything the <head> needs for one page: title, description,
 * canonical URL, share image, breadcrumbs and structured data (JSON-LD).
 */
class Seo
{
    public string $title = '';
    public string $description = '';
    public ?string $keywords = null;
    public string $canonical = '';
    public ?string $image = null;
    public string $type = 'website';
    public bool $noindex = false;
    /** @var array<int, array{name:string,url:string}> */
    public array $breadcrumbs = [];
    /** @var array<int, array> */
    public array $schema = [];

    public static function make(): self
    {
        $seo = new self;
        $seo->canonical = url()->current();

        return $seo;
    }

    public static function forPage(string $key): self
    {
        $seo = self::make();
        if ($page = Page::for($key)) {
            $seo->title($page->meta_title ?: $page->title)
                ->description($page->meta_description ?: plain_excerpt($page->intro))
                ->keywords($page->meta_keywords)
                ->image($page->og_image ?: $page->banner);
        }

        return $seo;
    }

    public function title(?string $title): self
    {
        if ($title) {
            $this->title = $title;
        }

        return $this;
    }

    public function description(?string $text): self
    {
        if ($text) {
            $this->description = plain_excerpt($text, 158);
        }

        return $this;
    }

    public function keywords(?string $keywords): self
    {
        $this->keywords = $keywords ?: $this->keywords;

        return $this;
    }

    public function image(?string $path): self
    {
        if ($path) {
            $this->image = media_url($path);
        }

        return $this;
    }

    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function crumb(string $name, string $url): self
    {
        $this->breadcrumbs[] = ['name' => $name, 'url' => $url];

        return $this;
    }

    public function schema(array $data): self
    {
        $this->schema[] = $data;

        return $this;
    }

    /** Final <title> text: "Page title | Site name", unless the title already names the site. */
    public function fullTitle(): string
    {
        $site = setting('site_name', 'Onyx Investment Advisory Limited');
        $title = $this->title ?: setting('seo_default_title', $site);

        return str_contains($title, $site) || str_contains($title, 'Onyx') ? $title : $title.' | '.$site;
    }

    public function finalDescription(): string
    {
        return $this->description ?: (string) setting('seo_default_description', '');
    }

    public function finalImage(): string
    {
        return $this->image ?: media_url(setting('seo_default_image'), 'assets/img/og-default.jpg');
    }

    /** All JSON-LD blocks, including site-wide Organization/WebSite and breadcrumbs. */
    public function jsonLd(): array
    {
        $home = url('/');
        $org = [
            '@context' => 'https://schema.org',
            '@type' => 'ProfessionalService',
            '@id' => $home.'#organization',
            'name' => setting('site_name', 'Onyx Investment Advisory Limited'),
            'alternateName' => 'Onyx IAL',
            'url' => $home,
            'logo' => asset('assets/img/logo.png'),
            'image' => $this->finalImage(),
            'description' => setting('seo_default_description'),
            'foundingDate' => setting('founded_year', '2022'),
            'email' => setting('contact_email'),
            'telephone' => setting('contact_phone'),
            'areaServed' => ['Nigeria', 'Northern Nigeria'],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => setting('address_street'),
                'addressLocality' => setting('address_city', 'Abuja'),
                'addressRegion' => setting('address_region', 'FCT'),
                'addressCountry' => 'NG',
            ],
            'sameAs' => array_values(array_map(fn ($s) => $s['url'], social_links())),
        ];

        $blocks = [array_filter($org, fn ($v) => $v !== null && $v !== '' && $v !== [])];

        $blocks[] = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => $home.'#website',
            'url' => $home,
            'name' => setting('site_name', 'Onyx Investment Advisory Limited'),
            'publisher' => ['@id' => $home.'#organization'],
        ];

        if (count($this->breadcrumbs) > 0) {
            $items = [['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $home]];
            foreach ($this->breadcrumbs as $i => $crumb) {
                $items[] = ['@type' => 'ListItem', 'position' => $i + 2, 'name' => $crumb['name'], 'item' => $crumb['url']];
            }
            $blocks[] = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $items];
        }

        return array_merge($blocks, $this->schema);
    }
}
