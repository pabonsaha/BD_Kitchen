<?php



use App\Http\Controllers\Admin\BackgroundSettingsController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\ColorThemeController;
use App\Http\Controllers\Admin\ContactRequestController;
use App\Http\Controllers\Admin\EmailCampaignController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EventTypeController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FileSystemController;
use App\Http\Controllers\Admin\FooterWidgetController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\OrderClaimController;
use App\Http\Controllers\Admin\OrderClaimReplyController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SubscriberController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\MyOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ShopSettingController;
use App\Http\Controllers\Admin\EmailSettingController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\BlogPostDetailController;
use App\Http\Controllers\Admin\BulkExportController;
use App\Http\Controllers\Admin\BulkImportController;
use App\Http\Controllers\Admin\DesignerContactController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\ExpenseTypeController;
use App\Http\Controllers\Admin\GalleryDetailsController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\GlobalSettingController;
use App\Http\Controllers\Admin\NoticeBoardController;
use App\Http\Controllers\Admin\NoticeTypeController;
use App\Http\Controllers\Admin\OrderItemController;
use App\Http\Controllers\Admin\ProductRequestController;
use App\Http\Controllers\Admin\ShippingAddressController;
use App\Http\Controllers\Admin\SpecialSectionController;
use App\Http\Controllers\Admin\SpecialSectionDetailController;
use App\Http\Controllers\Admin\SpecialSectionCategoryController;
use App\Http\Controllers\Admin\StripeWebhookController;
use App\Http\Controllers\Admin\SubscripitonController;

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

