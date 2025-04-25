<?php

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
