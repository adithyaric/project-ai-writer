<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PercakapanController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
// return view('welcome');
// });

Route::redirect('/', '/percakapan');

Route::resource('/percakapan', PercakapanController::class);
Route::get('/percakapan/form-inputan/{id}', [PercakapanController::class, 'getFormInputan']);
Route::post('/percakapan/{id}/chat', [PercakapanController::class, 'saveChat'])->name('percakapan.chat');

Route::prefix('admin')
    ->middleware(['auth'])
    ->group(function () {
        Route::resource('layanan', \App\Http\Controllers\Admin\LayananController::class);
        Route::get('/instruksi-prompt/{id}/edit', [\App\Http\Controllers\Admin\InstruksiPromptController::class, 'edit'])->name('instruksi-prompt.edit');
        Route::put('/instruksi-prompt/{id}', [\App\Http\Controllers\Admin\InstruksiPromptController::class, 'update'])->name('instruksi-prompt.update');
        // Route::resource('form-inputan', \App\Http\Controllers\Admin\FormInputanController::class);
        Route::get('/form-inputan/{layanan}', [\App\Http\Controllers\Admin\FormInputanController::class, 'index'])->name('form-inputan.index');
        Route::get('/form-inputan/{layanan}/create', [\App\Http\Controllers\Admin\FormInputanController::class, 'create'])->name('form-inputan.create');
        Route::post('/form-inputan/{layanan}/store', [\App\Http\Controllers\Admin\FormInputanController::class, 'store'])->name('form-inputan.store');
        Route::get('/form-inputan/{formInputan}/edit', [\App\Http\Controllers\Admin\FormInputanController::class, 'edit'])->name('form-inputan.edit');
        Route::put('/form-inputan/{formInputan}/update', [\App\Http\Controllers\Admin\FormInputanController::class, 'update'])->name('form-inputan.update');
        Route::delete('/form-inputan/{formInputan}', [\App\Http\Controllers\Admin\FormInputanController::class, 'destroy'])->name('form-inputan.destroy');
    });

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
