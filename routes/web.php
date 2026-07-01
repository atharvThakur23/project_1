<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{Dashboard,Client_Controller,Login_Controller};

Route::get('/login-page', function () {
    return view('login');
})->name('login-page');
Route::post('/login', [Login_Controller::class, 'login'])->name('login');

Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

Route::get('/clients', [Client_Controller::class, 'index'])->name('clients-list');
Route::get('/clients-add-edit', [Client_Controller::class, 'addedit'])->name('clients-add-edit');
Route::post('/clients-add', [Client_Controller::class, 'add'])->name('clients-add');

