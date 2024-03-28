<?php

//use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware(['alreadyLoggedIn']);
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/ajax-file-upload', [FileUploadController::class, 'ajaxFileUpload'])->name('ajax-file-upload');
    Route::post('/ajax-file-upload-post', [FileUploadController::class, 'ajaxFileUploadPost'])->name('ajax-file-upload-post');
    
    Route::get('/users', [UserController::class, 'index'])->name('users.list');
    Route::get('/userdata', [UserController::class, 'getUsersData'])->name('users.data');
   /* Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/save', [UserController::class, 'store'])->name('user.store');
    Route::patch('/user/saveUpdate/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/deleteUser/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    */
    
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

/*Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});*/

require __DIR__ . '/auth.php';
