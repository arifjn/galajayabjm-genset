<?php

use App\Http\Controllers\DeliveryOrderPdfController;
use App\Http\Controllers\GensetPdfController;
use App\Http\Controllers\IncomePdfController;
use App\Http\Controllers\InvoicePdfController;
use App\Http\Controllers\MonitoringPdfController;
use App\Http\Controllers\OperatorPdfController;
use App\Http\Controllers\OrderPdfController;
use App\Http\Controllers\OutcomePdfController;
use App\Http\Controllers\PenawaranPdfController;
use App\Http\Controllers\PlanJobPdfController;
use App\Http\Controllers\ServicePdfController;
use App\Http\Controllers\ServiceWorkPdfController;
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

Route::get('pdf-penawaran/{transaction:order_id}', [PenawaranPdfController::class, 'pdf'])->name('pdf.penawaran');
Route::get('pdf-invoice/{transaction:order_id}', [InvoicePdfController::class, 'pdf'])->name('pdf.invoice');

Route::get('pdf-delivery/{plan:order_id}', [DeliveryOrderPdfController::class, 'pdf'])->name('pdf.delivery');
Route::get('pdf-service_work/{plan:id}', [ServiceWorkPdfController::class, 'pdf'])->name('pdf.service-work');

Route::get('pdf-genset', [GensetPdfController::class, 'pdf'])->name('pdf.genset');
Route::get('pdf-operator', [OperatorPdfController::class, 'pdf'])->name('pdf.operator');
Route::get('pdf-jobdesk', [PlanJobPdfController::class, 'pdf'])->name('pdf.jobdesk');
Route::get('pdf-order', [OrderPdfController::class, 'pdf'])->name('pdf.order');
Route::get('pdf-income', [IncomePdfController::class, 'pdf'])->name('pdf.income');
Route::get('pdf-outcome', [OutcomePdfController::class, 'pdf'])->name('pdf.outcome');
Route::get('pdf-monitoring', [MonitoringPdfController::class, 'pdf'])->name('pdf.monitoring');
Route::get('pdf-service', [ServicePdfController::class, 'pdf'])->name('pdf.service');
