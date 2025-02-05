<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

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

Route::get('/', fn() => redirect('/login'));

Route::group(['middleware' => 'auth'], function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::middleware('role:admin')->group(function () {
        Volt::route('users', 'user/index')->name('users.index');
        Volt::route('users/{user}', 'user/edit')->name('users.edit');

        Volt::route('products', 'product/index')->name('products.index');
        Volt::route('products/add', 'product/add')->name('products.add');
        Volt::route('products/{product}', 'product/edit')->name('products.edit');
    });

    Route::middleware('role:user')->group(function () {
        Volt::route('product-list', 'product/list')->name('products.list');
    });
});


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
