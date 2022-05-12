<?php

use App\Models\NotificationTicketMessage;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('verify', [\App\Http\Controllers\VerifyController::class, 'verify'])->name('verify');
Route::get('payment-cancel', 'Web\PaymentController@failed')->name('payment_cancel');
Route::get('payment-success', 'Web\PaymentController@success')->name('payment_success');

Route::get('/updates', function () {
    return redirect('/user/notifications/updates');
});

Route::middleware(['auth', 'verify'])->group(function() {

    //mark
    Route::get('report/{report}/mark/report', [\App\Http\Controllers\Web\DownloadController::class, 'mark'])->name('web_user_mark_report');
    Route::post('report/report-mark/{report}', [\App\Http\Controllers\Web\DownloadController::class, 'report_mark'])->name('mark_report');

    // downloads
    Route::get('report/{report}/download/report', [\App\Http\Controllers\Web\DownloadController::class, 'report'])->name('web_user_download_report');
    Route::get('report/{report}/download/consumer-notice', [\App\Http\Controllers\Web\DownloadController::class, 'consumer_notice'])->name('web_user_download_consumer_notice');

    Route::get('report/{report}/download/noise-test', [\App\Http\Controllers\Web\DownloadController::class, 'noise_test'])->name('web_user_noise_test');
    Route::get('report/{report}/download/sticker', [\App\Http\Controllers\Web\DownloadController::class, 'sticker'])->name('web_user_identification_label');

    Route::get('child-copy/{childCopy}/download', [\App\Http\Controllers\Web\DownloadController::class, 'child_copy']);
    Route::post('child-copy/{childCopy}/download_adrs', [\App\Http\Controllers\Web\DownloadController::class, 'download_adrs']);

    Route::post('discussion/create', [\App\Http\Controllers\Web\TicketController::class, 'store']);

    Route::get('di/{token}', [\App\Http\Controllers\Web\TicketController::class, 'view']);

});

Route::get('catalog/models/{make}', 'CommonController@get_models');

Route::middleware(['auth', 'client', 'verify'])->group(function() {

    Route::get('/', function () {
        if (isset(auth()->user()->is_admin)) {
            return redirect((auth()->user()->is_admin ? 'admin/' : '') . 'dashboard');
        } else {
            return redirect()->name('web_dashboard');
        }
    });

    Route::get('dashboard', [\App\Http\Controllers\Web\HomeController::class, 'dashboard'])->name('web_dashboard');

    //  model reports
    Route::get('reports', [\App\Http\Controllers\Web\HomeController::class, 'reports'])->name('web_reports');

    // user
    Route::get('user/profile', [\App\Http\Controllers\Web\UserController::class, 'profile'])->name('web_user_profile');
    Route::get('user/reports', [\App\Http\Controllers\Web\UserController::class, 'reports'])->name('web_user_reports');
    Route::get('user/orders', [\App\Http\Controllers\Web\UserController::class, 'orders'])->name('web_user_orders');
    Route::get('user/notifications/{tab}', [\App\Http\Controllers\Web\NotificationController::class, 'index'])->name('web_user_notifications');

    Route::get('/user/notifications/approval/{approval}', [\App\Http\Controllers\Web\ApprovalController::class, 'show']);
    Route::patch('/user/notifications/approval/{approval}', [\App\Http\Controllers\Web\ApprovalController::class, 'update']);
    Route::delete('/user/notifications/approval/{approval}/delete', [\App\Http\Controllers\Web\ApprovalController::class, 'delete']);

    Route::patch('user/{user}/update', [\App\Http\Controllers\Web\UserController::class, 'update_profile']);
    Route::patch('user/{user}/update-password', [\App\Http\Controllers\Web\UserController::class, 'update_password']);

    Route::get('discussions', [\App\Http\Controllers\Web\TicketController::class, 'index'])->name('web_user_discussions');
    Route::get('discussion/{ticket}', [\App\Http\Controllers\Web\TicketController::class, 'show']);
    Route::post('discussion/{ticket}', [\App\Http\Controllers\Web\TicketController::class, 'reply']);
    Route::post('discussion/{ticket}/toggle', [\App\Http\Controllers\Web\TicketController::class, 'toggle_read']);
    Route::delete('discussion/{ticket}/delete', [\App\Http\Controllers\Web\TicketController::class, 'delete']);

    /* Route::get('user/ticket/{ticket}', [\App\Http\Controllers\Web\TicketController::class, 'show']);
    Route::post('user/message/{ticket}', [\App\Http\Controllers\Web\TicketController::class, 'message']);*/

    // cart
    Route::get('cart', [\App\Http\Controllers\Web\CartController::class, 'index'])->name('cart');
    Route::get('refresh-mini-cart', [\App\Http\Controllers\Web\CartController::class, 'refresh_cart_mini']);
    Route::post('cart/update/{child}', [\App\Http\Controllers\Web\CartController::class, 'update']);
    Route::post('cart/delete/{child}', [\App\Http\Controllers\Web\CartController::class, 'delete']);

    // pay
    Route::post('checkout', [\App\Http\Controllers\Web\OrderController::class, 'checkout']);
    Route::get('order/{order}/pay', [\App\Http\Controllers\Web\OrderController::class, 'pay']);
});

