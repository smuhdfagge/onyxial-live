# Onyx Investment Advisory Limited — website

The website for **Onyx Investment Advisory Limited** ([onyxial.com](https://onyxial.com)), rebuilt in Laravel 12 with a full admin dashboard. It replaces the old WordPress site and keeps all of its pages and web addresses.

## What's included

**Public website**

| Page | Address |
| --- | --- |
| Home | `/` |
| About | `/about-us` |
| Our Services (+ one page per service) | `/our-services`, `/services/{service}` |
| Our Team (+ one profile per person) | `/our-team`, `/team/{name}` |
| Our Projects (+ project pages, sector pages) | `/our-projects`, `/portfolio/{project}`, `/portfolio_group/{sector}` |
| Contacts | `/contacts` |
| FAQ | `/faq` |

- One brand colour, the Onyx navy `#042755` from the logo, used with its own lighter and darker shades.
- Responsive from phones to large screens, with scroll-in animations, counters, a hover-reveal service grid, a logo marquee and a photo lightbox. Motion is switched off for visitors who ask their device for reduced motion.
- SEO ready:
  - page titles, descriptions, canonical links and social share cards, all editable per page
  - structured data (Organization, Website, Breadcrumbs, Service, Person, FAQ)
  - an automatic `sitemap.xml` and `robots.txt`
  - Google Analytics and Search Console fields
  - 301 redirects from old WordPress addresses
  - self-hosted fonts and browser caching for speed
- Contact forms save every enquiry to the dashboard and can email it to the team. They include spam protection.

**Admin dashboard** at `/admin`

- Dashboard with recent messages, an enquiries chart and a "things to check" list.
- Messages inbox: read, mark unread, reply by email, delete.
- Manage pages and SEO, services, projects (with photo galleries), project sectors, team, FAQs, highlights (key figures, why choose us, values, process), clients and partners, about-page gallery, and offices.
- Site settings for contact details, social links, home page text, vision and mission, SEO and analytics.
- Redirects manager, admin user accounts and password changes.
- Rich-text editor, image uploads with preview, live search-result preview, and character counters for SEO fields.

## Requirements

- PHP 8.2 or newer with the usual extensions (`pdo_mysql` or `pdo_sqlite`, `mbstring`, `openssl`, `fileinfo`, `gd`)
- Composer
- MySQL/MariaDB (or SQLite)

No Node/npm build step is needed. All CSS, JavaScript and fonts are plain files in `public/assets`.

## Install (local or server)

```bash
git clone https://github.com/smuhdfagge/onyxial-live.git
cd onyxial-live
composer install --no-dev --optimize-autoloader
cp .env.example .env          # then fill in the database, mail and ADMIN_* settings
php artisan key:generate
php artisan migrate --seed    # creates the tables, loads all site content and the first admin
php artisan onyx:import-images
```

`migrate --seed` prints the admin email and password if you did not set `ADMIN_PASSWORD` in `.env`. Sign in at `/admin` and change it under **My profile**.

### Bringing over the photos from the old site

`php artisan onyx:import-images` downloads the team photos, project photos, service images, client logos and about-page gallery from the old WordPress site into `public/uploads`. Run it **while the old site is still online**, before the domain is pointed at the new site.

If the domain has already moved, point the command at the old server instead:

```bash
php artisan onyx:import-images --base=https://old-server-address/wp-content/uploads
```

Any image can also be uploaded or replaced from the dashboard.

### Shared hosting (cPanel)

1. Upload the project, or `git clone` it, into a folder such as `~/onyxial`.
2. Best option: set the domain's document root to `~/onyxial/public`.
   If you can't change it, put the project in the domain's root folder. The included root `.htaccess` sends visitors into `public/` and blocks private files.
3. Create a MySQL database and user in cPanel and add them to `.env`.
4. Run the install commands above in cPanel's Terminal.
5. Make `storage/` and `bootstrap/cache/` writable (`chmod -R 775 storage bootstrap/cache`).
6. For speed on the live site: `php artisan config:cache && php artisan route:cache && php artisan view:cache`. Run `php artisan optimize:clear` after changing `.env`.

### Updating later

```bash
git pull
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
```

Running `php artisan db:seed --class=SiteContentSeeder` again resets the built-in content (pages, services, projects, team, FAQs) to the original text. It doesn't touch messages or users. Only run it if you want to undo edits.

## After launch

- Add the site to [Google Search Console](https://search.google.com/search-console) and submit `https://onyxial.com/sitemap.xml`.
- Paste the Search Console verification code and Google Analytics ID into **Site settings → SEO & analytics**.
- Check **Clients & partners**: five logos from the old site had no names. Confirm each organisation's name, then switch it to visible.

## Where things live

- `routes/web.php` — all public and admin URLs
- `app/Http/Controllers` — public pages; `Admin/` holds the dashboard (most sections share `ResourceController`)
- `resources/views/site` — public page templates; `resources/views/admin` — dashboard templates
- `public/assets/css/site.css`, `public/assets/js/site.js` — website styles and interactions
- `database/seeders/SiteContentSeeder.php` — the starting content
- `database/data/legacy-images.php` — the list of images imported from the old site
