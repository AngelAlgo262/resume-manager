<?php

use App\Http\Controllers\PublishController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/configs', [App\Http\Controllers\ConfigController::class, 'index'])->name('configs');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::post('/publishes/preview', [PublishController::class, 'preview'])->name('publishes.preview');
    Route::resource('publishes', PublishController::class);

    Route::resource('resumes', ResumeController::class);

    Route::prefix('/tokens')->middleware('auth')->name('tokens.')->group(function () {
        Route::get('/create', fn () => view('tokens/create'))->name('create');

        Route::post('/', function (Request $request) {
            $token = $request->user()->createToken($request->token_name);

            return ['token' => $token->plainTextToken];
        })->name('store');
    });
});
