<?php

use App\Http\Controllers\API\V1\BackgroundSettingsController;
use App\Http\Controllers\API\V1\BlogPostController;
use App\Http\Controllers\API\V1\ColorThemeController;
use App\Http\Controllers\API\V1\ContactUsController;
use App\Http\Controllers\API\V1\FaqController;
use App\Http\Controllers\API\V1\OrderClaimController;
use App\Http\Controllers\API\V1\SliderController;
use App\Http\Controllers\API\V1\SubscriberController;
use App\Http\Controllers\API\V1\SubscriptionController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\API\V1\CartController;
use App\Http\Controllers\API\V1\BrandController;
use App\Http\Controllers\API\V1\ProductController;
use App\Http\Controllers\API\V1\CategoryController;
use App\Http\Controllers\API\V1\DesignerContactController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\WishlistController;
use App\Http\Controllers\API\V1\ShopSettingController;
use App\Http\Controllers\API\V1\FooterWidgetController;
use App\Http\Controllers\API\V1\GalleryController;
use App\Http\Controllers\API\V1\GeneralSettingController;
use App\Http\Controllers\API\V1\OrderController;
use App\Http\Controllers\API\V1\ProfileController;
use App\Http\Controllers\API\V1\ShippingAddressController;
use App\Http\Controllers\API\V1\SpecialSectionController;
use App\Http\Controllers\API\V1\ProductRequestController;


Route::get('brands', [BrandController::class, 'list']);
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'list']);
    Route::get('products', [CategoryController::class, 'categoryWithProduct']);
});

Route::prefix('product')->group(function () {
    Route::get('/list', [ProductController::class, 'list']);
    Route::get('/filterItems', [ProductController::class, 'filterItems']);
    Route::get('/{product:id}', [ProductController::class, 'details']);
    Route::get('/{product:id}/related-products', [ProductController::class, 'relatedProducts']);
});


Route::get('/general-setting', [GeneralSettingController::class, 'index']);
Route::get('/shop-setting', [ShopSettingController::class, 'index']);
Route::get('/footer-widgets', [FooterWidgetController::class, 'widgets']);
Route::get('/page/{slug}', [FooterWidgetController::class, 'pageDetails']);


Route::prefix('designers')->group(function () {
    Route::get('/', [UserController::class, 'designers']);
});


Route::prefix('cart')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('/', [CartController::class, 'store']);
    Route::post('/destroy', [CartController::class, 'destroy']);
    Route::post('/update', [CartController::class, 'update']);
});



Route::prefix('request-product')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [ProductRequestController::class, 'store']);
    Route::get('/',[ProductRequestController::class,'index']);
});


Route::prefix('wishlist')->middleware('auth:sanctum')->group(function () {
    Route::post('/toggle', [WishlistController::class, 'toggle']);
    Route::get('/list', [WishlistController::class, 'list']);
});

Route::prefix('special-section')->group(function () {
    Route::get('/', [SpecialSectionController::class, 'list']);
    Route::get('/{section_id}', [SpecialSectionController::class, 'details']);
});

Route::prefix('order')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/details/{id}', [OrderController::class, 'details']);
    Route::get('/count', [OrderController::class, 'count']);
    Route::get('/invoice-download/{order_id}', [OrderController::class, 'invoiceDownload'])->name('invoiceDownload');

    Route::post('/make-payment', [OrderController::class, 'makePayment']);
    Route::post('/success-payment', [OrderController::class, 'checkoutSuccess']);

    Route::prefix('claim')->group(function () {
        Route::post('/', [OrderClaimController::class, 'claimOrder']);
        Route::get('/', [OrderClaimController::class, 'claimsByUser']);
        Route::get('/{order_id}', [OrderClaimController::class, 'claims']);
        Route::post('/{claim_id}/reply', [OrderClaimController::class, 'claimReply']);
        Route::get('/detail/{claim_id}', [OrderClaimController::class, 'claimDetails']);
        Route::get('/type/list', [OrderClaimController::class, 'types']);
    });
});

Route::get('/gallery', [GalleryController::class, 'index']);


Route::prefix('profile')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ProfileController::class, 'index']);
    Route::post('/update', [ProfileController::class, 'update']);
    Route::post('/password-change', [ProfileController::class, 'passwordChange']);
});

Route::get('/faq-list', [FaqController::class, 'list']);

Route::post('/subscribe', [SubscriberController::class, 'store']);


Route::prefix('shipping-address')->middleware('auth:sanctum')->group(function () {
    Route::get('/list', [ShippingAddressController::class, 'list']);
    Route::post('/store', [ShippingAddressController::class, 'store']);
    Route::post('/update', [ShippingAddressController::class, 'update']);
    Route::post('/destroy', [ShippingAddressController::class, 'destroy']);
    Route::get('/details/{id}', [ShippingAddressController::class, 'details']);
    Route::post('/change-status/{id}', [ShippingAddressController::class, 'changeStatus']);
});

Route::prefix('blogs')->group(function () {
    Route::get('/', [BlogPostController::class, 'index'])->name('post');
    Route::get('/details/{slug}', [BlogPostController::class, 'details']);
    Route::get("/categories", [BlogPostController::class, 'categories']);
});

Route::prefix('subscription')->name('subscription.')->group(function () {
    Route::prefix('plan')->name('plan.')->group(function () {
        Route::get('/{planFor?}', [SubscriptionController::class, 'index']);
        Route::get("/details/{id}", [SubscriptionController::class, 'details']);
        Route::post("/make-payment", [SubscriptionController::class, 'makePayment'])->middleware('auth:sanctum');    });
});

Route::get('/sliders/{type}', [SliderController::class, 'sliderList']);

Route::post('designer-contacts', [DesignerContactController::class, 'store']);
Route::get('/color-themes', [ColorThemeController::class, 'colorThemes']);
Route::post('/contact-us', [ContactUsController::class, 'contactUs']);
Route::get('/background-settings/{purpose}', [BackgroundSettingsController::class, 'backgroundSetting']);
Route::get('payment/methods', [SubscriptionController::class, 'paymentMethods']);
