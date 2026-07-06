<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{Dashboard,Client_Controller,Login_Controller,Company_Controller,Call_Log_Controller};

Route::get('/', function () {
    return view('login');
})->name('login-page');
Route::post('/login', [Login_Controller::class, 'login'])->name('login');
Route::get('/logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('login-page');
})->name('logout');

Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

Route::get('/clients', [Client_Controller::class, 'index'])->name('clients');
Route::get('/clients-add-edit/{client_id?}', [Client_Controller::class, 'addedit'])->name('clients-add-edit');
Route::post('/clients-add-update', [Client_Controller::class, 'add_update'])->name('clients-add-update');
Route::get('/clients-list', [Client_Controller::class, 'clients_list'])->name('clients-list');
Route::post('/client-delete', [Client_Controller::class, 'delete_client'])->name('client-delete');

Route::get('/company-master', [Company_Controller::class, 'company_master'])->name('company-master');
Route::post('/company-save', [Company_Controller::class, 'save_company'])->name('company-save');
Route::get('/company-list', [Company_Controller::class, 'list_companies'])->name('company-list');
Route::get('/company-data', [Company_Controller::class, 'get_company_data'])->name('company-data');
Route::post('/company-update', [Company_Controller::class, 'update_company'])->name('company-update');
Route::post('/company-delete', [Company_Controller::class, 'delete_company'])->name('company-delete');

Route::get('/call-log', [Call_Log_Controller::class, 'call_log'])->name('call-log');
Route::get('/client-search', [Call_Log_Controller::class, 'client_search'])->name('client-search');
Route::post('/get-tags', [Call_Log_Controller::class, 'get_tags'])->name('get-tags');
Route::post('/save-call-log', [Call_Log_Controller::class, 'save_call_log'])->name('save-call-log');
Route::get('/call-history', [Call_Log_Controller::class, 'call_history'])->name('call-history');