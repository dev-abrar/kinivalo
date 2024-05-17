<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AllOrdersController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\BackBasicsController;
use App\Http\Controllers\BackCategoriesController;
use App\Http\Controllers\BackChangePassController;
use App\Http\Controllers\BackHomeController;
use App\Http\Controllers\BackOrdersController;
use App\Http\Controllers\BackPagesController;
use App\Http\Controllers\BackProductsController;
use App\Http\Controllers\BackSlidersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutURLController;
use App\Http\Controllers\FrontPagesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\FrontProductsController;
use App\Http\Controllers\HomePageSectionController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\VariationController;
use App\Http\Controllers\SeoPageController;
use App\Http\Controllers\CkEditorController;
use Illuminate\Support\Facades\Storage;

Route::get('/cache-clear', function () {
    Cache::forget('basic_data');
    Cache::forget('hotdeals1');
    Cache::forget('hotdeals2');
    Cache::forget('latest_products');
    Cache::forget('products_2');

    $directory = 'livewire-tmp';
    Storage::deleteDirectory($directory);
    Storage::makeDirectory($directory);
    
    return redirect()->back();
});

Route::get('/', [FrontProductsController::class, 'index'])->name('/');

Route::get('/hotdeals', [FrontProductsController::class, 'hotdeals']);
Route::get('/latest', [FrontProductsController::class, 'latest']);
Route::get('/product', [FrontProductsController::class, 'allProduct']);
Route::get('/product/{slug}', [FrontProductsController::class, 'single']);

Route::get('/search/{words}', [FrontProductsController::class, 'productsearch']);

Route::get('/category/{slug}', [FrontProductsController::class, 'itemsbyctg']);

## cart routes
Route::post('/cart/additem', [AllOrdersController::class, 'additem']);

Route::get('/cart', [AllOrdersController::class, 'cart'])->name('cart');

Route::post('/cart/update', [AllOrdersController::class, 'cartupdate']);
Route::post('/cart/remove', [AllOrdersController::class, 'cartremove']);

Route::post('/order/submit', [AllOrdersController::class, 'ordersubmit']);
Route::get('/order/confirm/{id}', [AllOrdersController::class, 'orderconfirm'])->name('confirm');
Route::get('/order/download_invoice/{id}', [AllOrdersController::class, 'download_invoice']);

Route::get('/order/track/{order_no}', [AllOrdersController::class, 'orderdetails']);
Route::post('/order/track', [AllOrdersController::class, 'ordertrack']);

Route::get('/page/{slug}', [FrontPagesController::class, 'index']);
//Route::get('/send/mail', [AllOrdersController::class, 'sendmail']);

Route::get('/verify', [FrontProductsController::class, 'verify'])->name('verify');
Route::post('/send_otp', [FrontProductsController::class, 'send_otp']);
Route::get('/verify_otp', [FrontProductsController::class, 'verify_otp_number'])->name('verify_otp');
Route::post('/otp_submit', [FrontProductsController::class, 'otp_submit']);

//Area
Route::POST('/area/district', [AreaController::class, 'district'])->name('area.district');
Route::post('/district-by-division', [AreaController::class, 'getDistrictsByDivision']);
Route::post('/thana-by-district', [AreaController::class, 'getThanaByDistrict']);

