<?php

use Illuminate\Support\Facades\Route;
use App\Helpers\UserSystemInfoHelper;

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

Route::get('/', function () {
    return redirect('/publisher');
});

// Route::get('/', function () {
//     return view('landing');
// });


Route::get('/beforelogin', function () {
    return view('beforelogin');
})->name('beforelogin');
Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('/home', function () {
        return redirect('/publisher');
    })->name('home');
    Route::get('/click', 'HomeController@Click')->name('click');
    Route::get('/links', 'HomeController@Smartlink');
    Route::get('/postback', 'HomeController@Postback')->name('postback');
    Route::get('/check', 'CheckController@check')->name('check');

    Route::get('api', 'HomeController@Api')->name('api ');
    Route::prefix('admin')->group(function () {
        Route::get('/login', 'Auth\AdminController@showLoginForm')->name('admin.login');
        Route::post('/login', 'Auth\AdminController@login')->name('admin.login.submit');

        Route::group(['middleware' => ['Admin']], function () {
            Route::get('/settings', 'Admin\AdminController@showsettings')->name('admin.settings');
            Route::get('/', 'Admin\AdminController@Showdashboard')->name('admin.dashboard');
            Route::get('/dashboard', 'Admin\AdminController@Showdashboard')->name('admin.dashboard');
            Route::post('/logout', 'Auth\AdminController@logout')->name('admin.logout');
            Route::post('/update-settings', 'Admin\AdminController@UpdateSettings')->name('admin.update-settings');
            Route::post('/change-details', 'Admin\AdminController@Updatedetails')->name('admin.change-details');
            Route::post('/change-password', 'Admin\AdminController@ChangePassword')->name('admin.change-password');
            Route::get('/show-site-categories', 'Admin\AdminController@ShowSiteCategory')->name('admin.show-site-categories');
            Route::get('/delete-site-categories', 'Admin\AdminController@DeleteSiteCategory')->name('admin.delete-site-categories');
            Route::post('/update-site-categories', 'Admin\AdminController@UpdateSiteCategory')->name('admin.update-site-categories');
            Route::post('/insert-site-categories', 'Admin\AdminController@InsertSiteCategory')->name('admin.insert-site-categories');
            Route::get('/manage-site-categories', 'Admin\AdminController@ManageSiteCategory')->name('admin.manage-site-categories');

            Route::get('/show-publishers', 'Admin\PublisherController@ShowPublisher')->name('admin.show-publishers');
            Route::get('/add-new-publisher', 'Admin\PublisherController@add_new_publisher')->name('admin.add-new-publisher');
            Route::get('/view-publishers/{id}', 'Admin\PublisherController@shiow_publisher_details')->name('admin.view-publishers');
            Route::get('/edit-view-publisher/{id}', 'Admin\PublisherController@ViewPublisher')->name('admin.edit-view-publisher');
            // Route::get('/edit-publishers', 'Admin\PublisherController@EditPublisher')->name('admin.edit-publisher');
            Route::get('/delete-publishers', 'Admin\PublisherController@DeletePublisher')->name('admin.delete-publishers');
            Route::post('/update-publishers', 'Admin\PublisherController@UpdatePublisher')->name('admin.update-publishers');
            Route::post('/insert-publishers', 'Admin\PublisherController@InsertPublisher')->name('admin.insert-publishers');
            Route::get('/manage-publishers', 'Admin\PublisherController@ManagePublisher')->name('admin.manage-publishers');
            Route::get('/ban-publishers', 'Admin\PublisherController@BanPublisher')->name('admin.ban-publishers');
            Route::get('/show-publisher-approval', 'Admin\PublisherController@ShowPublisherApproval')->name('admin.show-publisher-approval');
            Route::get('/publisher-approve-request/{id}', 'Admin\PublisherController@PublisherApproveRequest')->name('admin.publisher-approve-request');
            Route::get('/publisher-approval-request', 'Admin\PublisherController@PublisherApprovalRequest')->name('admin.publisher-approval-request');

            Route::get('/access-publisher/{email}', 'Admin\PublisherController@login')->name('admin.access-publisher');
            Route::get('/access-affliate/{email}', 'Admin\AffliateManagerController@login')->name('admin.access-affliate');


            Route::get('/show-domain', 'Admin\AdminController@ShowDomain')->name('admin.show-domain');

            Route::get('/show-smartlink-domain', 'Admin\AdminController@ShowSmartlinkDomain')->name('admin.show-smartlink-domain');

            Route::post('/send-message', 'Admin\AdminController@SendMessage');
            Route::get('/delete-domain', 'Admin\AdminController@DeleteDomain')->name('admin.delete-domain');
            Route::post('/update-domain', 'Admin\AdminController@UpdateDomain')->name('admin.update-domain');
            Route::post('/insert-domain', 'Admin\AdminController@InsertDomain')->name('admin.insert-domain');

            Route::get('/manage-domain', 'Admin\AdminController@ManageDomain')->name('admin.manage-domain');

            Route::get('/manage-payment', 'Admin\AdminController@Managepayment')->name('admin.manage-payment');
            Route::get('/show-payment', 'Admin\AdminController@ShowPayment')->name('admin.show-payment');
            Route::get('/get-edit-data', 'Admin\AdminController@get_edit_data')->name('admin.get-edit-data');
            Route::post('/insert-payment', 'Admin\AdminController@Insertpayment_method')->name('admin.insert-payment');
            Route::post('/update-payment', 'Admin\AdminController@update_payment')->name('admin.update-payment');
            Route::get('/delete-smartlink-domain', 'Admin\AdminController@DeleteSmartlinkDomain')->name('admin.delete-smartlink-domain');
            Route::get('/delete-payment', 'Admin\AdminController@deletepayment')->name('admin.delete-payment');
            Route::post('/update-smartlink-domain', 'Admin\AdminController@UpdateSmartlinkDomain')->name('admin.update-smartlink-domain');
            Route::post('/insert-smartlink-domain', 'Admin\AdminController@InsertSmartlinkDomain')->name('admin.insert-smartlink-domain');
            Route::get('/manage-smartlink-domain', 'Admin\AdminController@ManageSmartlinkDomain')->name('admin.manage-smartlink-domain');
            Route::get('/manage-smartlink-request', 'Admin\AdminController@ManageSmartlinkRequest')->name('admin.manage-smartlink-request');
            Route::get('/show-smartlink-request', 'Admin\AdminController@ShowSmartlinkRequest')->name('admin.show-smartlink-request');
            Route::get('/smartlink-approve-request', 'Admin\AdminController@SmartlinkApproveRequest')->name('admin.smartlink-approve-request');
            Route::get('/smartlink-reject-request', 'Admin\AdminController@SmartlinkRejectRequest')->name('admin.smartlink-reject-request');

            Route::get('/smartlink-clicks', 'Admin\AdminController@SmartlinkPendingProcess')->name('admin.smartlink-clicks');
            Route::get('/smartlink-leads', 'Admin\AdminController@SmartlinkApproveProcess')->name('admin.smartlink-leads');
            Route::get('/smartlink-waited-process', 'Admin\AdminController@SmartlinkWaitedProcess')->name('admin.smartlink-waited-process');
            Route::get('/rejected-smartlink-leads', 'Admin\AdminController@SmartlinkRejectedProcess')->name('admin.rejected-smartlink-leads');

            Route::get('/search-pending-smartlink-process', 'Admin\AdminController@SearchPendingSmartlinkProcess')->name('admin.search-pending-smartlink-process');
            Route::get('/search-rejected-smartlink-process', 'Admin\AdminController@SearchRejectedSmartlinkProcess')->name('admin.search-rejected-smartlink-process');
            Route::get('/search-approved-smartlink-process', 'Admin\AdminController@SearchApprovedSmartlinkProcess')->name('admin.search-approved-smartlink-process');
            Route::get('/search-wait-smartlink-process', 'Admin\AdminController@SearchWaitSmartlinkProcess')->name('admin.search-wait-smartlink-process');


            Route::get('/show-advertiser', 'Admin\AdvertiserController@ShowAdvertiser')->name('admin.show-advertiser');
            Route::get('/edit-advertiser', 'Admin\AdvertiserController@EditAdvertiser')->name('admin.edit-advertiser');
            Route::get('/delete-advertiser', 'Admin\AdvertiserController@DeleteAdvertiser')->name('admin.delete-advertiser');
            Route::post('/update-advertiser', 'Admin\AdvertiserController@UpdateAdvertiser')->name('admin.update-advertiser');
            Route::post('/insert-advertiser', 'Admin\AdvertiserController@InsertAdvertiser')->name('admin.insert-advertiser');
            Route::get('/manage-advertiser', 'Admin\AdvertiserController@ManageAdvertiser')->name('admin.manage-advertiser');

            Route::get('/show-categories', 'Admin\AdminController@ShowCategory')->name('admin.show-categories');
            Route::get('/edit-categories', 'Admin\AdminController@EditCategory')->name('admin.edit-categories');
            Route::get('/delete-categories', 'Admin\AdminController@DeleteCategory')->name('admin.delete-categories');
            Route::post('/update-categories', 'Admin\AdminController@UpdateCategory')->name('admin.update-categories');
            Route::post('/insert-categories', 'Admin\AdminController@InsertCategory')->name('admin.insert-categories');
            Route::get('/manage-categories', 'Admin\AdminController@ManageCategory')->name('admin.manage-categories');


            Route::get('/offer-details/{id?}', 'Admin\AdminController@offerDetails')->name('admin.offers');
            Route::post('/search_offer_dashboard', 'Admin\AdminController@search_offer_dashboard')->name('admin.search_offer_dashboard');

            Route::post('/insert-offer', 'Admin\AdminController@InsertOffer')->name('admin.insert-offer');
            Route::post('/update-offer', 'Admin\AdminController@UpdateOffer')->name('admin.update-offer');
            Route::get('/view-offer', 'Admin\AdminController@ViewOffer')->name('admin.view-offer');
            Route::match(['get', 'post'],'/view-offer-report', 'Admin\AdminController@ViewOfferReport')->name('admin.view-offer-report');
            Route::get('/edit_offer/{id}', 'Admin\AdminController@edit_offer')->name('admin.edit_offer');
            Route::get('/show-offers', 'Admin\AdminController@showOffer')->name('admin.show-offers');
            Route::get('/offer-delete/{id}', 'Admin\AdminController@offerDelete');
            Route::get('/search/offer', 'Admin\AdminController@searchOffers')->name('admin.search.offer');
            Route::get('/delete-offer', 'Admin\AdminController@DeleteOffer')->name('admin.delete-offer');
            Route::get('/add-offer', 'Admin\AdminController@AddOffer')->name('admin.add-offer');

            Route::get('/approval-request', 'Admin\AdminController@ApprovalRequest')->name('admin.approval-request');
            Route::get('/show-approval-request', 'Admin\AdminController@ShowApprovalRequest')->name('admin.show-approval-request');
            Route::get('/manage-postback', 'Admin\AdminController@ManagePostback')->name('admin.manage-postback');
            Route::get('/manage-postback-log', 'Admin\AdminController@ManagePostbackLog')->name('admin.manage-postback-log');
            Route::get('/show-postback-log', 'Admin\AdminController@showPostbackLog')->name('admin.show-postback-log');
            Route::get('/manage-postback-log-receive', 'Admin\AdminController@ManagePostbackLogRecieve')->name('admin.manage-postback-log-receive');
            Route::get('/show-postback-log-receive', 'Admin\AdminController@showPostbackLogRecieve')->name('admin.show-postback-log-receive');

            // Route::get('/smartlink-pending-process', 'Admin\OfferController@SmartlinkPendingProcess')->name('admin.smartlink-pending-process');
            // Route::get('/smartlink-approve-process', 'Admin\OfferController@SmartlinkApproveProcess')->name('admin.smartlink-approve-process');
            // Route::get('/smartlink-waited-process', 'Admin\OfferController@SmartlinkWaitedProcess')->name('admin.smartlink-waited-process');
            // Route::get('/smartlink-rejected-process', 'Admin\OfferController@SmartlinkRejectedProcess')->name('admin.smartlink-rejected-process');

            // Route::get('/search-pending-smartlink-process', 'Admin\OfferController@SearchPendingSmartlinkProcess')->name('admin.search-pending-smartlink-process');
            // Route::get('/search-rejected-smartlink-process', 'Admin\OfferController@SearchRejectedSmartlinkProcess')->name('admin.search-rejected-smartlink-process');
            // Route::get('/search-approved-smartlink-process', 'Admin\OfferController@SearchApprovedSmartlinkProcess')->name('admin.search-approved-smartlink-process');
            // Route::get('/search-wait-smartlink-process', 'Admin\OfferController@SearchWaitSmartlinkProcess')->name('admin.search-wait-smartlink-process');

            Route::get('/lead/search', 'Admin\AdminController@leadSearch')->name('admin.lead.search');
            Route::get('/clicks', 'Admin\AdminController@PendingOfferProcess')->name('admin.clicks');
            Route::get('/show-offer-process', 'Admin\AdminController@ShowOfferProcess')->name('admin.show-offer-process');
            Route::get('/leads', 'Admin\AdminController@ApproveOfferProcess')->name('admin.leads');
            Route::get('/reject-leads', 'Admin\AdminController@RejectOfferProcess')->name('admin.reject-leads');
            Route::get('/reject-offer-process1', 'Admin\AdminController@RejectOfferProcess1')->name('admin.reject-offer-process1');
            Route::get('/delete-offer-process', 'Admin\AdminController@deleteOfferProcess1')->name('admin.delete-offer-process');
            Route::get('/wait-offer-process', 'Admin\AdminController@WaitOfferProcess')->name('admin.wait-offer-process');
            Route::get('/approve-pending-offer-process', 'Admin\AdminController@ApprovePendingOfferProcess')->name('admin.approve-pending-offer-process');
            Route::get('/approve-reject-offer-process', 'Admin\AdminController@ApproveRejectOfferProcess')->name('admin.approve-reject-offer-process');
            Route::get('/approve-reject-offer-process1', 'Admin\AdminController@ApproveRejectOfferProcess1')->name('admin.approve-reject-offer-process1');
            Route::get('/approve-wait-offer-process', 'Admin\AdminController@ApproveWaitOfferProcess')->name('admin.approve-wait-offer-process');


            Route::get('/search-pending-offer-process', 'Admin\AdminController@SearchPendingOfferProcess')->name('admin.search-pending-offer-process');
            Route::get('/search-approve-offer-process', 'Admin\AdminController@SearchApproveOfferProcess')->name('admin.search-approve-offer-process');
            Route::get('/search-wait-offer-process', 'Admin\AdminController@SearchWaitOfferProcess')->name('admin.search-wait-offer-process');
            Route::get('/search-reject-offer-process', 'Admin\AdminController@SearchRejectOfferProcess')->name('admin.search-reject-offer-process');

            Route::get('/show-cashout', 'Admin\CashoutController@ShowCashout')->name('admin.show-cashout');;
            Route::get('/edit-cashout', 'Admin\CashoutController@EditCashout')->name('admin.edit-cashout');;
            Route::get('/delete-cashout', 'Admin\CashoutController@DeleteCashout')->name('admin.delete-cashout');;
            Route::post('/update-cashout', 'Admin\CashoutController@UpdateCashout')->name('admin.update-cashout');;
            Route::post('/insert-cashout', 'Admin\CashoutController@InsertCashout')->name('admin.insert-cashout');;
            Route::get('/manage-cashout', 'Admin\CashoutController@ManageCashout')->name('admin.manage-cashout');;
            Route::get('/search-cashout', 'Admin\CashoutController@SearchCashout')->name('admin.search-cashout');;
            Route::get('/InstantWithdraw', 'Admin\CashoutController@InstantWithdraw')->name('admin.InstantWithdraw');;

            Route::get('/show-cashout-affliate', 'Admin\CashoutController@ShowCashoutAffliate')->name('admin.show-cashout-affliate');;
            Route::get('/edit-cashout-affliate', 'Admin\CashoutController@EditCashoutAffliate')->name('admin.edit-cashout-affliate');;
            Route::get('/delete-cashout-affliate', 'Admin\CashoutController@DeleteCashoutAffliate')->name('admin.delete-cashout-affliate');;
            Route::post('/update-cashout-affliate', 'Admin\CashoutController@UpdateCashoutAffliate')->name('admin.update-cashout-affliate');;
            Route::post('/insert-cashout-affliate', 'Admin\CashoutController@InsertCashoutAffliate')->name('admin.insert-cashout-affliate');;
            Route::get('/manage-cashout-affliate', 'Admin\CashoutController@ManageCashoutAffliate')->name('admin.manage-cashout-affliate');;
            Route::get('/cron-payout-net-45', 'Admin\CashoutController@CronPayoutNet45')->name('admin.cron-payout-net-45');
            Route::get('/cron-payout-net-30', 'Admin\CashoutController@CronPayoutNet30')->name('admin.cron-payout-net-30');
            Route::get('/cron-payout-net-15', 'Admin\CashoutController@CronPayoutNet15')->name('admin.cron-payout-net-15');
            Route::get('/cron-payout-net-7', 'Admin\CashoutController@CronPayoutNet7')->name('admin.cron-payout-net-7');
            Route::get('/cron-payout-on-requested', 'Admin\CashoutController@CronPayoutOnRequested')->name('admin.cron-payout-on-requested');

            Route::get('/show-news', 'Admin\AdminController@ShowNews')->name('admin.show-news');
            Route::get('/edit-news', 'Admin\AdminController@EditNews')->name('admin.edit-news');
            Route::get('/delete-news', 'Admin\AdminController@DeleteNews')->name('admin.delete-news');
            Route::post('/update-news', 'Admin\AdminController@UpdateNews')->name('admin.update-news');
            Route::post('/insert-news', 'Admin\AdminController@InsertNews')->name('admin.insert-news');
            Route::get('/manage-news', 'Admin\AdminController@ManageNews')->name('admin.manage-news');

            Route::get('/show-ban-ip', 'Admin\AdminController@ShowBanIp')->name('admin.show-ban-ip');
            Route::get('/edit-ban-ip', 'Admin\AdminController@EditBanIp')->name('admin.edit-ban-ip');
            Route::get('/delete-ban-ip', 'Admin\AdminController@DeleteBanIp')->name('admin.delete-ban-ip');
            Route::post('/update-ban-ip', 'Admin\AdminController@UpdateBanIp')->name('admin.update-ban-ip');
            Route::post('/insert-ban-ip', 'Admin\AdminController@InsertBanIp')->name('admin.insert-ban-ip');
            Route::get('/manage-ban-ip', 'Admin\AdminController@ManageBanIp')->name('admin.manage-ban-ip');
            Route::get('/approve-request', 'Admin\AdminController@ApproveRequest')->name('admin.approve-request');
            Route::get('/reject-request', 'Admin\AdminController@RejectRequest')->name('admin.reject-request');

            Route::get('/show-affliatemanager', 'Admin\AffliateManagerController@ShowAffliateManager')->name('admin.show-affliatemanager');
            Route::get('/edit-affliatemanager', 'Admin\AffliateManagerController@EditAffliateManager')->name('admin.edit-affliatemanager');
            Route::get('/delete-affliatemanager', 'Admin\AffliateManagerController@DeleteAffliateManager')->name('admin.delete-affliatemanager');
            Route::post('/update-affliatemanager', 'Admin\AffliateManagerController@UpdateAffliateManager')->name('admin.update-affliatemanager');
            Route::post('/insert-affliatemanager', 'Admin\AffliateManagerController@InsertAffliateManager')->name('admin.insert-affliatemanager');
            Route::get('/manage-affliatemanager', 'Admin\AffliateManagerController@ManageAffliateManager')->name('admin.manage-affliatemanager');
            Route::post('/change-affliatemanager', 'Admin\AffliateManagerController@ChangePassword')->name('admin.change-affliatemanager');
            Route::get('/messages/{reply?}', 'Admin\AdminController@Messages')->name('admin.messages');
            Route::get('/show-message', 'Admin\AdminController@show_Messages')->name('admin.show-message');
            Route::post('/send-message', 'Admin\AdminController@SendMessage');
            Route::get('/view-message/{id}', 'Admin\AdminController@ViewMessage')->name('admin.view-message');
        });
    });
    Route::get('/publisher/verify/{token}', 'Auth\PublisherController@verifyUser')->name('publisher.verify');

    Route::prefix('publisher')->group(function () {
        Route::post('/varify_publisher/{{email}}', 'Auth\PublisherController@varify_publisher')->name('publisher.varify_publisher');
        Route::get('/login', 'Auth\PublisherController@showLoginForm')->name('publisher.login');
        Route::post('/login', 'Auth\PublisherController@login')->name('publisher.login.submit');
        Route::get('/register', 'Auth\PublisherController@showRegisterForm')->name('publisher.register');
        Route::get('/forgot_password', 'Auth\PublisherController@forgot_password')->name('publisher.forgot_password');
        Route::get('/rest-password-link/{token}', 'Auth\PublisherController@reset_password_link')->name('publisher.rest-password-link');
        Route::post('/reset-password', 'Auth\PublisherController@reset_password')->name('publisher.reset-password');

        Route::post('/forgot_password', 'Auth\PublisherController@forgot_password_email')->name('publisher.password.email');
        Route::post('/register', 'Auth\PublisherController@register')->name('publisher.register.submit');
        Route::post('/validate_account_information', 'Auth\PublisherController@account_information')->name('publisher.validate_account_information');
        Route::post('/validate_website_information', 'Auth\PublisherController@validate_website_information')->name('publisher.validate_website_information');
        Route::post('/validate_addistional_information', 'Auth\PublisherController@validate_addistional_information')->name('publisher.validate_addistional_information');
        Route::group(['middleware' => ['publisher']], function () {
            Route::get('/', 'Publisher\PublisherController@Showdashboard')->name('publisher');

            Route::get('/dashboard', 'Publisher\PublisherController@Showdashboard')->name('publisher.dashboard');

            Route::post('/logout', 'Auth\PublisherController@logout')->name('publisher.logout');

            Route::post('/filter-smartlink', 'Publisher\PublisherController@FilterSmartlink')->name('publisher.filter-smartlink');
            Route::post('/insert-smartlink', 'Publisher\PublisherController@InsertSmartlink')->name('publisher.insert-smartlink');
            Route::get('/smartlink', 'Publisher\PublisherController@Smartlink')->name('publisher.smartlink');
            Route::get('/delete-smartlink', 'Publisher\PublisherController@DeleteSmartlink')->name('publisher.delete-smartlink');
            Route::get('/show-smartlink', 'Publisher\PublisherController@ViewSmartlink')->name('publisher.show-smartlink');

            Route::get('/manage-site', 'Publisher\PublisherController@ManageSite')->name('publisher.manage-site');
            Route::get('/add-site', 'Publisher\PublisherController@AddSite')->name('publisher.add-site');
            Route::post('/insert-site', 'Publisher\PublisherController@InsertSite')->name('publisher.insert-site');
            Route::post('/update-site', 'Publisher\PublisherController@UpdateSite')->name('publisher.update-site');
            Route::get('/delete-site', 'Publisher\PublisherController@DeleteSite')->name('publisher.delete-site');

            Route::get('/reports', 'Publisher\PublisherController@Reports_get')->name('publisher.reports');
            Route::post('/reports', 'Publisher\PublisherController@Reports')->name('publisher.reports');
            Route::get('/daily-report', 'Publisher\PublisherController@DailyReport')->name('publisher.daily-report');
            Route::get('/report-by-date', 'Publisher\PublisherController@ReportByDate')->name('publisher.report-by-date');
            Route::get('/report-by-device', 'Publisher\PublisherController@ReportByDevice')->name('publisher.report-by-device');
            Route::get('/report-by-browser', 'Publisher\PublisherController@ReportByBrowser')->name('publisher.report-by-browser');
            Route::get('/report-by-country', 'Publisher\PublisherController@ReportByCountry')->name('publisher.report-by-country');
            Route::get('/report-by-sid', 'Publisher\PublisherController@ReportBySid')->name('publisher.report-by-sid');
            Route::get('/show-daily-report', 'Publisher\PublisherController@ShowDailyReport')->name('publisher.show-daily-report');
            Route::get('/payment-history', 'Publisher\PublisherController@PaymentHistory')->name('publisher.payment-history');
            Route::get('/account-information', 'Publisher\PublisherController@AccountInformation')->name('publisher.account-information');
            Route::post('/upload-image', 'Publisher\PublisherController@UploadImage')->name('publisher.upload-image');
            Route::get('/remove-payment', 'Publisher\PublisherController@RemoveAccount')->name('publisher.remove-payment');
            Route::post('/add-payment', 'Publisher\PublisherController@AddPayment')->name('publisher.add-payment');
            Route::post('/change-password', 'Publisher\PublisherController@ChangePassword')->name('publisher.change-password');
            Route::post('/update-settings', 'Publisher\PublisherController@UpdateSettings')->name('publisher.update-settings');
            Route::get('/support/{reply?}', 'Publisher\PublisherController@Support')->name('publisher.support');
            Route::get('/show-message', 'Publisher\PublisherController@show_Messages')->name('publisher.show-message');
            Route::post('/send-message', 'Publisher\PublisherController@SendMessage')->name('publisher.send-message');
            Route::get('/view-message/{id}', 'Publisher\PublisherController@ViewMessage')->name('publisher.view-message');
            Route::get('/login-history', 'Publisher\PublisherController@LoginHistory')->name('publisher.login-history');
            Route::get('/api', 'Publisher\PublisherController@OfferApi')->name('publisher.api');
            Route::post('/add-postback', 'Publisher\PublisherController@AddPostback')->name('publisher.add-postback');
            Route::get('/postback', 'Publisher\PublisherController@Postback')->name('publisher.postback');
            Route::get('/send-postback', 'Publisher\PublisherController@SendPostback')->name('publisher.send-postback');
            Route::get('/show-postback-log-sent', 'Publisher\PublisherController@show_post_back')->name('publisher.show-postback-log-sent');

            Route::get('/public-offers', 'Publisher\OfferController@PublicOffers')->name('publisher.public-offers');
            Route::get('/show-all-offers', 'Publisher\OfferController@show_all_offers_type')->name('publisher.show-all-offers');
            Route::get('/offer/search', 'Publisher\OfferController@offerSearch')->name('publisher.offer.search');
            Route::post('/requestApproval', 'Publisher\OfferController@requestApproval')->name('publisher.requestApproval');
            Route::get('/new_offer/search', 'Publisher\OfferController@newOfferSearch')->name('publisher.new_offer.search');
            Route::get('/top_offer/search', 'Publisher\OfferController@topOfferSearch')->name('publisher.top_offer.search');
            Route::get('/private-offers', 'Publisher\OfferController@PrivateOffers')->name('publisher.private-offers');
            Route::get('/private-offers2', 'Publisher\OfferController@PrivateOffers2')->name('publisher.private-offers2');
            Route::get('/offers-details/{id}', 'Publisher\OfferController@OfferDetails')->name('publisher.offers-details');
            Route::get('/special-offers', 'Publisher\OfferController@SpecialOffers')->name('publisher.special-offers');
            Route::get('/new-offers', 'Publisher\OfferController@NewOffers')->name('publisher.new-offers');
            Route::get('/top-offers', 'Publisher\OfferController@TopOffers')->name('publisher.top-offers');
            Route::get('/all-offers', 'Publisher\OfferController@AllOffers')->name('publisher.all-offers');
            Route::get('/chat', 'Publisher\PublisherController@chat')->name('publisher.chat');
            Route::post('/send_message_to_affliate', 'Publisher\PublisherController@send_message_to_affliate')->name('publisher.send_message_to_affliate');
            Route::get('/chat/{id}', 'Publisher\PublisherController@chat_with_user')->name('publisher.chat');
            Route::get('/my-offers', 'Publisher\OfferController@myOffers')->name('publisher.my-offers');
            Route::get('/search-offer', 'Publisher\OfferController@SearchOffer')->name('publisher.search-offer');
            Route::get('/search-private-offer', 'Publisher\OfferController@SearchPrivateOffer')->name('publisher.search-private-offer');
            Route::get('/search-new-offer', 'Publisher\OfferController@SearchNewOffer')->name('publisher.search-new-offer');
            Route::get('/search-top-offer', 'Publisher\OfferController@SearchTopOffer')->name('publisher.search-top-offer');
            Route::get('/search-special-offer', 'Publisher\OfferController@SearchSpecialOffer')->name('publisher.search-special-offer');
        });
    });


    Route::prefix('manager')->group(function () {

        Route::get('/login', 'Auth\AffliateController@showLoginForm')->name('manager.login');
        Route::post('/login', 'Auth\AffliateController@login')->name('manager.login.submit');
        Route::get('/register', 'Auth\AffliateController@showRegisterForm')->name('manager.register');
        Route::get('/register', 'Auth\AffliateController@showRegisterForm')->name('manager.register');
        Route::get('/forgot_password', 'Auth\AffliateController@forgot_password')->name('manager.forgot_password');
        Route::get('/rest-password-link/{token}', 'Auth\AffliateController@reset_password_link')->name('manager.rest-password-link');
        Route::post('/reset-password', 'Auth\AffliateController@reset_password')->name('manager.reset-password');
        Route::post('/forgot_password', 'Auth\AffliateController@forgot_password_email')->name('manager.password.email');
        Route::group(['middleware' => ['Affliate']], function () {
            Route::post('/logout', 'Auth\AffliateController@logout')->name('manager.logout');
            Route::get('/', 'Affiliate\AffliateController@index')->name('manager.dashboard');
            Route::get('/chat', 'Auth\AffliateController@chat')->name('manager.chat');
            Route::post('/update-settings', 'Affiliate\AffliateController@UpdateSettings')->name('manager.update-settings');
            Route::post('/change-password', 'Affiliate\AffliateController@ChangePassword')->name('manager.change-password');
            Route::get('/settings', 'Affiliate\AffliateController@Settings')->name('manager.settings');
            Route::post('/search_offer_dashboard', 'Affiliate\AffliateController@search_offer_dashboard')->name('manager.search_offer_dashboard');

            Route::get('/view-offer-detail', 'Affiliate\OfferController@viewOfferDetail')->name('manager.view-offer-detail');
            Route::get('/offer-detail/{id?}', 'Affiliate\OfferController@offerDetail')->name('manager.offer');
            Route::get('/offer-details/{id?}', 'Affiliate\OfferController@offerDetails')->name('manager.offers');
            Route::get('view-publisher-messages', 'Affiliate\AffliateController@ViewPublisherMessages')->name('manager.view-publisher-messages');
            Route::get('show-message', 'Affiliate\AffliateController@show_message')->name('manager.show-message');

            Route::get('/rejected-publisher', 'Affiliate\AffliateController@ShowRejectedPublisher')->name('manager.rejected-publisher');
            Route::get('/get-detail/{id}', 'Affiliate\AffliateController@GetDetail')->name('manager.get-detail');
            Route::get('/set-postback/{id}', 'Affiliate\AffliateController@SetPostback')->name('manager.set-postback');
            Route::get('/manage-publisher', 'Affiliate\AffliateController@ManagePublisher')->name('manager.manage-publisher');
            Route::get('/show-publisher', 'Affiliate\AffliateController@ShowPublisher')->name('manager.show-publisher');
            Route::get('/pending-publisher', 'Affiliate\AffliateController@ShowPendingPublisher')->name('manager.pending-publisher');
            Route::get('/ban-publishers', 'Affiliate\AffliateController@BanPublisher')->name('manager.ban-publishers');
            Route::get('/approve-publishers/{id}', 'Affiliate\AffliateController@ApprovePublisher')->name('manager.approve-publishers');
            Route::get('/reject-publishers/{id}', 'Affiliate\AffliateController@RejectPublisher')->name('manager.reject-publishers');
            Route::post('/update-publishers', 'Affiliate\AffliateController@UpdatePublisher')->name('manager.update-publishers');
            Route::post('/update-postback', 'Affiliate\AffliateController@UpdatePostback')->name('manager.update-postback');
            Route::get('/chat', 'Affiliate\AffliateController@chat')->name('manager.chat');
            Route::post('/send_message_to_publisher', 'Affiliate\AffliateController@send_message_to_publisher')->name('manager.send_message_to_publisher');
            Route::post('/search_publisher_chat', 'Affiliate\AffliateController@search_publisher_chat')->name('manager.search_publisher_chat');
            Route::get('/chat/{id}', 'Affiliate\AffliateController@chat_with_user')->name('manager.chat');

            Route::get('/pending-smartlinks', 'Affiliate\AffliateController@PendingSmartlink')->name('manager.pending-smartlinks');
            Route::get('/approve-smartlinks', 'Affiliate\AffliateController@ApproveSmartlink')->name('manager.approve-smartlinks');
            Route::get('/rejected-smartlinks', 'Affiliate\AffliateController@RejectedSmartlink')->name('manager.rejected-smartlinks');

            Route::get('/show-smartlink-request', 'Affiliate\AffliateController@ShowSmartlinkRequest')->name('manager.show-smartlink-request');
            // Route::get('/show-approve-smartlink-request', 'Affiliate\AffliateController@ShowSmartlinkApproveRequest')->name('manager.show-smartlink-request');
            // Route::get('/show-reject-smartlink-request', 'Affiliate\AffliateController@ShowSmartlinkRejectedRequest')->name('manager.show-smartlink-request');
            Route::get('/smartlink-approve-request', 'Affiliate\AffliateController@SmartlinkApproveRequest')->name('manager.smartlink-approve-request');
            Route::get('/smartlink-reject-request', 'Affiliate\AffliateController@SmartlinkRejectRequest')->name('manager.smartlink-reject-request');;

            Route::get('/approve-request/{id}', 'Affiliate\OfferController@ApproveRequest')->name('manager.approve-request');
            Route::get('/reject-request/{id}', 'Affiliate\OfferController@RejectRequest')->name('manager.reject-request');

            Route::get('/approval-request', 'Affiliate\OfferController@ApprovalRequest')->name('manager.approval-request');
            Route::get('/approve-approval-request', 'Affiliate\OfferController@ApproveApprovalRequest')->name('manager.approve-approval-request');
            Route::get('/reject-approval-request', 'Affiliate\OfferController@rejectApprovalRequest')->name('manager.reject-approval-request');
            Route::get('/show-approval-request', 'Affiliate\OfferController@ShowApprovalRequest')->name('manager.show-approval-request');
            Route::get('/show-approval-request-approved', 'Affiliate\OfferController@ShowApprovalRequestApproved')->name('manager.show-approval-request-approved');
            Route::get('/delete-approval-request', 'Affiliate\OfferController@DeleteApprovalRequest')->name('manager.delete-approval-request');

            Route::get('/support/{reply?}', 'Affiliate\AffliateController@Support')->name('manager.support');
            Route::post('/send-message', 'Affiliate\AffliateController@SendMessage')->name('manager.send-message');
            Route::get('/view-message/{id}', 'Affiliate\AffliateController@ViewMessage')->name('manager.view-message');

            Route::get('/pending-offer-process', 'Affiliate\OfferController@PendingOfferProcess')->name('manager.pending-offer-process');
            Route::get('/approve-offer-process', 'Affiliate\OfferController@ApproveOfferProcess')->name('manager.approve-offer-process');
            Route::get('/reject-offer-process', 'Affiliate\OfferController@RejectOfferProcess')->name('manager.reject-offer-process');
            Route::get('/reject-offer-process1', 'Affiliate\OfferController@RejectOfferProcess1')->name('manager.reject-offer-process1');
            Route::get('/wait-offer-process', 'Affiliate\OfferController@WaitOfferProcess')->name('manager.wait-offer-process');
            Route::get('/approve-pending-offer-process', 'Affiliate\OfferController@ApprovePendingOfferProcess')->name('manager.approve-pending-offer-process');
            Route::get('/approve-reject-offer-process', 'Affiliate\OfferController@ApproveRejectOfferProcess')->name('manager.approve-reject-offer-process');
            Route::get('/approve-reject-offer-process1', 'Affiliate\OfferController@ApproveRejectOfferProcess1')->name('manager.approve-reject-offer-process1');
            Route::get('/approve-wait-offer-process', 'Affiliate\OfferController@ApproveWaitOfferProcess')->name('manager.approve-wait-offer-process');
            Route::post('/send-mail', 'Affiliate\AffliateController@SendMail')->name('manager.send-mail');;
            Route::get('/get-mail-data', 'Affiliate\AffliateController@get_post_mail')->name('manager.get-mail-data');;
            Route::get('/view-mail', 'Affiliate\AffliateController@ViewMail')->name('manager.view-mail');;
            Route::get('/mail-room', 'Affiliate\AffliateController@MailRoom')->name('manager.mail-room');;
            Route::get('/show-mail', 'Affiliate\AffliateController@show_mail')->name('manager.show-mail');;

            Route::get('/search-pending-offer-process', 'Affiliate\OfferController@SearchPendingOfferProcess')->name('manager.search-pending-offer-process');
            Route::get('/search-approve-offer-process', 'Affiliate\OfferController@SearchApproveOfferProcess')->name('manager.search-approve-offer-process');
            Route::get('/search-wait-offer-process', 'Affiliate\OfferController@SearchWaitOfferProcess')->name('manager.search-wait-offer-process');
            Route::get('/search-reject-offer-process', 'Affiliate\OfferController@SearchRejectOfferProcess')->name('manager.search-reject-offer-process');

            Route::get('/generate-link', 'Affiliate\AffliateController@GenerateLink')->name('manager.generate-link');;
            Route::get('/payment', 'Affiliate\AffliateController@Payment')->name('manager.payment');;
        });
    });
});

Auth::routes();


