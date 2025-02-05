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

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Volt::route('users', 'user/index')->middleware(['auth'])->name('users.index');
Volt::route('users/{user}', 'user/edit')->middleware(['auth'])->name('users.edit');

Volt::route('products', 'product/index')->middleware(['auth'])->name('products.index');
Volt::route('products/add', 'product/add')->middleware(['auth'])->name('products.add');
Volt::route('products/{product}', 'product/edit')->middleware(['auth'])->name('products.edit');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