// admin Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [BackHomeController::class, 'index'])->name('dashboard');
    Route::get('/home', [BackHomeController::class, 'index']);

    Route::get('categories', [BackCategoriesController::class, 'index']);
    Route::post('category-save', [BackCategoriesController::class, 'store']);
    Route::post('category-savesub', [BackCategoriesController::class, 'addsub']);
    Route::delete('category-delete', [BackCategoriesController::class, 'destroy']);

    Route::put('category-edit', [BackCategoriesController::class, 'update']);
    Route::put('category-editsub', [BackCategoriesController::class, 'updatesub']);

    Route::get('/variations', [VariationController::class, 'index']);
    Route::post('/variation/save', [VariationController::class, 'store']);
    Route::post('/variation/save_option', [VariationController::class, 'save_option']);
    Route::put('/variation/editsub', [VariationController::class, 'update_option']);

    Route::get('/admin/home_setup', [HomePageSectionController::class, 'index']);
    Route::post('/admin/home_setup/save', [HomePageSectionController::class, 'store']);

    Route::get('/products', [BackProductsController::class, 'index']);
    Route::get('/products/add', [BackProductsController::class, 'create']);
    Route::get('/products/edit/{id}', [BackProductsController::class, 'edit']);
    Route::put('/products/update/{id}', [BackProductsController::class, 'update']);
    Route::get('/products/delete/{id}', [BackProductsController::class, 'destroy']);
    Route::post('/products/save', [BackProductsController::class, 'store']);
    Route::get('/product-gallary/{product_id}', [BackProductsController::class, 'productGallary']);
    Route::post('/product-gallary/update', [BackProductsController::class, 'productGallaryUpdate']);
    Route::get('/product-gallary/delete/{image_id}', [BackProductsController::class, 'productGallaryDelete']);
    Route::post('/product-gallary/add', [BackProductsController::class, 'productGallaryAdd']);

    Route::get('/admin/product/color/{id}', [BackProductsController::class, 'destroy_color']);

    Route::get('/orders', [BackOrdersController::class, 'index']);

    Route::get('/orders/filter/pending', [BackOrdersController::class, 'pendingorders']);
    Route::get('/orders/filter/processing', [BackOrdersController::class, 'processingorders']);
    Route::get('/orders/filter/hold', [BackOrdersController::class, 'holdingorders']);
    Route::get('/orders/filter/delivered', [BackOrdersController::class, 'deliveredorders']);
    Route::get('/orders/filter/complete', [BackOrdersController::class, 'completeorders']);
    Route::get('/orders/filter/shipping', [BackOrdersController::class, 'shippingorders']);
    Route::get('/orders/filter/cancel', [BackOrdersController::class, 'canceledorders']);

    //Route::get('/orders/filter/{status}', [BackOrdersController::class, 'filterOrder']);
    Route::get('/orders/{id}', [BackOrdersController::class, 'show']);
    Route::get('/orders/print/{id}', [BackOrdersController::class, 'order_print']);
    Route::post('/orders/{id}', [BackOrdersController::class, 'orderaccept']);
    Route::post('/orders/payment/{id}', [BackOrdersController::class, 'updatePaymentstatus']);
    Route::put('/orders/delivered/{id}', [BackOrdersController::class, 'orderdelivered']);
    Route::get('/orders/canceled/{id}', [BackOrdersController::class, 'ordercanceled']);
    Route::get('/orders/delete/{id}', [BackOrdersController::class, 'orderdelete']);
    Route::post('/orders/customerinfo/{order_id}', [BackOrdersController::class, 'updateCustomer']);
    Route::post('/orders-qt/{details_id}', [BackOrdersController::class, 'updateQt']);
    Route::post('/orders/discount/{id}', [BackOrdersController::class, 'updateDiscount']);
    Route::post('/orders/notes/{id}', [BackOrdersController::class, 'updateNotes']);

    Route::get('/sliders-list', [BackSlidersController::class, 'index']);
    Route::post('/slider-save', [BackSlidersController::class, 'store']);
    Route::delete('/slider-delete', [BackSlidersController::class, 'destroy']);

    Route::put('/slider-edit', [BackSlidersController::class, 'update']);

    Route::get('/dynamic-pages/{id}', [BackPagesController::class, 'edit']);
    Route::put('/dynamic-pages_update/{id}', [BackPagesController::class, 'update']);

    Route::get('/notice-board', [BackBasicsController::class, 'notice_edit']);
    Route::put('/notice-board', [BackBasicsController::class, 'notice_save']);

    Route::get('/dynamic-info/update', [BackBasicsController::class, 'edit']);
    Route::put('/dynamic-info/update', [BackBasicsController::class, 'update']);

    Route::get('/dynamic-delivery/update', [BackBasicsController::class, 'delivery_edit']);
    Route::put('/dynamic-delivery/update', [BackBasicsController::class, 'delivery_update']);

    Route::get('/dynamic-code/update', [BackBasicsController::class, 'code_edit']);
    Route::put('/dynamic-code/update', [BackBasicsController::class, 'code_update']);

    Route::get('/dynamic-changepass', [BackChangePassController::class, 'index']);
    Route::put('/dynamic-changepass', [BackChangePassController::class, 'update']);

    Route::get('/dynamic-mail/settings', [BackBasicsController::class, 'mail_edit']);
    Route::put('/dynamic-mail/update', [BackBasicsController::class, 'mail_update']);

    Route::get('/dynamic-sms_config', [BackBasicsController::class, 'sms_config']);
    Route::post('/dynamic-sms_update', [BackBasicsController::class, 'sms_update']);

    Route::get('/dynamic-payment_config', [BackBasicsController::class, 'payment_config']);
    Route::post('/dynamic-payment_update', [BackBasicsController::class, 'payment_update']);

    //Ajax request
    Route::get('/dynamic-ajax/change_product_sts/{id}', [AjaxController::class, 'change_product_sts']);

    //  Test controller
    Route::get('/dynamic-test', [TestController::class, 'test']);
});

