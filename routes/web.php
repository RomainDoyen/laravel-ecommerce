<?php

use Illuminate\Support\Facades\Route;

// Page for front static pages
Route::get('/', function () {
    return view('front.index');
})->name('front.index');

Route::get('/shop', function () {
    return view('front.shop');
})->name('front.shop');

Route::get('/about', function () {
    return view('front.about');
})->name('front.about');

Route::get('/contact', function () {
    return view('front.contact');
})->name('front.contact');

// Page for client registration
Route::get('/client/login', function () {
    return view('client.login');
})->name('client.login');

Route::get('/client/register', function () {
    return view('client.register');
})->name('client.register');