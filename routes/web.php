<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{Dashboard,Client_Controller,Login_Controller,Master_Controller};

Route::get('/', function () {
    return view('login');
})->name('login-page');
Route::post('/login', [Login_Controller::class, 'login'])->name('login');

Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

Route::get('/clients', [Client_Controller::class, 'index'])->name('clients-list');
Route::get('/clients-add-edit', [Client_Controller::class, 'addedit'])->name('clients-add-edit');
Route::post('/clients-add', [Client_Controller::class, 'add'])->name('clients-add');

Route::get('/company-master', [Master_Controller::class, 'company_master'])->name('company-master');
Route::post('/company-save', [Master_Controller::class, 'save_company'])->name('company-save');
Route::get('/company-list', [Master_Controller::class, 'list_companies'])->name('company-list');
Route::get('/company-data', [Master_Controller::class, 'get_company_data'])->name('company-data');
Route::post('/company-update', [Master_Controller::class, 'update_company'])->name('company-update');
Route::post('/company-delete', [Master_Controller::class, 'delete_company'])->name('company-delete');