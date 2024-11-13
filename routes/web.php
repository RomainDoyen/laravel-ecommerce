<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

// Page for front static pages
Route::get('/', [PagesController::class, 'index'])->name('front.index');

Route::get('/shop', [PagesController::class, 'shop'])->name('front.shop');

Route::get('/about', [PagesController::class, 'about'])->name('front.about');

Route::get('/contact', [PagesController::class, 'contact'])->name('front.contact');

// Page for client registration
Route::get('/client/login', [ClientsController::class, 'login'])->name('client.login');

Route::get('/client/register', [ClientsController::class, 'register'])->name('client.register');