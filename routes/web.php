<?php

use App\Models\Question;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\TryoutController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MateriController;

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

Route::get('/migrate-seed', function () {
    Artisan::call('migrate:fresh --seed');
        Artisan::call('storage:link');

    return redirect()->route('dashboard')->with('migrate', 'Data Berhasil dihapus!');
})->name('migrate');

Route::get('/link', function(){
    Artisan::call('storage:link');

    return redirect()->route('dashboard');
});

Route::post('/login', [LoginController::class, 'login']);
Route::post('/daftar', [LoginController::class, 'daftar']);
Route::middleware(['guest'])->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
});




Route::middleware(['auth'])->group(function () {

    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

Route::patch('/question/{id}', [QuestionController::class, 'update'])->name('question.update');
    Route::get('/tryout/mini', [TryoutController::class, 'mini'])->name('tryout.mini');
    Route::get('/tryout/akbar', [TryoutController::class, 'akbar'])->name('tryout.akbar');
    Route::resource('tryout', TryoutController::class);
    Route::resource('question', QuestionController::class);
    Route::resource('nilai', NilaiController::class);
    Route::get('/materi/twk', [MateriController::class, 'twk'])->name('materi.twk');
    Route::get('/materi/tiu', [MateriController::class, 'tiu'])->name('materi.tiu');
    Route::get('/materi/tkp', [MateriController::class, 'tkp'])->name('materi.tkp');
    Route::get('/materi/download/{id}', [MateriController::class, 'download'])->name('materi.download');
    Route::get('/materi/preview/{id}', [MateriController::class, 'preview'])->name('materi.preview');
    Route::resource('materi', MateriController::class);

    Route::post('/question/finish/{tryout_id}', [QuestionController::class, 'finish'])->name('question.finish');

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::post('/question/ajax-store', [QuestionController::class, 'ajaxStore'])->name('question.ajax-store');
    Route::get('/hasil/export-pdf/{id}', [NilaiController::class, 'exportPDF'])->name('hasil.export.pdf');
});
