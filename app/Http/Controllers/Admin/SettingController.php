<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    /** Settings form, grouped into tabs. Types: text, textarea, richtext, email, url, image, checkbox, code. */
    public static function groups(): array
    {
        return [
            'general' => ['label' => 'General', 'icon' => 'settings', 'fields' => [
                ['site_name', 'Company name', 'text'],
                ['founded_year', 'Year founded', 'text'],
                ['topbar_text', 'Top bar message', 'text', 'Short line shown above the menu on large screens.'],
                ['footer_about', 'Footer description', 'textarea'],
                ['footer_credit', 'Footer credit line', 'text', 'Optional, e.g. "Website by …". Leave blank to hide.'],
            ]],
            'contact' => ['label' => 'Contact', 'icon' => 'phone', 'fields' => [
                ['contact_email', 'Main email address', 'email'],
                ['contact_phone', 'Main phone number', 'text'],
                ['notify_email', 'Send website enquiries to', 'email', 'Enquiries from the contact forms are emailed here (mail settings must be set in .env) and are always saved under Messages.'],
                ['address_street', 'Street address (for search engines)', 'text'],
                ['address_city', 'City', 'text'],
                ['address_region', 'State / region', 'text'],
                ['contact_form_title', 'Contact form heading', 'text'],
                ['contact_form_text', 'Contact form text', 'textarea'],
            ]],
            'social' => ['label' => 'Social media', 'icon' => 'globe', 'fields' => [
                ['social_linkedin', 'LinkedIn', 'url'],
                ['social_x', 'X (Twitter)', 'url'],
                ['social_facebook', 'Facebook', 'url'],
                ['social_instagram', 'Instagram', 'url'],
                ['social_youtube', 'YouTube', 'url'],
                ['twitter_handle', 'X handle', 'text', 'For share cards, e.g. @onyx_IAL_ng'],
            ]],
            'home' => ['label' => 'Home page', 'icon' => 'home', 'fields' => [
                ['hero_eyebrow', 'Banner small heading', 'text'],
                ['hero_title', 'Banner headline', 'textarea', 'Press Enter to start a new line.'],
                ['hero_text', 'Banner text', 'textarea'],
                ['home_about_eyebrow', 'About block small heading', 'text'],
                ['home_about_title', 'About block heading', 'text'],
                ['home_about_text', 'About block text', 'richtext'],
                ['home_about_points', 'About block ticks', 'textarea', 'One per line.'],
                ['home_about_image', 'About block image', 'image'],
                ['ceo_quote', 'Quote', 'textarea'],
                ['ceo_name', 'Quote by', 'text'],
                ['ceo_title', 'Quote by (job title)', 'text'],
                ['why_title', '"Why choose us" heading', 'text'],
                ['why_text', '"Why choose us" text', 'textarea'],
                ['cta_eyebrow', 'Call-to-action small heading', 'text'],
                ['cta_heading', 'Call-to-action heading', 'text'],
                ['cta_text', 'Call-to-action text', 'textarea'],
            ]],
            'about' => ['label' => 'About page', 'icon' => 'users', 'fields' => [
                ['about_title', '"Our story" heading', 'text'],
                ['about_image', '"Our story" image', 'image'],
                ['vision', 'Vision', 'textarea'],
                ['mission', 'Mission', 'textarea'],
            ]],
            'seo' => ['label' => 'SEO & analytics', 'icon' => 'search', 'fields' => [
                ['seo_default_title', 'Default page title', 'text', 'Used on the home page and when a page has no SEO title.'],
                ['seo_default_description', 'Default description', 'textarea', 'About 150–160 characters.'],
                ['seo_default_image', 'Default social share image', 'image', '1200×630 pixels.'],
                ['google_analytics_id', 'Google Analytics ID', 'text', 'e.g. G-XXXXXXXXXX'],
                ['google_site_verification', 'Google Search Console code', 'text', 'Only the content="…" value.'],
                ['bing_site_verification', 'Bing Webmaster code', 'text'],
                ['seo_block_indexing', 'Hide the whole site from search engines', 'checkbox', 'Only for a staging copy. Leave unticked on the live site.'],
                ['head_scripts', 'Extra code in <head>', 'code', 'For trusted tracking snippets only.'],
            ]],
        ];
    }

    public function edit()
    {
        return view('admin.settings', ['groups' => self::groups()]);
    }

    public function update(Request $request)
    {
        $values = [];
        $rules = [];

        foreach (self::groups() as $group) {
            foreach ($group['fields'] as [$key, $label, $type]) {
                $rules[$key] = match ($type) {
                    'email' => ['nullable', 'email', 'max:190'],
                    'url' => ['nullable', 'url', 'max:500'],
                    'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:6144'],
                    'checkbox' => ['nullable'],
                    default => ['nullable', 'string', 'max:20000'],
                };
            }
        }
        $request->validate($rules);

        foreach (self::groups() as $group) {
            foreach ($group['fields'] as [$key, $label, $type]) {
                if ($type === 'image') {
                    if ($request->boolean($key.'_remove')) {
                        $values[$key] = '';
                    }
                    if ($request->hasFile($key)) {
                        $file = $request->file($key);
                        File::ensureDirectoryExists(public_path('uploads/site'));
                        $name = Str::slug($key).'-'.Str::lower(Str::random(6)).'.'.strtolower($file->getClientOriginalExtension());
                        $file->move(public_path('uploads/site'), $name);
                        $values[$key] = 'uploads/site/'.$name;
                    }
                    continue;
                }
                if ($type === 'checkbox') {
                    $values[$key] = $request->boolean($key) ? '1' : '0';
                    continue;
                }
                if ($type === 'richtext') {
                    $values[$key] = clean_html($request->input($key));
                    continue;
                }
                $values[$key] = (string) $request->input($key, '');
            }
        }

        Setting::put($values);

        return redirect(route('admin.settings.edit').'#'.$request->input('_tab', 'general'))->with('success', 'Settings saved.');
    }
}
