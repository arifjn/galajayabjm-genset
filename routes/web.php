<?php

use App\Livewire\AboutPage;
use App\Livewire\ContactPage;
use App\Livewire\DetailGalleryPage;
use App\Livewire\DetailProductPage;
use App\Livewire\GalleryPage;
use App\Livewire\HomePage;
use App\Livewire\ProductsPage;
use App\Livewire\RentPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class);
Route::get('/products', ProductsPage::class)->name('products');
Route::get('/products/slug', DetailProductPage::class)->name('products.show');
Route::get('/rent', RentPage::class)->name('rent');
Route::get('/gallery', GalleryPage::class)->name('gallery');
Route::get('/gallery/id', DetailGalleryPage::class)->name('gallery.show');
Route::get('/about', AboutPage::class)->name('about');
Route::get('/contact', ContactPage::class)->name('contact');
