<?php

use App\Http\Controllers\admin\BlogsController;
use App\Http\Controllers\admin\PagesController;
use App\Http\Controllers\admin\SlidersController;
use App\Http\Controllers\admin\ContactsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/page', [HomeController::class, 'page'])->name('page');
Route::get('/blogs', [HomeController::class, 'blogs'])->name('blogs');
Route::get('/blogs/article/{id}', [HomeController::class, 'article'])->name('blogs.article');
Route::get('/profile/{slug}', [HomeController::class, 'profile'])->name('profile');
Route::get('/page/{slug}', [HomeController::class, 'page'])->name('page');

Route::get('/pengaduan', [PengaduanController::class, 'create'])->name('pengaduan');
Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan-store');

Route::get('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/auth', function () {
    return redirect()->route('auth.login');
});
Route::get('/login', function () {
    return redirect()->route('auth.login');
});
Route::get('/logout', function () {
    return redirect()->route('auth.logout');
});
Route::post('/auth', [AuthController::class, 'auth'])->name('auth');

Route::middleware(['auth'])->prefix('/admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Users
    Route::get('/users', [UsersController::class, 'index'])->name('admin.users');
    Route::get('/users/create', [UsersController::class, 'create'])->name('admin.users-create');
    Route::post('/users/store', [UsersController::class, 'store'])->name('admin.users-store');
    Route::get('/users/edit/{id}', [UsersController::class, 'edit'])->name('admin.users-edit');
    Route::put('/users/update/{id}', [UsersController::class, 'update'])->name('admin.users-update');
    Route::delete('/users/delete/{id}', [UsersController::class, 'delete'])->name('admin.users-delete');

    // Blog
    Route::get('/blogs', [BlogsController::class, 'index'])->name('admin.blogs');
    Route::get('/blogs/create', [BlogsController::class, 'create'])->name('admin.blogs-create');
    Route::post('/blogs/store', [BlogsController::class, 'store'])->name('admin.blogs-store');
    Route::get('/blogs/edit/{id}', [BlogsController::class, 'edit'])->name('admin.blogs-edit');
    Route::put('/blogs/update/{id}', [BlogsController::class, 'update'])->name('admin.blogs-update');
    Route::delete('/blogs/delete/{id}', [BlogsController::class, 'delete'])->name('admin.blogs-delete');

    //Pages
    Route::get('/pages', [PagesController::class, 'index'])->name('admin.pages');
    Route::get('/pages/create', [PagesController::class, 'create'])->name('admin.pages-create');
    Route::post('/pages/store', [PagesController::class, 'store'])->name('admin.pages-store');
    Route::get('/pages/edit/{id}', [PagesController::class, 'edit'])->name('admin.pages-edit');
    Route::put('/pages/update/{id}', [PagesController::class, 'update'])->name('admin.pages-update');
    Route::delete('/pages/delete/{id}', [PagesController::class, 'delete'])->name('admin.pages-delete');

    //Sliders
    Route::get('/sliders', [SlidersController::class, 'index'])->name('admin.sliders');
    Route::get('/sliders/create', [SlidersController::class, 'create'])->name('admin.sliders-create');
    Route::post('/sliders/store', [SlidersController::class, 'store'])->name('admin.sliders-store');
    Route::get('/sliders/edit/{id}', [SlidersController::class, 'edit'])->name('admin.sliders-edit');
    Route::put('/sliders/update/{id}', [SlidersController::class, 'update'])->name('admin.sliders-update');
    Route::delete('/sliders/delete/{id}', [SlidersController::class, 'delete'])->name('admin.sliders-delete');

    //Sliders
    Route::get('/contacts', [ContactsController::class, 'index'])->name('admin.contacts');
    Route::put('/contacts/update/{id}', [ContactsController::class, 'update'])->name('admin.contacts-update');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('admin.profile-create');
    Route::post('/profile/store', [ProfileController::class, 'store'])->name('admin.profile-store');
    Route::get('/profile/edit/{id}', [ProfileController::class, 'edit'])->name('admin.profile-edit');
    Route::put('/profile/update/{id}', [ProfileController::class, 'update'])->name('admin.profile-update');
    Route::delete('/profile/delete/{id}', [ProfileController::class, 'delete'])->name('admin.profile-delete');

    // Pengaduan
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('admin.pengaduan');

    // CK Editor
    Route::post('ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.image-upload');
});
