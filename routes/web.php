<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ContactMessageController;
use Illuminate\Support\Facades\Route;

// ==========================================
// Health Check (for Render, Railway, load balancers)
// ==========================================
Route::get('/health', function () {
    return response()->json([
        'status'  => 'ok',
        'service' => 'QRHub',
        'env'     => app()->environment(),
        'time'    => now()->toIso8601String(),
    ], 200);
})->name('health');

// ==========================================
// Frontend Routes
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/qr-types', [HomeController::class, 'types'])->name('types');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');

// Blog Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/tag/{slug}', [BlogController::class, 'tag'])->name('blog.tag');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Dynamic Page Routes
Route::get('/page/{slug}', [HomeController::class, 'page'])->name('page');

// SEO Specific Routes
Route::get('/robots.txt', [HomeController::class, 'robots'])->name('robots');
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');

// ==========================================
// QR Code Interaction Routes
// ==========================================
Route::post('/qr/preview', [QrController::class, 'preview'])->middleware('throttle:qr-generator')->name('qr.preview');
Route::post('/qr/upload-logo', [QrController::class, 'uploadLogo'])->middleware('throttle:qr-generator')->name('qr.upload_logo');
Route::match(['get', 'post'], '/qr/download', [QrController::class, 'download'])->middleware('throttle:qr-generator')->name('qr.download');

// ==========================================
// Admin Authentication Routes
// ==========================================
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// ==========================================
// Admin Protected Dashboard & CRUD Routes
// ==========================================
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Blog Post CRUD
    Route::resource('posts', PostController::class)->names([
        'index' => 'admin.posts.index',
        'create' => 'admin.posts.create',
        'store' => 'admin.posts.store',
        'edit' => 'admin.posts.edit',
        'update' => 'admin.posts.update',
        'destroy' => 'admin.posts.destroy',
    ])->except(['show']);

    // Categories CRUD (Simplified in one main page)
    Route::resource('categories', CategoryController::class)->names([
        'index' => 'admin.categories.index',
        'store' => 'admin.categories.store',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ])->only(['index', 'store', 'update', 'destroy']);

    // Tags CRUD (Simplified)
    Route::resource('tags', TagController::class)->names([
        'index' => 'admin.tags.index',
        'store' => 'admin.tags.store',
        'update' => 'admin.tags.update',
        'destroy' => 'admin.tags.destroy',
    ])->only(['index', 'store', 'update', 'destroy']);

    // Pages CRUD (Modify Content & SEO)
    Route::resource('pages', PageController::class)->names([
        'index' => 'admin.pages.index',
        'edit' => 'admin.pages.edit',
        'update' => 'admin.pages.update',
    ])->only(['index', 'edit', 'update']);

    // General & Ad Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings/update', [SettingController::class, 'update'])->name('admin.settings.update');

    // Contact Messages
    Route::get('/messages', [ContactMessageController::class, 'index'])->name('admin.messages.index');
    Route::get('/messages/{message}', [ContactMessageController::class, 'show'])->name('admin.messages.show');
    Route::delete('/messages/{message}', [ContactMessageController::class, 'destroy'])->name('admin.messages.destroy');
});
