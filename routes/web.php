<?php

use App\Livewire\AboutPage;
use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\MyProfilePage;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPasswordPage;
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
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class);

Route::get('/products', ProductsPage::class)->name('products');
Route::get('/products/{no_genset}', DetailProductPage::class)->name('products.show');

Route::get('/gallery', GalleryPage::class)->name('gallery');
Route::get('/gallery/{slug}', DetailGalleryPage::class)->name('gallery.show');

Route::get('/about', AboutPage::class)->name('about');
Route::get('/contact', ContactPage::class)->name('contact');

Route::get('/success', SuccessPage::class)->name('success');

Route::middleware('guest:customer')->group(
    function () {
        Route::get('/login', Login::class)->name('login');
        Route::get('/register', Register::class)->name('register');
        Route::get('/forgot', ForgotPasswordPage::class)->name('password.request');
        Route::get('/reset/{token}', ResetPasswordPage::class)->name('password.reset');
    }
);

Route::middleware('auth:customer')->group(function () {
    Route::get('/logout', function () {
        auth()->guard('customer')->logout();
        return redirect()->to('/');
    });

    Route::middleware('currentLogin')->group(function () {
        Route::get('/profile/{customer_id}', MyProfilePage::class)->name('customer-profile.show');
        Route::get('/orders/{customer_id}', MyOrderPage::class)->name('order');
        Route::get('/orders/{customer_id}/{order_id}', MyOrderDetailPage::class)->name('order.show');
        Route::get('/orders/{customer_id}/{order_id}/cancel', CancelPage::class)
            ->middleware('isCancelOrder')
            ->name('cancel');
    });
});
