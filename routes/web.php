<?php


use App\Livewire\Customer\Show;
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
    Route::get('products', \App\Livewire\Product\Index::class);
    Route::get('products/create', \App\Livewire\Product\Create::class);
    Route::get('products/{product}/edit', \App\Livewire\Product\Edit::class);
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('orders', \App\Livewire\Order\Index::class);
    Route::get('orders/create', \App\Livewire\Order\Create::class);
    Route::get('orders/{order}', \App\Livewire\Order\Show::class);
    Route::get('orders/{order}/edit', \App\Livewire\Order\Edit::class);
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('customers', \App\Livewire\Customer\Index::class);
    Route::get('customers/{customer}', \App\Livewire\Customer\Show::class);
    Route::get('customers/{customer}/edit', \App\Livewire\Customer\Edit::class);

});
//Category
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('category', \App\Livewire\Category\Index::class);
});
//Sales
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('sales', \App\Livewire\Sales\Index::class);
});


require __DIR__.'/auth.php';
