<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\EbrochureController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\InquiryController;
use App\Http\Controllers\Public\ProductController as PublicProductController;
use App\Http\Controllers\Public\ProjectController as PublicProjectController;
use App\Http\Controllers\Public\ServiceController as PublicServiceController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Site
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/ebrochure', [EbrochureController::class, 'show'])->name('ebrochure.show');
Route::get('/ebrochure/download', [EbrochureController::class, 'downloadLatest'])->name('ebrochure.download');

Route::get('/services', [PublicServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [PublicServiceController::class, 'show'])->name('services.show');

Route::get('/products', [PublicProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [PublicProductController::class, 'show'])->name('products.show');
Route::post('/products/{product:slug}/inquiry', [InquiryController::class, 'store'])
    ->name('products.inquiry');

Route::get('/projects', [PublicProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project:slug}', [PublicProjectController::class, 'show'])->name('projects.show');
Route::get('/project-documents/{document}/download', [\App\Http\Controllers\Public\ProjectDocumentController::class, 'download'])
    ->name('projects.documents.download');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// TEMPORARY helper for cPanel (no SSH). Visit /storage-link ONCE to create the
// public/storage symlink, then DELETE this route before going live.
Route::get('/storage-link', function () {
    $exit = Artisan::call('storage:link');
    return response('storage:link finished (exit code ' . $exit . '). Symfony link created.' . PHP_EOL . Artisan::output());
});

/*
|--------------------------------------------------------------------------
| Admin Panel
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('admin.guest')->group(function () {
        Route::get('login', [Admin\AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [Admin\AuthController::class, 'login'])->middleware('throttle:10,1')->name('attempt');
    });

    Route::middleware(['admin', 'auth'])->group(function () {
        Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');

        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('sliders', Admin\SliderController::class)->except('show');
        Route::resource('services', Admin\ServiceController::class)->except('show');
        Route::resource('categories', Admin\CategoryController::class)->except('show');
        Route::resource('brands', Admin\BrandController::class)->except('show');
        Route::resource('team-members', Admin\TeamMemberController::class)->except('show');
        Route::resource('clients', Admin\ClientController::class)->except('show');
        Route::resource('brochures', Admin\BrochureController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        Route::get('products', [Admin\ProductController::class, 'index'])->name('products.index');
        Route::get('products/create', [Admin\ProductController::class, 'create'])->name('products.create');
        Route::post('products', [Admin\ProductController::class, 'store'])->name('products.store');
        Route::get('products/{product}/edit', [Admin\ProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{product}', [Admin\ProductController::class, 'update'])->name('products.update');
        Route::delete('products/{product}', [Admin\ProductController::class, 'destroy'])->name('products.destroy');
        Route::patch('products/{product}/images', [Admin\ProductController::class, 'updateImages'])->name('products.update_images');
        Route::delete('product-images/{image}', [Admin\ProductImageController::class, 'destroy'])->name('product-images.destroy');
        Route::patch('product-images/{image}/cover', [Admin\ProductImageController::class, 'makeCover'])->name('product-images.cover');

        Route::get('projects', [Admin\ProjectController::class, 'index'])->name('projects.index');
        Route::get('projects/create', [Admin\ProjectController::class, 'create'])->name('projects.create');
        Route::post('projects', [Admin\ProjectController::class, 'store'])->name('projects.store');
        Route::get('projects/{project}/edit', [Admin\ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('projects/{project}', [Admin\ProjectController::class, 'update'])->name('projects.update');
        Route::delete('projects/{project}', [Admin\ProjectController::class, 'destroy'])->name('projects.destroy');
        Route::delete('project-documents/{document}', [Admin\ProjectController::class, 'destroyDocument'])->name('project-documents.destroy');

        Route::get('settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [Admin\SettingController::class, 'update'])->name('settings.update');

        Route::get('messages', [Admin\MessageController::class, 'index'])->name('messages.index');
        Route::patch('messages/{message}/read', [Admin\MessageController::class, 'markRead'])->name('messages.read');
        Route::delete('messages/{message}', [Admin\MessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('inquiries', [Admin\InquiryController::class, 'index'])->name('inquiries.index');
        Route::patch('inquiries/{inquiry}/read', [Admin\InquiryController::class, 'markRead'])->name('inquiries.read');
        Route::delete('inquiries/{inquiry}', [Admin\InquiryController::class, 'destroy'])->name('inquiries.destroy');
    });
});
