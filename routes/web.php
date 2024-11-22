<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ReviewController;

use Illuminate\Support\Facades\Route;

// Page for front static pages
Route::get('/', [PagesController::class, 'index'])->name('front.index');

Route::get('/shop', [PagesController::class, 'shop'])->name('front.shop');

Route::get('/about', [PagesController::class, 'about'])->name('front.about');

Route::get('/contact', [PagesController::class, 'contact'])->name('front.contact');

Route::get('/cart', [PagesController::class, 'cart'])->name('front.cart');

Route::get('/details/{id}', [PagesController::class, 'details'])->name('front.details');

// Route pour la recherche
Route::get('/search', [PagesController::class, 'search'])->name('search');

// Route pour les avis
Route::post('/produit/{produit}/review', [ReviewController::class, 'addReview'])->name('add_review');
Route::delete('/review/{review}', [ReviewController::class, 'deleteReview'])->name('delete_review');
Route::put('/review/{review}/edit', [ReviewController::class, 'editReview'])->name('edit_review');

// Route Panier
Route::get('/addToCart/{id}', [CartController::class, 'addToCart'])->name('add_to_cart');

Route::get('/removeFromCart/{id}', [CartController::class, 'removeFromCart'])->name('remove_from_cart');

Route::get('/incrementQuantity/{id}', [CartController::class, 'incrementQuantity'])->name('increment_quantity');
Route::get('/decrementQuantity/{id}', [CartController::class, 'decrementQuantity'])->name('decrement_quantity');

// Routes pour les clients
Route::group(['prefix' => 'client'], function () {
  Route::get('/login', [ClientsController::class, 'login'])->name('client.login');
  Route::get('/register', [ClientsController::class, 'register'])->name('client.register');
  Route::post('/register/post', [ClientsController::class, 'register_post'])->name('client.register.post');
  Route::post('/login/post', [ClientsController::class, 'login_post'])->name('client.login.post');
  Route::get('/myspace', [ClientsController::class, 'myspace'])->name('client.myspace');
  Route::get('/logout', [ClientsController::class, 'logout'])->name('client.logout');
  Route::get('/forgot-password', [ClientsController::class, 'forgot_password'])->name('client.forgot-password');
  Route::post('/forgot-password', [ClientsController::class, 'handleResetPassword'])->name('client.handleResetPassword');
  Route::get('/reset-password/{token}', [ClientsController::class, 'resetPasswordToken'])->name('client.reset-password');
  Route::post('/reset-password', [ClientsController::class, 'resetPassword'])->name('client.reset-password.post');
});

// Groupe middleware pour l'administration
Route::middleware([AdminMiddleware::class])->group(function () {
  // Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
  // Route::post('/admin/login/post', [AdminController::class, 'login_post'])->name('admin.login.post');
  // Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
  Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
  Route::get('/admin/add', [AdminController::class, 'add'])->name('admin.add');
  Route::post('/admin/addProduct', [AdminController::class, 'addProduct'])->name('admin.addProduct');
  Route::get('/admin/products/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
  Route::post('/admin/products/update/{id}', [AdminController::class, 'updateProduct'])->name('admin.updateProduct');
  Route::delete('/admin/products/delete/{id}', [AdminController::class, 'deleteProduct'])->name('admin.deleteProduct');
});

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login/post', [AdminController::class, 'login_post'])->name('admin.login.post');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');