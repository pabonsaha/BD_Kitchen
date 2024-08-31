<?php


use App\Http\Controllers\AttributeController;
use App\Http\Controllers\BackgroundSettingsController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\ColorThemeController;
use App\Http\Controllers\ContactRequestController;
use App\Http\Controllers\EmailCampaignController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FileSystemController;
use App\Http\Controllers\FooterWidgetController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\OrderClaimController;
use App\Http\Controllers\OrderClaimReplyController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MyOrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ShopSettingController;
use App\Http\Controllers\EmailSettingController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\BlogPostDetailController;
use App\Http\Controllers\BulkExportController;
use App\Http\Controllers\BulkImportController;
use App\Http\Controllers\DesignerContactController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\GalleryDetailsController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\GlobalSettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticeBoardController;
use App\Http\Controllers\NoticeTypeController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductRequestController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\SpecialSectionController;
use App\Http\Controllers\SpecialSectionDetailController;
use App\Http\Controllers\SpecialSectionCategoryController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\SubscripitonController;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\PaymentController;
use Stripe\SetupIntent;
use Stripe\Stripe;

use Stripe\Checkout\Session as StripeSession;

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

Route::get('/', [HomeController::class,'index'])->name('home');




Route::middleware(['auth', 'is_subscribed'])->group(function () {


});

