<?php


use App\Livewire\Product\Create;
use App\Livewire\Product\Edit;
use App\Livewire\Product\Index;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('products', Index::class);
    Route::get('product/create', Create::class);
    Route::get('product/edit/{productId}', Create::class);
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('orders', \App\Livewire\Order\Index::class);
    Route::get('order/create', \App\Livewire\Order\Create::class);
    Route::get('order/edit/{orderId}', \App\Livewire\Order\Create::class);
    Route::get('order/{orderId}', \App\Livewire\Order\Show::class);
});
//Category
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('category', \App\Livewire\Category\Index::class);
});

require __DIR__.'/auth.php';