// User
Route::get('/bkash/checkout-url/pay/{id}', [CheckoutURLController::class, 'pay'])->name('url-pay');
Route::post('/bkash/checkout-url/create', [CheckoutURLController::class, 'create'])->name('url-create');
Route::get('/bkash/checkout-url/callback', [CheckoutURLController::class, 'callback'])->name('url-callback');

// Admin
//Route::get('/bkash/checkout-url/refund', [CheckoutURLController::class, 'getRefund'])->name('url-get-refund');
//Route::post('/bkash/checkout-url/refund', [CheckoutURLController::class, 'refund'])->name('url-refund');

//Route::get('/bkash/checkout-url/refund-status', [CheckoutURLController::class, 'getRefundStatus'])->name('url-get-refund-status');
//Route::post('/bkash/checkout-url/refund-status', [CheckoutURLController::class, 'refundStatus'])->name('url-refund-status');

//aamarpay
Route::get('aamarpay/payment/{id}', [\App\Http\Controllers\paymentController::class, 'payment'])->name('payment');
//You need declear your success & fail route in "app\Middleware\VerifyCsrfToken.php"
Route::post('aamarpay/success', [\App\Http\Controllers\paymentController::class, 'success'])->name('success');
Route::post('aamarpay/fail', [\App\Http\Controllers\paymentController::class, 'fail'])->name('fail');
Route::get('aamarpay/cancel', [\App\Http\Controllers\paymentController::class, 'cancel'])->name('cancel');

//user role and permission

Route::middleware('auth')->group(function () {
    //role
   
    Route::get('/users', [App\Http\Controllers\user\UserController::class, 'index'])->name('users');
    Route::get('/delete-user/{user_id}', [App\Http\Controllers\user\UserController::class, 'deleteUser']);
    Route::post('/update-user', [App\Http\Controllers\user\UserController::class, 'updateUser'])->name('update-user');
    Route::post('/register-user', [App\Http\Controllers\user\UserController::class, 'register'])->name('register-user');
    Route::get('/user-role', [App\Http\Controllers\user\RoleAndPermission::class, 'roleIndex'])->name('user-role');
    Route::post('/create-role', [App\Http\Controllers\user\RoleAndPermission::class, 'storeRole'])->name('create_role');
    Route::post('/update-role', [App\Http\Controllers\user\RoleAndPermission::class, 'updateRole'])->name('updateRole');
    Route::post('/login', [App\Http\Controllers\user\UserController::class, 'login'])->name('login');

    //permission and role
    Route::get('permission', [App\Http\Controllers\user\RoleAndPermission::class, 'indexPermission'])->name('permission');
    Route::post('create-permission', [App\Http\Controllers\user\RoleAndPermission::class, 'storePermission'])->name('create-permission');
    Route::post('update-permission', [App\Http\Controllers\user\RoleAndPermission::class, 'updatePermission'])->name('update-permission');
    Route::post('sort-permission-data', [App\Http\Controllers\user\RoleAndPermission::class, 'sortPermissionData'])->name('sort-permission-data');
    Route::get('give-user-role', [App\Http\Controllers\user\RoleAndPermission::class, 'giveUserRole'])->name('give-user-role');
    Route::get('/give-user-permission', [App\Http\Controllers\user\RoleAndPermission::class, 'giveUserPermission'])->name('give-user-permission');
    Route::post('/store-user-permission', [App\Http\Controllers\user\RoleAndPermission::class, 'storeUserPermission'])->name('store-user-permission');
    Route::post('update-given-user-role', [App\Http\Controllers\user\RoleAndPermission::class, 'updateGivenUserRole'])->name('update-given-user-role');
    Route::post('check-user-permission', [App\Http\Controllers\user\RoleAndPermission::class, 'userGivePermissionCheck']);
    Route::post('user-excess-in-card', [App\Http\Controllers\user\RoleAndPermission::class, 'userExcessInCard']);
    Route::get('child-permission/{permission_id}', [App\Http\Controllers\user\RoleAndPermission::class, 'childPermission']);


    //seo page 
    Route::get('/add-seo-pages', [SeoPageController::class, 'addSeoPageContent'])->name('add-seo-pages');
    Route::get('/page-delete/{id}', [SeoPageController::class, 'deletePage']);
    Route::get('/pages-list', [SeoPageController::class, 'seoPagesIndex'])->name('pages-list');
    Route::post('/store-seo-content', [SeoPageController::class, 'storeSeoPageContent'])->name('store-seo-content');
    Route::get('/page-content-update/{seo_id}', [SeoPageController::class, 'pageContentUpdate'])->name('page-content-update');
    Route::post('/update-seo-content', [SeoPageController::class, 'updateSeoPageContent'])->name('update-seo-content');


    Route::post('ckeditor-upload', [CkEditorController::class, 'uploadCKeditorFile'])->name('ckeditor.upload');


});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
