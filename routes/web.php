<?php

use App\Livewire\AboutPage;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\CancelPage;
use App\Livewire\ContactPage;
use App\Livewire\DetailGalleryPage;
use App\Livewire\DetailProductPage;
use App\Livewire\GalleryPage;
use App\Livewire\HomePage;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\MyOrderPage;
use App\Livewire\ProductsPage;
use App\Livewire\SuccessPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class);
Route::get('/products', ProductsPage::class)->name('products');
Route::get('/products/slug', DetailProductPage::class)->name('products.show');
Route::get('/gallery', GalleryPage::class)->name('gallery');
Route::get('/gallery/id', DetailGalleryPage::class)->name('gallery.show');
Route::get('/about', AboutPage::class)->name('about');
Route::get('/contact', ContactPage::class)->name('contact');

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

Route::get('/my-orders', MyOrderPage::class)->name('order');
Route::get('/my-orders/id', MyOrderDetailPage::class)->name('order.show');

Route::get('/success', SuccessPage::class)->name('success');
Route::get('/cancel', CancelPage::class)->name('cancel');