Route::get('/', function () {
    return redirect('/login');
});




Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');


    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/index', [ProductController::class, 'index'])->name('index')->middleware('checkPermission:product_read');
        Route::get('/create', [ProductController::class, 'create'])->name('create')->middleware('checkPermission:product_create');
        Route::post('/store', [ProductController::class, 'store'])->name('store')->middleware('checkPermission:product_create');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit')->middleware('checkPermission:product_update');
        Route::post('/update', [ProductController::class, 'update'])->name('update')->middleware('checkPermission:product_update');
        Route::post('/destroy', [ProductController::class, 'destroy'])->name('destroy')->middleware('checkPermission:product_delete');
        Route::post('image/destroy', [ProductController::class, 'imageDestroy'])->name('image.destroy');
        Route::post('/attribute_value/list', [ProductController::class, 'attributeValueList'])->name('attribute_value.list');
        Route::post('/change-status', [ProductController::class, 'changeStatus'])->name('changeStatus')->middleware('checkPermission:product_status_change');
        Route::get('/user/{id}', [ProductController::class, 'user'])->name('user');
    });

    Route::prefix('bulk-import')->name('bulkImport.')->group(function () {
        Route::get('/', [BulkImportController::class, 'index'])->name('index')->middleware('checkPermission:bulk_import_read');
        Route::post('/', [BulkImportController::class, 'import'])->name('import')->middleware('checkPermission:bulk_import_read');

        Route::get('/product-export', [BulkImportController::class, 'productExport'])->name('productExport')->middleware('checkPermission:bulk_export_read');
        Route::get('/category-export', [BulkImportController::class, 'categoryExport'])->name('categoryExport')->middleware('checkPermission:bulk_export_read');
        Route::get('/brand-export', [BulkImportController::class, 'brandExport'])->name('brandExport')->middleware('checkPermission:bulk_export_read');
    });


    Route::prefix('bulk-export')->name('bulkExport.')->group(function () {
        Route::get('/', [BulkExportController::class, 'index'])->name('index');
        Route::post('/export', [BulkExportController::class, 'export'])->name('export');
    });


    Route::prefix('category')->name('category.')->group(function () {

        Route::get('/', [CategoryController::class, 'index'])->name('index')->middleware('checkPermission:category_read');
        Route::post('/store', [CategoryController::class, 'store'])->name('store')->middleware('checkPermission:category_create');
        Route::get('/{id}', [CategoryController::class, 'edit'])->name('edit')->middleware('checkPermission:category_update');
        Route::post('/update', [CategoryController::class, 'update'])->name('update')->middleware('checkPermission:category_update');
        Route::post('/destroy', [CategoryController::class, 'destroy'])->name('destroy')->middleware('checkPermission:category_delete');
    });

    Route::prefix('brand')->name('brand.')->group(function () {

        Route::get('/', [BrandController::class, 'index'])->name('index')->middleware('checkPermission:brand_read');
        Route::post('/store', [BrandController::class, 'store'])->name('store')->middleware('checkPermission:brand_create');
        Route::get('/{id}', [BrandController::class, 'edit'])->name('edit')->middleware('checkPermission:brand_update');
        Route::post('/update', [BrandController::class, 'update'])->name('update')->middleware('checkPermission:brand_update');
        Route::post('/destroy', [BrandController::class, 'destroy'])->name('destroy')->middleware('checkPermission:brand_delete');
    });

    Route::prefix('attribute')->name('attribute.')->group(function () {
        Route::get('/', [AttributeController::class, 'index'])->name('index')->middleware('checkPermission:attribute_read');
        Route::post('/store', [AttributeController::class, 'store'])->name('store')->middleware('checkPermission:attribute_create');
        Route::get('/{id}', [AttributeController::class, 'edit'])->name('edit')->middleware('checkPermission:attribute_update');
        Route::post('/update', [AttributeController::class, 'update'])->name('update')->middleware('checkPermission:attribute_update');
        Route::post('/destroy', [AttributeController::class, 'destroy'])->name('destroy')->middleware('checkPermission:attribute_delete');
        Route::prefix('value')->name('value.')->group(function () {
            Route::get('/{attribute_id}/values', [AttributeValueController::class, 'index'])->name('index')->middleware('checkPermission:attribute_value_create');
            Route::post('/store', [AttributeValueController::class, 'store'])->name('store')->middleware('checkPermission:attribute_value_create');
            Route::get('/{id}', [AttributeValueController::class, 'edit'])->name('edit')->middleware('checkPermission:attribute_value_update');
            Route::post('/update', [AttributeValueController::class, 'update'])->name('update')->middleware('checkPermission:attribute_value_update');
            Route::post('/destroy', [AttributeValueController::class, 'destroy'])->name('destroy')->middleware('checkPermission:attribute_value_delete');
        });
    });


    Route::prefix('manufacturers')->name('vendor.')->group(function () {
        Route::get('/', [VendorController::class, 'index'])->name('index')->middleware('checkPermission:manufacturer_read');
        Route::post('/store', [VendorController::class, 'store'])->name('store')->middleware('checkPermission:manufacturer_create');
        Route::get('/{id}', [VendorController::class, 'edit'])->name('edit')->middleware('checkPermission:manufacturer_update');
        Route::post('/update', [VendorController::class, 'update'])->name('update')->middleware('checkPermission:manufacturer_update');
        Route::post('/destroy', [VendorController::class, 'destroy'])->name('destroy')->middleware('checkPermission:manufacturer_delete');
    });

    Route::prefix('unit')->name('unit.')->group(function () {
        Route::get('/', [UnitController::class, 'index'])->name('index')->middleware('checkPermission:unit_read');
        Route::post('/store', [UnitController::class, 'store'])->name('store')->middleware('checkPermission:unit_create');
        Route::get('/{id}', [UnitController::class, 'edit'])->name('edit')->middleware('checkPermission:unit_update');
        Route::post('/update', [UnitController::class, 'update'])->name('update')->middleware('checkPermission:unit_update');
        Route::post('/destroy', [UnitController::class, 'destroy'])->name('destroy')->middleware('checkPermission:unit_delete');
    });

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index')->middleware('checkPermission:customer_cart_list_read');
        Route::get('/details/{user_id}', [CartController::class, 'details'])->name('details')->middleware('checkPermission:customer_cart_list_details');
    });

    Route::prefix('product-request')->name('productRequest.')->group(function () {
        Route::get('/', [ProductRequestController::class, 'index'])->name('index')->middleware("checkPermission:customer_order_product_request_read");
        Route::get('/details/{user_id}', [ProductRequestController::class, 'details'])->name('details');
        Route::post('/approve-product-request', [ProductRequestController::class, 'approve'])->name('approve')->middleware("checkPermission:customer_order_product_request_approve");
        Route::post('/cancel-product-request', [ProductRequestController::class, 'cancel'])->name('cancel')->middleware("checkPermission:customer_order_product_request_cancel");
        Route::post('/add-to-cart-product-request', [ProductRequestController::class, 'addToCart'])->name('addToCart');
    });

    Route::prefix('order')->name('order.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index')->middleware('checkPermission:customer_order_list_read');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/details/{order_id}', [OrderController::class, 'details'])->name('details')->middleware('checkPermission:customer_order_list_details');
        Route::get('/edit/{order_id}', [OrderController::class, 'edit'])->name('edit')->middleware('checkPermission:customer_order_list_edit');
        Route::post('/update', [OrderController::class, 'update'])->name('update')->middleware('checkPermission:customer_order_list_update');
        Route::post('/destroy', [OrderController::class, 'destroy'])->name('destroy')->middleware('checkPermission:customer_order_list_delete');
        Route::get('/invoice-preview/{order_id}', [OrderController::class, 'invoicePreview'])->name('invoicePreview')->middleware('checkPermission:customer_order_list_read_invoice');
        Route::get('/invoice-print/{order_id}', [OrderController::class, 'invoicePrint'])->name('invoicePrint')->middleware('checkPermission:customer_order_list_read_invoice');
        Route::get('/invoice-download/{order_id}', [OrderController::class, 'invoiceDownload'])->name('invoiceDownload')->middleware('checkPermission:customer_order_list_read_invoice');
        Route::post('/invoice-send', [OrderController::class, 'sendInvoice'])->name('sendInvoice');
        Route::get('/product/{id}', [OrderController::class, 'getProduct']);

        Route::prefix('items')->name('items.')->group(function () {
            Route::post('/status/store', [OrderItemController::class, 'statusStore'])->name('status.store');
        });
    });

    Route::prefix('order-claim')->name('order-claim.')->group(function () {
        Route::get('/', [OrderClaimController::class, 'index'])->name('index')->middleware('checkPermission:customer_order_claim_read');
        Route::get('/details/{id}', [OrderClaimController::class, 'details'])->name('details')->middleware('checkPermission:customer_order_claim_details');
        Route::post('/status-change', [OrderClaimController::class, 'statusChange'])->name('statusChange')->middleware('checkPermission:customer_order_claim_status_change');
    });

    Route::prefix('order-claim-reply')->name('order-claim-reply.')->group(function () {
        Route::post('/store', [OrderClaimReplyController::class, 'store'])->name('store')->middleware('checkPermission:customer_order_claim_reply');
    });


    Route::prefix('myOrder')->name('myOrder.')->group(function () {

        Route::prefix('order')->name('order.')->group(function () {
            Route::get('/', [MyOrderController::class, 'index'])->name('index')->middleware('checkPermission:my_order_read');
            Route::get('/details/{order_id}', [MyOrderController::class, 'details'])->name('details')->middleware('checkPermission:my_order_list_details');
            Route::get('/make-payment/{order_id}', [MyOrderController::class, 'makePayment'])->name('makePayment')->middleware('checkPermission:make_payment');
            Route::get('/checkout/success', [MyOrderController::class, 'checkoutSuccess'])->name('checkout-success')->middleware('checkPermission:make_payment');
            Route::view('/checkout/cancel', 'checkout.cancel')->name('checkout-cancel');
        });

        Route::prefix('cart')->name('cart.')->group(function () {
            Route::get('/', [MyOrderController::class, 'cartList'])->name('index')->middleware('checkPermission:my_order_cart_list_read');
        });
    });


    Route::prefix('section')->name('section.')->group(function () {
        Route::prefix('category')->name('category.')->group(function () {
            Route::get('/index', [SpecialSectionCategoryController::class, 'index'])->name('index')->middleware('checkPermission:section_category_read');
            Route::post('/store', [SpecialSectionCategoryController::class, 'store'])->name('store')->middleware('checkPermission:section_category_create');
            Route::get('/{id}', [SpecialSectionCategoryController::class, 'edit'])->name('edit')->middleware('checkPermission:section_category_update');
            Route::post('/update', [SpecialSectionCategoryController::class, 'update'])->name('update')->middleware('checkPermission:section_category_update');
            Route::post('/destroy', [SpecialSectionCategoryController::class, 'destroy'])->name('destroy')->middleware('checkPermission:section_category_delete');
        });

        Route::prefix('portfolioAndInspiration')->name('portfolioAndInspiration.')->group(function () {

            Route::get('/{section_type}/index', [SpecialSectionController::class, 'index'])->name('index')->middleware('checkPermission:portfolio_and_inspiration_read');
            Route::post('/{section_type}/store', [SpecialSectionController::class, 'store'])->name('store')->middleware('checkPermission:portfolio_and_inspiration_create');
            Route::get('/{section_type}/{id}', [SpecialSectionController::class, 'edit'])->name('edit')->middleware('checkPermission:portfolio_and_inspiration_update');
            Route::post('/{section_type}/update', [SpecialSectionController::class, 'update'])->name('update')->middleware('checkPermission:portfolio_and_inspiration_update');
            Route::post('/{section_type}/destroy', [SpecialSectionController::class, 'destroy'])->name('destroy')->middleware('checkPermission:portfolio_and_inspiration_delete');

            Route::get('/{section_id}/details/create', [SpecialSectionDetailController::class, 'create'])->name('details.create');
            Route::post('/{section_id}/details/store', [SpecialSectionDetailController::class, 'store'])->name('details.store');
        });
    });

    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::get('/list', [GalleryController::class, 'index'])->name('index')->middleware('checkPermission:gallery_read');
        Route::post('/store', [GalleryController::class, 'store'])->name('store')->middleware('checkPermission:gallery_create');
        Route::get('/{id}', [GalleryController::class, 'edit'])->name('edit')->middleware('checkPermission:gallery_update');
        Route::post('/update', [GalleryController::class, 'update'])->name('update')->middleware('checkPermission:gallery_update');
        Route::post('/destroy', [GalleryController::class, 'destroy'])->name('destroy')->middleware('checkPermission:gallery_delete');

        Route::prefix('details')->name('details.')->group(function () {
            Route::get('/{gallery_id}', [GalleryDetailsController::class, 'index'])->name('index')->middleware('checkPermission:read_images');
            Route::post('/store', [GalleryDetailsController::class, 'store'])->name('store')->middleware('checkPermission:create_image');
        });
    });

    Route::prefix('event-management')->name('event-management.')->group(function () {
        Route::prefix('event')->name('event.')->group(function () {
            Route::get("/", [EventController::class, 'index'])->name('index')->middleware('checkPermission:event_read');
            Route::post('/store', [EventController::class, 'store'])->name('store')->middleware('checkPermission:event_create');
            Route::get('/edit/{id}', [EventController::class, 'edit'])->name('edit')->middleware('checkPermission:event_update');
            Route::post('/update', [EventController::class, 'update'])->name('update')->middleware('checkPermission:event_update');
            Route::post('/changeStatus', [EventController::class, 'changeStatus'])->name('change-status')->middleware('checkPermission:event_change_status');
            Route::post('/delete', [EventController::class, 'delete'])->name('delete')->middleware('checkPermission:event_delete');

            // assign user
            Route::get('/assign-user/{event_id}', [EventController::class, 'assignUser'])->name('assign-user')->middleware('checkPermission:assign_user_read');
            Route::get('/get-users-by-type', [EventController::class, 'getUsersByType'])->name('get-users-by-type')->middleware('checkPermission:assign_user_read');
            Route::post('/event/{id}/update', [EventController::class, 'updateEventWithUser'])->name('update-event')->middleware('checkPermission:assign_user_read');

            Route::get("/calender", [EventController::class, 'calender'])->name('calender')->middleware('checkPermission:event_calender_read');
            Route::get("/calender-events", [EventController::class, 'calenderEvents'])->name('calenderEvents');

        });
        Route::prefix('types')->name('type.')->group(function () {
            Route::get('/', [EventTypeController::class, 'index'])->name('index')->middleware('checkPermission:event_type_read');
            Route::post('/store', [EventTypeController::class, 'store'])->name('store')->middleware('checkPermission:event_type_create');
            Route::get('/edit/{id}', [EventTypeController::class, 'edit'])->name('edit')->middleware('checkPermission:event_type_update');
            Route::post('/update', [EventTypeController::class, 'update'])->name('update')->middleware('checkPermission:event_type_update');
            Route::post('/change-status', [EventTypeController::class, 'changeStatus'])->name('change-status')->middleware('checkPermission:event_type_change_status');
            Route::post('/delete', [EventTypeController::class, 'delete'])->name('delete')->middleware('checkPermission:event_type_delete');
        });
    });

    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/category', [BlogCategoryController::class, 'index'])->name('category.index')->middleware('checkPermission:blog_category_read');
        Route::post('category/change-status', [BlogCategoryController::class, 'changeStatus'])->name('category.changeStatus')->middleware('checkPermission:blog_category_status_change');
        Route::post('/category/store', [BlogCategoryController::class, 'store'])->name('category.store')->middleware('checkPermission:blog_category_create');
        Route::get('/category/{id}', [BlogCategoryController::class, 'edit'])->name('category.edit')->middleware('checkPermission:blog_category_update');
        Route::post('/category/update', [BlogCategoryController::class, 'update'])->name('category.update')->middleware('checkPermission:blog_category_update');
        Route::post('/destroy', [BlogCategoryController::class, 'destroy'])->name('category.destroy')->middleware('checkPermission:blog_category_delete');

        Route::prefix('post')->name('post.')->group(function () {
            Route::get('/', [BlogPostController::class, 'index'])->name('index')->middleware('checkPermission:blog_post_read');
            Route::post('/change-status', [BlogPostController::class, 'changeStatus'])->name('changeStatus')->middleware('checkPermission:blog_post_status_change');
            Route::post('/change-publish-status', [BlogPostController::class, 'changePublishStatus'])->name('changePublishStatus')->middleware('checkPermission:blog_post_publish_status_change');
            Route::get('/create', [BlogPostController::class, 'create'])->name('create')->middleware('checkPermission:blog_post_create');
            Route::post('/store', [BlogPostController::class, 'store'])->name('store')->middleware('checkPermission:blog_post_create');
            Route::delete('/delete', [BlogPostController::class, 'destroy'])->name('delete')->middleware('checkPermission:blog_post_delete');
            Route::get('/post-details/{id}', [BlogPostController::class, 'show'])->name('show')->middleware('checkPermission:blog_post_read');
            Route::get('/post-details/{id}/edit', [BlogPostController::class, 'edit'])->name('edit')->middleware('checkPermission:blog_post_update');
            Route::post('/update/{id}', [BlogPostController::class, 'update'])->name('update')->middleware('checkPermission:blog_post_update');
        });
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/list/{role_id}', [UserController::class, 'index'])->name('index')->middleware('checkPermission:user_management_read');
        Route::get('/employee-list', [UserController::class, 'employeeList'])->name('employeeList')->middleware('checkPermission:employees_read');
        Route::get('/profile/{user:id}', [UserController::class, 'profile'])->name('profile');
        Route::get('/orders/{user_id}', [UserController::class, 'orders'])->name('orders');
        Route::get('/carts/{user_id}', [UserController::class, 'carts'])->name('carts');
        Route::get('/wishlist/{user_id}', [UserController::class, 'wishlist'])->name('wishlist');
        Route::get('/products/{user_id}', [UserController::class, 'products'])->name('products');

        Route::post('/password-reset', [UserController::class, 'passwordReset'])->name('passwordReset');
        Route::post('/update', [UserController::class, 'update'])->name('update');
        Route::post('/change-status', [UserController::class, 'changeStatus'])->name('changeStatus');


        Route::post('/shop-info-update', [UserController::class, 'shopInfoUpdate'])->name('shopInfoUpdate')->middleware('checkPermission:site_info_update');
        Route::post('/shop-logo-update', [UserController::class, 'shoplogoUpdate'])->name('shoplogoUpdate')->middleware('checkPermission:site_logo_update');
        Route::post('/shop-link-update', [UserController::class, 'shoplinkUpdate'])->name('shoplinkUpdate')->middleware('checkPermission:social_links_update');

        Route::post('/destroy', [UserController::class, 'destroy'])->name('destroy');

        Route::post('/store', [UserController::class, 'store'])->name('store');
    });


    Route::prefix('subscriber')->name('subscriber.')->group(function () {
        Route::get('/index', [SubscriberController::class, 'index'])->name('index')->middleware('checkPermission:subscribers_read');
        Route::get('/{id}', [SubscriberController::class, 'get'])->name('get')->middleware('checkPermission:subscribers_read');
        Route::post('/change-status', [SubscriberController::class, 'changeStatus'])->name('changeStatus')->middleware('checkPermission:subscribers_status_change');
        Route::post('/send-reply', [SubscriberController::class, 'sendReply'])->name('sendReply')->middleware('checkPermission:subscribers_reply');
    });

    Route::prefix('marketing')->name('marketing.')->group(function () {
        Route::get('/email-campaign', [EmailCampaignController::class, 'index'])->name('campaign.index')->middleware('checkPermission:email_campaign_read');
        Route::post('/email-campaign', [EmailCampaignController::class, 'store'])->name('store')->middleware('checkPermission:add_email_campaign');
        Route::post('/change-status', [EmailCampaignController::class, 'changeStatus'])->name('changeStatus')->middleware('checkPermission:email_campaign_status_change');
        Route::get('/campaign/{id}/edit', [EmailCampaignController::class, 'edit'])->name('marketing.campaign.edit')->middleware('checkPermission:email_campaign_update');
        Route::post('/campaign', [EmailCampaignController::class, 'update'])->name('marketing.campaign.update')->middleware('checkPermission:email_campaign_update');
        Route::delete('/delete', [EmailCampaignController::class, 'destroy'])->name('delete')->middleware('checkPermission:email_campaign_delete');
        Route::get('/assign-email-users/{id}', [EmailCampaignController::class, 'launch'])->name('launch.index')->middleware('checkPermission:email_campaign_assign_user');
        Route::get('/get-users-by-type', [EmailCampaignController::class, 'getUsersByType'])->name('get-users-by-type');
        Route::post('/email-campaign/{id}/update-emails', [EmailCampaignController::class, 'updateEmailcampaignEmails'])->name('updateEmailcampaignEmails')->middleware('checkPermission:email_campaign_update');
        Route::post('/send-email', [EmailCampaignController::class, 'sendEmail'])->name('send.email')->middleware('checkPermission:email_campaign_status_change');
    });


    Route::prefix('expense-management')->name('expense-management.')->group(function () {
        Route::get('/expense-type', [ExpenseTypeController::class, 'index'])->name('type.index');
        Route::post('/expense-type/store', [ExpenseTypeController::class, 'store'])->name('type.store');
        Route::post('/change-status', [ExpenseTypeController::class, 'changeStatus'])->name('changeStatus');
        Route::get('/expense-type/{id}', [ExpenseTypeController::class, 'edit'])->name('type.edit');
        Route::post('/expense-type/update', [ExpenseTypeController::class, 'update'])->name('type.update');
        Route::post('/destroy', [ExpenseTypeController::class, 'destroy'])->name('type.destroy');

        Route::prefix('expenses')->name('expenses.')->group(function () {
            Route::get('/', [ExpenseController::class, 'index'])->name('index');
            Route::post('/store', [ExpenseController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ExpenseController::class, 'edit'])->name('edit');
            Route::post('/', [ExpenseController::class, 'update'])->name('update');
            Route::delete('/delete', [ExpenseController::class, 'destroy'])->name('destroy');
            Route::post('/change-status', [ExpenseController::class, 'changeStatus'])->name('changeStatus');
        });

    });

    Route::prefix('notice-board')->name('notice-board.')->group(function () {
        Route::get('/notice-type', [NoticeTypeController::class, 'index'])->name('type.index');
        Route::post('/notice-type/store', [NoticeTypeController::class, 'store'])->name('type.store');
        Route::post('/change-status', [NoticeTypeController::class, 'changeStatus'])->name('changeStatus');
        Route::get('/notice-type/{id}', [NoticeTypeController::class, 'edit'])->name('type.edit');
        Route::post('/notice-type/update', [NoticeTypeController::class, 'update'])->name('type.update');
        Route::post('/destroy', [NoticeTypeController::class, 'destroy'])->name('type.destroy');

        Route::prefix('notice')->name('notice.')->group(function () {
            Route::get('/', [NoticeBoardController::class, 'index'])->name('index');
            Route::post('/store', [NoticeBoardController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [NoticeBoardController::class, 'edit'])->name('edit');
            Route::post('/update', [NoticeBoardController::class, 'update'])->name('update');
            Route::delete('/delete', [NoticeBoardController::class, 'destroy'])->name('destroy');
            Route::post('/change-status', [NoticeBoardController::class, 'changeStatus'])->name('changeStatus');
            Route::get('/assign-recievers/{id}', [NoticeBoardController::class, 'assign'])->name('assign');
            Route::get('/get-users-by-type', [NoticeBoardController::class, 'getUsersByType'])->name('get-users-by-type');
            Route::get('/get-users-by-ids', [NoticeBoardController::class, 'getUsersByIds'])->name('get-users-by-ids');
            Route::post('/{id}/update-receivers', [NoticeBoardController::class, 'updateNoticeBoardReceivers'])->name('updateReceivers');

        });

    });

    Route::prefix('contact-request')->name('contact-request.')->group(function () {
        Route::get('/', [ContactRequestController::class, 'index'])->name('index')->middleware('checkPermission:contact_request_read');
        Route::post('/change-status', [ContactRequestController::class, 'changeStatus'])->name('changeStatus')->middleware('checkPermission:contact_request_status_change');
        Route::delete('/delete', [ContactRequestController::class, 'destroy'])->name('delete')->middleware('checkPermission:contact_request_delete');
        Route::get('/{id}', [ContactRequestController::class, 'getContactRequest'])->name('get')->middleware('checkPermission:contact_request_read');
        Route::post('/send-reply', [ContactRequestController::class, 'sendReply'])->name('sendReply')->middleware('checkPermission:contact_request_reply');
    });


    Route::prefix('designer-contact')->name('designer-contact.')->group(function () {
        Route::get('/', [DesignerContactController::class, 'index'])->name('index')->middleware('checkPermission:designer_contact_read');
        Route::get('/{id}', [DesignerContactController::class, 'getDesignerContact'])->name('get')->middleware('checkPermission:designer_contact_read');
        Route::delete('/delete', [DesignerContactController::class, 'destroy'])->name('delete')->middleware('checkPermission:designer_contact_delete');
        Route::post('/send-reply', [DesignerContactController::class, 'sendReply'])->name('sendReply')->middleware('checkPermission:designer_contact_reply');
    });

    Route::prefix('role')->name('role.')->group(function () {
        Route::get('/index', [RoleController::class, 'index'])->name('index')->middleware('checkPermission:role_read');
        Route::post('/store', [RoleController::class, 'store'])->name('store')->middleware('checkPermission:role_create');
        Route::post('/update', [RoleController::class, 'update'])->name('update')->middleware('checkPermission:role_update');
        Route::post('/delete', [RoleController::class, 'destroy'])->name('destroy')->middleware('checkPermission:role_delete');
        Route::get('/assign-permission/{id}', [RoleController::class, 'assignPermission'])->name('assignPermission')->middleware('checkPermission:give_permission');
        Route::post('/permission-update', [RoleController::class, 'permissionUpdate'])->name('permissionUpdate')->middleware('checkPermission:give_permission');
    });

    Route::prefix('cms')->name('cms.')->group(function () {
        Route::prefix('footer-widget')->name('footer-widget.')->group(function () {
            Route::get('/', [FooterWidgetController::class, 'index'])->name('index')->middleware('checkPermission:footer_widget_read');
            Route::get('/{id}', [FooterWidgetController::class, 'edit'])->name('edit')->middleware('checkPermission:footer_widget_update');
            Route::post('/update', [FooterWidgetController::class, 'update'])->name('update')->middleware('checkPermission:footer_widget_update');
            Route::post('/destroy', [FooterWidgetController::class, 'destroy'])->name('destroy')->middleware('checkPermission:footer_widget_delete');
        });

        Route::prefix('pages')->name('pages.')->group(function () {
            Route::get('/', [PageController::class, 'index'])->name('index')->middleware('checkPermission:pages_read');
            Route::get('/edit/{id}', [PageController::class, 'edit'])->name('edit')->middleware('checkPermission:pages_update');
            Route::post('/update', [PageController::class, 'update'])->name('update')->middleware('checkPermission:pages_update');
            Route::post('/change-status', [PageController::class, 'changeStatus'])->name('changeStatus');
        });

        Route::prefix('faq')->name('faq.')->group(function () {
            Route::get('/', [FaqController::class, 'index'])->name('index')->middleware('checkPermission:faqs_read');
            Route::post('/store', [FaqController::class, 'store'])->name('store')->middleware('checkPermission:faqs_create');
            Route::get('/edit/{id}', [FaqController::class, 'edit'])->name('edit')->middleware('checkPermission:faqs_update');
            Route::post('/update', [FaqController::class, 'update'])->name('update')->middleware('checkPermission:faqs_update');
            Route::post('/delete', [FaqController::class, 'destroy'])->name('destroy')->middleware('checkPermission:faqs_delete');
        });

        Route::prefix('slider')->name('slider.')->group(function () {
           Route::get('/', [SliderController::class, 'index'])->name('index')->middleware('checkPermission:slider_read');
           Route::post('/store', [SliderController::class, 'store'])->name('store')->middleware('checkPermission:slider_create');
           Route::get('/edit/{id}', [SliderController::class, 'edit'])->name('edit')->middleware('checkPermission:slider_update');
           Route::post('/update', [SliderController::class, 'update'])->name('update')->middleware('checkPermission:slider_update');
           Route::post('/change-status', [SliderController::class, 'changeStatus'])->name('changeStatus')->middleware('checkPermission:slider_status_change');
           Route::post('/delete-slider', [SliderController::class, 'delete'])->name('destroy')->middleware('checkPermission:slider_delete');
        });
    });

    Route::prefix('subscription')->name('subscription.')->group(function () {
        Route::prefix('plan')->name('plan.')->group(function () {
            Route::get('/', [PlanController::class, 'index'])->name('index')->middleware('checkPermission:plan_read');
            Route::post('/store', [PlanController::class, 'store'])->name('store')->middleware('checkPermission:plan_create');
            Route::get('/edit/{id}', [PlanController::class, 'edit'])->name('edit')->middleware('checkPermission:plan_update');
            Route::post('/update', [PlanController::class, 'update'])->name('update')->middleware('checkPermission:plan_update');
            Route::post('/destroy', [PlanController::class, 'destroy'])->name('destroy');
            Route::post('/change-status', [PlanController::class, 'changeStatus'])->name('changeStatus')->middleware('checkPermission:plan_status_change');
            Route::post('/make-popular', [PlanController::class, 'makePopular'])->name('makePopular')->middleware('checkPermission:plan_make_popular');

            Route::get('/buy-plan',[PlanController::class,'buyPlan'])->name('buyPlan')->withoutMiddleware('is_subscribed');
            Route::post('/plan-make-payment',[PlanController::class,'makePayment'])->name('make-payment')->withoutMiddleware('is_subscribed');

        });
        Route::prefix('customer')->name('customer.')->group(function () {
            Route::get('/', [SubscripitonController::class, 'index'])->name('index');
            Route::get('/details/{user_id}', [SubscripitonController::class, 'details'])->name('details');

            Route::get('/invoice-preview/{invoice_no}', [SubscripitonController::class, 'invoicePreview'])->name('invoicePreview');
            Route::get('/invoice-print/{order_id}', [SubscripitonController::class, 'invoicePrint'])->name('invoicePrint');
            Route::get('/invoice-download/{order_id}', [SubscripitonController::class, 'invoiceDownload'])->name('invoiceDownload');

            Route::get('/stripe-generate-invoice/{invoice_no}', [SubscripitonController::class, 'stripeGenerateInvoice'])->name('stripeGenerateInvoice');

            Route::get('/immediate-cancel-stripe-subscription/{user_id}',[SubscripitonController::class,'immediateSubscriptionCancel'])->name('immediateSubscriptionCancel');
            Route::get('/revoke-cancel-stripe-subscription/{user_id}',[SubscripitonController::class,'revokeSubscriptionCancel'])->name('revokeSubscriptionCancel');

        });
    });

    Route::prefix('setting')->name('setting.')->group(function () {
        Route::prefix('/general-setting')->name('general-setting.')->group(function () {
            Route::get('/', [GeneralSettingController::class, 'index'])->name('index')->middleware('checkPermission:general_settings_read');
            Route::Post('/system-info/store', [GeneralSettingController::class, 'storeSystemInfo'])->name('system_info.store')->middleware('checkPermission:general_settings_update');
        });

        Route::prefix('/payment-method')->name('payment-method.')->group(function () {
            Route::get('/', [PaymentMethodController::class, 'index'])->name('index')->middleware('checkPermission:payment_method_read');
            Route::post('/stripe-credential-store', [PaymentMethodController::class, 'stripeCredentialStore'])->name('stripeCredentialStore')->middleware('checkPermission:payment_method_create');
            Route::post('/paypal-credential-store', [PaymentMethodController::class, 'paypalCredentialStore'])->name('paypalCredentialStore')->middleware('checkPermission:payment_method_create');

            Route::post('/stripe-change-status', [PaymentMethodController::class, 'stripeChangeStatus'])->name('stripeChangeStatus')->middleware('checkPermission:payment_method_status_change');
            Route::post('/paypal-change-status', [PaymentMethodController::class, 'paypalChangeStatus'])->name('paypalChangeStatus')->middleware('checkPermission:payment_method_status_change');
        });

        Route::prefix('file-system')->name('file-system.')->group(function () {
            Route::get('/', [FileSystemController::class, 'index'])->name('index')->middleware('checkPermission:file_system_read');
            Route::post('/credentials/store', [FileSystemController::class, 'storeCredentials'])->name('storeCredentials')->middleware('checkPermission:file_system_update');
        });

        Route::prefix('/global-setting')->name('global-setting.')->group(function () {
            Route::get('/', [GlobalSettingController::class, 'index'])->name('index')->middleware('checkPermission:global_settings_read');
            Route::post('/update', [GlobalSettingController::class, 'update'])->name('update')->middleware('checkPermission:global_settings_update');
        });

        Route::prefix('/email-setting')->name('email-setting.')->group(function () {
            Route::get('/', [EmailSettingController::class, 'index'])->name('index')->middleware('checkPermission:email_settings_read');
            Route::post('/store', [EmailSettingController::class, 'store'])->name('store')->middleware('checkPermission:email_settings_create');
            Route::post('/send-mail', [EmailSettingController::class, 'sendTestEmail'])->name('sendTestEmail')->middleware('checkPermission:send_test_email');
        });

        Route::prefix('/shop-setting')->name('shop-setting.')->group(function () {
            Route::get('/', [ShopSettingController::class, 'index'])->name('index')->middleware('checkPermission:shop_settings_read');
            Route::Post('/system-info/store', [ShopSettingController::class, 'storeSystemInfo'])->name('system_info.store');
            Route::Post('/site-logo/store', [ShopSettingController::class, 'storeSiteLogo'])->name('site_logo.store');
            Route::Post('/social-link/store', [ShopSettingController::class, 'storeSocialLink'])->name('social_link.store')->middleware('checkPermission:social_links_update');
            Route::Post('/terms-polices/store', [ShopSettingController::class, 'storeTermsPolices'])->name('terms_polices.store')->middleware('checkPermission:terms_and_policies_update');
        });

        Route::prefix('/color-themes')->name('color-themes.')->group(function () {
            Route::get('/', [ColorThemeController::class, 'index'])->name('index')->middleware('checkPermission:color_themes_read');
            Route::post('/store', [ColorThemeController::class, 'store'])->name('store')->middleware('checkPermission:color_themes_create');
            Route::get('/edit/{id}', [ColorThemeController::class, 'edit'])->name('edit')->middleware('checkPermission:color_themes_update');
            Route::post('/update', [ColorThemeController::class, 'update'])->name('update')->middleware('checkPermission:color_themes_update');
            Route::delete('/delete', [ColorThemeController::class, 'delete'])->name('delete')->middleware('checkPermission:color_themes_delete');
            Route::post('/apply', [ColorThemeController::class, 'applyTheme'])->name('apply')->middleware('checkPermission:color_themes_apply');
        });

        Route::prefix('/language')->name('language.')->group(function () {
            Route::get('/', [LanguageController::class, 'index'])->name('index')->middleware('checkPermission:language_settings_read');
            Route::post('/store', [LanguageController::class, 'store'])->name('store')->middleware('checkPermission:language_settings_create');
            Route::get('/edit/{id}', [LanguageController::class, 'edit'])->name('edit')->middleware('checkPermission:language_settings_update');
            Route::post('/update', [LanguageController::class, 'update'])->name('update')->middleware('checkPermission:language_settings_update');
            Route::delete('/delete', [LanguageController::class, 'delete'])->name('delete')->middleware('checkPermission:language_settings_delete');
            Route::post('/change-status', [LanguageController::class, 'changeStatus'])->name('changeStatus')->middleware('checkPermission:language_settings_status_change');
            Route::get('/setup/{code}', [LanguageController::class, 'setup'])->name('setup')->middleware('checkPermission:language_settings_read');
            Route::get("/read-file", [LanguageController::class, 'readFile'])->name('readFile')->middleware('checkPermission:language_settings_create');
            Route::post("/update/file", [LanguageController::class, 'updateFile'])->name('updateFile')->middleware('checkPermission:language_settings_update');
            Route::post("/change/language", [LanguageController::class, 'changeLanguage'])->name('changeLanguage')->middleware('checkPermission:language_settings_update');
        });

        Route::prefix('/background-settings')->name('background-settings.')->group(function () {
            Route::get('/', [BackgroundSettingsController::class, 'index'])->name('index')->middleware('checkPermission:background_settings_read');
            Route::post('/change-status', [BackgroundSettingsController::class, 'changeStatus'])->name('changeStatus')->middleware('checkPermission:background_settings_status_change');
            Route::delete('/delete', [BackgroundSettingsController::class, 'delete'])->name('delete')->middleware('checkPermission:background_settings_delete');
            Route::post('/store', [BackgroundSettingsController::class, 'store'])->name('store')->middleware('checkPermission:background_settings_create');
            Route::get('/edit/{id}', [BackgroundSettingsController::class, 'edit'])->name('edit')->middleware('checkPermission:background_settings_update');
            Route::post('/update', [BackgroundSettingsController::class, 'update'])->name('update')->middleware('checkPermission:background_settings_update');
        });
    });

    Route::post('/shippingAddress', [ShippingAddressController::class, 'store'])->name('shippingAddress.store');

});

Route::post('stripe/webhook', [StripeWebhookController::class,'handleWebhook'])->name('stripe.webhook')->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);


require __DIR__ . '/auth.php';



Route::get('/home',function()
{
    return view('user.home');
});
