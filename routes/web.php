<?php

use App\Livewire\DetailGalleryPage;
use App\Livewire\DetailProductPage;
use App\Livewire\GalleryPage;
use App\Livewire\HomePage;
use App\Livewire\ProductsPage;
use App\Livewire\RentPage;
use Illuminate\Support\Facades\Route;

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

Route::get('/', HomePage::class);
Route::get('/products', ProductsPage::class)->name('products');
Route::get('/products/slug', DetailProductPage::class)->name('products.show');
Route::get('/rent', RentPage::class)->name('rent');
Route::get('/gallery', GalleryPage::class)->name('gallery');
Route::get('/gallery/id', DetailGalleryPage::class)->name('gallery.show');