Route::prefix('admin')->middleware(['auth', 'admin', 'verify'])->group(function() {

    Route::get('dashboard', [\App\Http\Controllers\Admin\HomeController::class, 'dashboard'])->name('admin_dashboard');

    Route::get('master-copy/generate', 'Admin\MasterCopyController@generate');
    Route::get('master-copy/{masterCopy}/version-changes', 'Admin\MasterCopyController@version_changes');
    Route::resource('master-copy', 'Admin\MasterCopyController');

    Route::get('child-copy/adr/{adr}/edit', [\App\Http\Controllers\Admin\ChildCopyAdrController::class, 'edit']);
    Route::patch('child-copy/adr/{adr}', [\App\Http\Controllers\Admin\ChildCopyAdrController::class, 'update']);
    Route::delete('child-copy/adr/{adr}/delete', [\App\Http\Controllers\Admin\ChildCopyAdrController::class, 'delete']);

    Route::get('child-copy/{childCopy}/version-changes', 'Admin\ChildCopyController@version_changes');
    Route::get('child-copy/{childCopy}/edit-column', [\App\Http\Controllers\Admin\ChildCopyController::class, 'edit_column']);
    Route::get('child-copy/{childCopy}/edit-index', [\App\Http\Controllers\Admin\ChildCopyController::class, 'edit_index']);
    Route::patch('child-copy/{childCopy}/update-column', [\App\Http\Controllers\Admin\ChildCopyController::class, 'update_column']);
    Route::patch('child-copy/{childCopy}/update-index', [\App\Http\Controllers\Admin\ChildCopyController::class, 'update_index']);
    Route::resource('child-copy', 'Admin\ChildCopyController');

    Route::post('adr/images', [\App\Http\Controllers\Admin\AdrController::class, 'cache_images']);
    Route::delete('adr/{adr}/attachment', [\App\Http\Controllers\Admin\AdrController::class, 'delete_attachment']);
    Route::resource('adr', 'Admin\AdrController');

    Route::resource('child-copy/{childCopy}/mods', 'Admin\ChildCopyModsController');

    // clients
    Route::get('/clients', [\App\Http\Controllers\Admin\ClientController::class, 'index']);
    Route::get('/client/{user}', [\App\Http\Controllers\Admin\ClientController::class, 'show']);
    Route::patch('/client/{user}/update', [\App\Http\Controllers\Admin\ClientController::class, 'update']);
    Route::post('/client/{user}/reset-password', [\App\Http\Controllers\Admin\ClientController::class, 'reset_password']);

    // sales
    Route::get('income', [\App\Http\Controllers\Admin\SalesController::class, 'income']);
    Route::get('sales', [\App\Http\Controllers\Admin\SalesController::class, 'index']);
    Route::get('sales/{user}', [\App\Http\Controllers\Admin\SalesController::class, 'show']);

    Route::get('discussions', [\App\Http\Controllers\Admin\NotificationController::class, 'index']);
    Route::post('discussions/bulk-assign', [\App\Http\Controllers\Admin\NotificationController::class, 'bulk_assign']);
    Route::get('discussions/{tab}', [\App\Http\Controllers\Admin\NotificationController::class, 'index']);
    Route::get('discussion/{ticket}', [\App\Http\Controllers\Admin\NotificationController::class, 'show']);
    Route::post('discussion/{ticket}', [\App\Http\Controllers\Admin\NotificationController::class, 'reply']);
    Route::post('discussion/{ticket}/toggle-read', [\App\Http\Controllers\Admin\NotificationController::class, 'toggle_read']);
    Route::post('discussion/{ticket}/toggle-assign', [\App\Http\Controllers\Admin\NotificationController::class, 'toggle_assign']);

    Route::get('ticket/{ticket}', [\App\Http\Controllers\Admin\NotificationController::class, 'show']);
    Route::post('message/{ticket}', [\App\Http\Controllers\Admin\NotificationController::class, 'message']);

    Route::get('approval', [\App\Http\Controllers\Admin\ApprovalController::class, 'index']);
    Route::get('approval/{approval}', [\App\Http\Controllers\Admin\ApprovalController::class, 'show']);
    Route::patch('approval/{approval}', [\App\Http\Controllers\Admin\ApprovalController::class, 'update']);

    route::resource('settings', 'Admin\IndexController');
    Route::post('update/status', [\App\Http\Controllers\Admin\IndexController::class, 'update_status']);

    // Admins
    Route::resource('manager', 'Admin\ManagerController');
    Route::post('/user/{user}/update-status', [\App\Http\Controllers\Admin\UserController::class, 'update_status']);

    Route::get('report/{report}/noise-test', [\App\Http\Controllers\Admin\NoiseTestController::class, 'edit']);
    Route::patch('report/{report}/noise-test', [\App\Http\Controllers\Admin\NoiseTestController::class, 'update']);

    // Settings
    Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'edit'])->name('admin_settings.edit');
    Route::patch('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update']);

    // Coupons
    Route::resource('coupon', 'Admin\CouponController');

    // catalog
    Route::get('catalog/{category}/{module}', [\App\Http\Controllers\Admin\CatalogController::class, 'index'])->name('catalog.index');
    Route::post('catalog/{category}/{module}', [\App\Http\Controllers\Admin\CatalogController::class, 'store'])->name('catalog.store');
    Route::patch('catalog/{category}/{module}/{id}', [\App\Http\Controllers\Admin\CatalogController::class, 'update'])->name('catalog.update');
    Route::delete('catalog/{category}/{module}/{id}', [\App\Http\Controllers\Admin\CatalogController::class, 'destroy'])->name('catalog.delete');

    // Image Editor
    Route::post('image-editor', [\App\Http\Controllers\Admin\ImageEditorController::class, 'store'])->name('image-editor.store');

});

require __DIR__.'/auth.php';
