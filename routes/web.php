<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public website — URLs match the original WordPress site so links and
| search rankings carry over.
|--------------------------------------------------------------------------
*/
Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/about-us', [SiteController::class, 'about'])->name('about');
Route::get('/faq', [SiteController::class, 'faq'])->name('faq');

Route::get('/our-services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/our-team', [TeamController::class, 'index'])->name('team.index');
Route::get('/team/{member:slug}', [TeamController::class, 'show'])->name('team.show');

Route::get('/our-projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/portfolio/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/portfolio_group/{category:slug}', [ProjectController::class, 'category'])->name('projects.category');

Route::get('/contacts', [ContactController::class, 'show'])->name('contacts');
Route::post('/contacts', [ContactController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('contacts.store');

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');

/*
|--------------------------------------------------------------------------
| Admin dashboard
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [Admin\AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [Admin\AuthController::class, 'login'])->middleware('throttle:8,1')->name('login.attempt');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('services', Admin\ServiceController::class)->except('show');
        Route::resource('projects', Admin\ProjectController::class)->except('show');
        Route::post('projects/{project}/images', [Admin\ProjectController::class, 'addImages'])->name('projects.images.store');
        Route::patch('projects/{project}/images/{image}', [Admin\ProjectController::class, 'updateImage'])->name('projects.images.update');
        Route::delete('projects/{project}/images/{image}', [Admin\ProjectController::class, 'deleteImage'])->name('projects.images.destroy');
        Route::resource('project-categories', Admin\ProjectCategoryController::class)->except('show');
        Route::resource('team', Admin\TeamMemberController::class)->except('show')->parameters(['team' => 'item']);
        Route::resource('faqs', Admin\FaqController::class)->except('show');
        Route::resource('clients', Admin\ClientController::class)->except('show');
        Route::resource('highlights', Admin\HighlightController::class)->except('show');
        Route::resource('gallery', Admin\GalleryController::class)->except('show')->parameters(['gallery' => 'item']);
        Route::resource('offices', Admin\OfficeController::class)->except('show');
        Route::resource('redirects', Admin\RedirectController::class)->except('show');

        Route::get('pages', [Admin\PageController::class, 'index'])->name('pages.index');
        Route::get('pages/{page}/edit', [Admin\PageController::class, 'edit'])->name('pages.edit');
        Route::put('pages/{page}', [Admin\PageController::class, 'update'])->name('pages.update');

        Route::get('messages', [Admin\MessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [Admin\MessageController::class, 'show'])->name('messages.show');
        Route::patch('messages/{message}/toggle', [Admin\MessageController::class, 'toggle'])->name('messages.toggle');
        Route::delete('messages/{message}', [Admin\MessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [Admin\SettingController::class, 'update'])->name('settings.update');

        Route::resource('users', Admin\UserController::class)->except('show');
        Route::get('profile', [Admin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [Admin\ProfileController::class, 'update'])->name('profile.update');

        Route::post('cache/clear', [Admin\DashboardController::class, 'clearCache'])->name('cache.clear');
    });
});

/*
| Old WordPress addresses and any custom redirects set in the admin.
*/
Route::fallback([SeoController::class, 'fallback']);
