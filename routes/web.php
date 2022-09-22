<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
//    Route::post('/register', [\App\Http\Controllers\User\UserController::class, 'register'])->name('register.post');

    Route::get('/dashboard', [\App\Http\Controllers\Administration\AdministrationController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/user', [\App\Http\Controllers\User\UserController::class, 'index'])->name('dashboard.user');
    Route::get('/administration', [\App\Http\Controllers\Administration\AdministrationController::class, 'create'])->name('administration.create');
    Route::post('/administration', [\App\Http\Controllers\Administration\AdministrationController::class, 'store'])->name('administration.store');
    Route::get('/administration/{administration}', [\App\Http\Controllers\Administration\AdministrationController::class, 'show'])->name('administration.show');
    Route::get('/administration/edit/{administration}', [\App\Http\Controllers\Administration\AdministrationController::class, 'edit'])->name('administration.edit');
    Route::patch('/administration/{administration}', [\App\Http\Controllers\Administration\AdministrationController::class, 'update'])->name('administration.update');
    Route::delete('/administration/{id}', [\App\Http\Controllers\Administration\AdministrationController::class, 'destroy'])->name('administration.destroy');
    Route::post('/administration/payment/{administration}', [\App\Http\Controllers\Administration\AdministrationController::class, 'addPayment'])->name('administration.payment');
    Route::post('/administration/payment/confirmation/{id}', [\App\Http\Controllers\Administration\AdministrationController::class, 'setPaymentConfirmation'])->name('administration.payment.confirmation');
    Route::post('/administration/confirmation/{id}', [\App\Http\Controllers\Administration\AdministrationController::class, 'setConfirmation'])->name('administration.confirm');

    Route::patch('/participant/{id}', [\App\Http\Controllers\Participant\ParticipantController::class, 'update'])->name('participant.update');
    Route::delete('/participant/{id}', [\App\Http\Controllers\Participant\ParticipantController::class, 'destroy'])->name('participant.destroy');
    Route::post('/participant', [\App\Http\Controllers\Participant\ParticipantController::class, 'store'])->name('participant.store');

    Route::post('/elimination', [\App\Http\Controllers\Elimination\EliminationController::class, 'store'])->name('elimination.store');
    Route::patch('/elimination/{elimination}', [\App\Http\Controllers\Elimination\EliminationController::class, 'update'])->name('elimination.update');
    Route::post('/eliminiation/confirmation/{id}', [App\Http\Controllers\Elimination\EliminationController::class, 'setEliminated'])->name('elimination.confirm');
});
