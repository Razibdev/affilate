<?php

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

Route::get('/', function () {
        return view('home');
});

Route::get('/beforelogin', function () {
    return view('beforelogin');
})->name('beforelogin');
Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/click', 'HomeController@Click')->name('click');
    Route::get('/links', 'HomeController@Smartlink');
    Route::get('/postback', 'HomeController@Postback');
    Route::get('/check', 'CheckController@check')->name('check');

    Route::prefix('admin')->group(function () {
        Route::get('/login', 'Auth\AdminController@showLoginForm')->name('admin.login');
        Route::get('/settings', 'Admin\AdminController@showsettings')->name('admin.settings');
        Route::post('/login', 'Auth\AdminController@login')->name('admin.login.submit');
        Route::get('/dashboard', 'Admin\AdminController@Showdashboard')->name('admin.dashboard');
        Route::post('/logout', 'Auth\AdminController@logout')->name('admin.logout');
        Route::post('/update-settings', 'Admin\AdminController@UpdateSettings')->name('admin.update-settings');
        Route::get('/show-site-categories', 'Admin\AdminController@ShowSiteCategory')->name('admin.show-site-categories');
        Route::get('/delete-site-categories', 'Admin\AdminController@DeleteSiteCategory')->name('admin.delete-site-categories');
        Route::post('/update-site-categories', 'Admin\AdminController@UpdateSiteCategory')->name('admin.update-site-categories');
        Route::post('/insert-site-categories', 'Admin\AdminController@InsertSiteCategory')->name('admin.insert-site-categories');
        Route::get('/manage-site-categories', 'Admin\AdminController@ManageSiteCategory')->name('admin.manage-site-categories');

        Route::get('/show-publishers', 'Admin\PublisherController@ShowPublisher')->name('admin.show-publishers');
        Route::get('/add-new-publisher', 'Admin\PublisherController@add_new_publisher')->name('admin.add-new-publisher');
        Route::get('/view-publishers/{id}', 'Admin\PublisherController@shiow_publisher_details')->name('admin.view-publishers');
        Route::get('/edit-view-publisher/{id}', 'Admin\PublisherController@ViewPublisher')->name('admin.edit-view-publisher');
         Route::get('/edit-publishers', 'Admin\PublisherController@EditPublisher')->name('admin.edit-publisher');
        Route::get('/delete-publishers', 'Admin\PublisherController@DeletePublisher')->name('admin.delete-publishers');
        Route::post('/update-publishers', 'Admin\PublisherController@UpdatePublisher')->name('admin.update-publishers');
        Route::post('/insert-publishers', 'Admin\PublisherController@InsertPublisher')->name('admin.insert-publishers');
        Route::get('/manage-publishers', 'Admin\PublisherController@ManagePublisher')->name('admin.manage-publishers');
        Route::get('/ban-publishers', 'Admin\PublisherController@BanPublisher')->name('admin.ban-publishers');
        Route::get('/show-publisher-approval','Admin\PublisherController@ShowPublisherApproval')->name('admin.show-publisher-approval');
        Route::get('/publisher-approve-request/{id}','Admin\PublisherController@PublisherApproveRequest')->name('admin.publisher-approve-request');
        Route::get('/publisher-approval-request','Admin\PublisherController@PublisherApprovalRequest')->name('admin.publisher-approval-request');

        Route::get('/access-publisher/{email}', 'Admin\PublisherController@login');


        Route::get('/show-domain', 'Admin\AdminController@ShowDomain')->name('admin.show-domain');

        Route::get('/show-smartlink-domain', 'Admin\AdminController@ShowSmartlinkDomain')->name('admin.show-smartlink-domain');

        Route::post('/send-message', 'Admin\AdminController@SendMessage');
        Route::get('/delete-domain', 'Admin\AdminController@DeleteDomain')->name('admin.delete-domain');
        Route::post('/update-domain', 'Admin\AdminController@UpdateDomain')->name('admin.update-domain');
        Route::post('/insert-domain', 'Admin\AdminController@InsertDomain')->name('admin.insert-domain');
        Route::get('/manage-domain', 'Admin\AdminController@ManageDomain')->name('admin.manage-domain');

        Route::get('/delete-smartlink-domain', 'Admin\AdminController@DeleteSmartlinkDomain')->name('admin.delete-smartlink-domain');
        Route::post('/update-smartlink-domain', 'Admin\AdminController@UpdateSmartlinkDomain')->name('admin.update-smartlink-domain');
        Route::post('/insert-smartlink-domain', 'Admin\AdminController@InsertSmartlinkDomain')->name('admin.insert-smartlink-domain');
        Route::get('/manage-smartlink-domain', 'Admin\AdminController@ManageSmartlinkDomain')->name('admin.manage-smartlink-domain');
        Route::get('/manage-smartlink-request', 'Admin\AdminController@ManageSmartlinkRequest')->name('admin.manage-smartlink-request');
        Route::get('/show-smartlink-request', 'Admin\AdminController@ShowSmartlinkRequest')->name('admin.show-smartlink-request');
        Route::get('/smartlink-approve-request', 'Admin\AdminController@SmartlinkApproveRequest')->name('admin.smartlink-approve-request');
        Route::get('/smartlink-reject-request', 'Admin\AdminController@SmartlinkRejectRequest')->name('admin.smartlink-reject-request');

        Route::get('/smartlink-pending-process', 'Admin\AdminController@SmartlinkPendingProcess')->name('admin.smartlink-pending-process');
        Route::get('/smartlink-approve-process', 'Admin\AdminController@SmartlinkApproveProcess')->name('admin.smartlink-approve-process');
        Route::get('/smartlink-waited-process', 'Admin\AdminController@SmartlinkWaitedProcess')->name('admin.smartlink-waited-process');
        Route::get('/smartlink-rejected-process', 'Admin\AdminController@SmartlinkRejectedProcess')->name('admin.smartlink-rejected-process');

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

        Route::post('/insert-offer', 'Admin\AdminController@InsertOffer')->name('admin.insert-offer');
        Route::post('/update-offer', 'Admin\AdminController@UpdateOffer')->name('admin.update-offer');
        Route::get('/view-offer', 'Admin\AdminController@ViewOffer')->name('admin.view-offer');
        Route::get('/offer-section-get', 'Admin\AdminController@ViewOfferSingle');
        Route::get('/edit_offer/{id}', 'Admin\AdminController@edit_offer')->name('admin.edit_offer');
        Route::get('/show-offers', 'Admin\AdminController@showOffer')->name('admin.show-offers');
        Route::get('/offer-delete/{id}', 'Admin\AdminController@offerDelete');
        Route::get('/search/offer', 'Admin\AdminController@searchOffers')->name('admin.search.offer');
        Route::get('/delete-offer', 'Admin\AdminController@DeleteOffer')->name('admin.delete-offer');
        Route::get('/add-offer', 'Admin\AdminController@AddOffer')->name('admin.add-offer');

        Route::get('/approval-request', 'Admin\AdminController@ApprovalRequest')->name('admin.approval-request');
        Route::get('/manage-postback', 'Admin\AdminController@ManagePostback')->name('admin.manage-postback');
        Route::get('/manage-postback-log', 'Admin\AdminController@ManagePostbackLog')->name('admin.manage-postback-log');
        Route::get('/manage-postback-log-receive', 'Admin\AdminController@ManagePostbackLogRecieve')->name('admin.manage-postback-log-receive');

        // Route::get('/smartlink-pending-process', 'Admin\OfferController@SmartlinkPendingProcess')->name('admin.smartlink-pending-process');
        // Route::get('/smartlink-approve-process', 'Admin\OfferController@SmartlinkApproveProcess')->name('admin.smartlink-approve-process');
        // Route::get('/smartlink-waited-process', 'Admin\OfferController@SmartlinkWaitedProcess')->name('admin.smartlink-waited-process');
        // Route::get('/smartlink-rejected-process', 'Admin\OfferController@SmartlinkRejectedProcess')->name('admin.smartlink-rejected-process');

        // Route::get('/search-pending-smartlink-process', 'Admin\OfferController@SearchPendingSmartlinkProcess')->name('admin.search-pending-smartlink-process');
        // Route::get('/search-rejected-smartlink-process', 'Admin\OfferController@SearchRejectedSmartlinkProcess')->name('admin.search-rejected-smartlink-process');
        // Route::get('/search-approved-smartlink-process', 'Admin\OfferController@SearchApprovedSmartlinkProcess')->name('admin.search-approved-smartlink-process');
        // Route::get('/search-wait-smartlink-process', 'Admin\OfferController@SearchWaitSmartlinkProcess')->name('admin.search-wait-smartlink-process');



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


        Route::get('/show-affliatemanager', 'Admin\AffliateManagerController@ShowAffliateManager')->name('admin.show-affliatemanager');
        Route::get('/edit-affliatemanager', 'Admin\AffliateManagerController@EditAffliateManager')->name('admin.edit-affliatemanager');
        Route::get('/delete-affliatemanager', 'Admin\AffliateManagerController@DeleteAffliateManager')->name('admin.delete-affliatemanager');
        Route::post('/update-affliatemanager', 'Admin\AffliateManagerController@UpdateAffliateManager')->name('admin.update-affliatemanager');
        Route::post('/insert-affliatemanager', 'Admin\AffliateManagerController@InsertAffliateManager')->name('admin.insert-affliatemanager');
        Route::get('/manage-affliatemanager', 'Admin\AffliateManagerController@ManageAffliateManager')->name('admin.manage-affliatemanager');

        Route::get('/messages/{reply?}', 'Admin\AdminController@Messages')->name('admin.messages');
        Route::get('/show-message', 'Admin\AdminController@show_Messages')->name('admin.show-message');
        Route::post('/send-message', 'Admin\AdminController@SendMessage');
        Route::get('/view-message/{id}', 'Admin\AdminController@ViewMessage')->name('admin.view-message');
    });
    Route::get('/publisher/verify/{token}', 'Auth\PublisherController@verifyUser')->name('publisher.verify');
    Route::prefix('publisher')->group(function () {
        Route::get('/login', 'Auth\PublisherController@showLoginForm')->name('publisher.login');
        Route::post('/login', 'Auth\PublisherController@login')->name('publisher.login.submit');
        Route::get('/register', 'Auth\PublisherController@showRegisterForm')->name('publisher.register');
        Route::get('/dashboard', 'Auth\PublisherController@Showdashboard')->name('publisher.dashboard');
        Route::get('/forgot_password', 'Auth\PublisherController@forgot_password')->name('publisher.forgot_password');
        Route::post('/forgot_password', 'Auth\PublisherController@forgot_password_email')->name('publisher.password.email');
        Route::post('/register', 'Auth\PublisherController@register')->name('publisher.register.submit');
        Route::post('/validate_account_information', 'Auth\PublisherController@account_information')->name('publisher.validate_account_information');
        Route::post('/validate_website_information', 'Auth\PublisherController@validate_website_information')->name('publisher.validate_website_information');
        Route::post('/validate_addistional_information', 'Auth\PublisherController@validate_addistional_information')->name('publisher.validate_addistional_information');
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

        Route::get('/public-offers', 'Publisher\OfferController@PublicOffers')->name('publisher.public-offers');
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
        Route::get('/chat', 'Publisher\OfferController@chat')->name('publisher.chat');
        Route::get('/my-offers', 'Publisher\OfferController@myOffers')->name('publisher.my-offers');
        Route::get('/search-offer', 'Publisher\OfferController@SearchOffer')->name('publisher.search-offer');
        Route::get('/search-private-offer', 'Publisher\OfferController@SearchPrivateOffer')->name('publisher.search-private-offer');
        Route::get('/search-new-offer', 'Publisher\OfferController@SearchNewOffer')->name('publisher.search-new-offer');
        Route::get('/search-top-offer', 'Publisher\OfferController@SearchTopOffer')->name('publisher.search-top-offer');
        Route::get('/search-special-offer', 'Publisher\OfferController@SearchSpecialOffer')->name('publisher.search-special-offer');
    });
    Route::prefix('affliate')->group(function () {
            Route::post('/logout', 'Auth\AffliateController@logout')->name('affliate.logout');
            Route::get('/', 'Affiliate\AffliateController@index')->name('affliate.dashboard');
            Route::get('/login', 'Auth\AffliateController@showLoginForm')->name('affliate.login');
            Route::post('/login', 'Auth\AffliateController@login')->name('affliate.login.submit');
            Route::get('/register', 'Auth\AffliateController@showRegisterForm')->name('affliate.register');
            Route::post('/register', 'Auth\AffliateController@register')->name('affliate.register.submit');
        Route::post('/update-settings', 'Affiliate\AffliateController@UpdateSettings')->name('affliate.update-settings');
        Route::post('/change-password', 'Affiliate\AffliateController@ChangePassword')->name('affliate.change-password');
        Route::get('/settings', 'Affiliate\AffliateController@Settings')->name('affliate.settings');

        Route::get('/view-offer-detail', 'Affiliate\OfferController@viewOfferDetail')->name('affliate.view-offer-detail');
        Route::get('/offer-detail/{id?}', 'Affiliate\OfferController@offerDetail')->name('affliate.offer');
        Route::get('view-publisher-messages', 'Affiliate\AffliateController@ViewPublisherMessages')->name('affliate.view-publisher-messages');
        Route::get('show-message', 'Affiliate\AffliateController@show_message')->name('affliate.show-message');

        Route::get('/rejected-publisher', 'Affiliate\AffliateController@ShowRejectedPublisher')->name('affliate.rejected-publisher');
        Route::get('/get-detail/{id}', 'Affiliate\AffliateController@GetDetail')->name('affliate.get-detail');
        Route::get('/set-postback/{id}', 'Affiliate\AffliateController@SetPostback')->name('affliate.set-postback');
        Route::get('/manage-publisher', 'Affiliate\AffliateController@ManagePublisher')->name('affliate.manage-publisher');
        Route::get('/show-publisher', 'Affiliate\AffliateController@ShowPublisher')->name('affliate.show-publisher');
        Route::get('/pending-publisher', 'Affiliate\AffliateController@ShowPendingPublisher')->name('affliate.pending-publisher');
        Route::get('/ban-publishers', 'Affiliate\AffliateController@BanPublisher')->name('affliate.ban-publishers');
        Route::get('/approve-publishers/{id}', 'Affiliate\AffliateController@ApprovePublisher')->name('affliate.approve-publishers');
        Route::get('/reject-publishers/{id}', 'Affiliate\AffliateController@RejectPublisher')->name('affliate.reject-publishers');
        Route::post('/update-publishers', 'Affiliate\AffliateController@UpdatePublisher')->name('affliate.update-publishers');
        Route::post('/update-postback', 'Affiliate\AffliateController@UpdatePostback')->name('affliate.update-postback');

        Route::get('/pending-smartlinks', 'Affiliate\AffliateController@PendingSmartlink')->name('affliate.pending-smartlinks');
        Route::get('/approve-smartlinks', 'Affiliate\AffliateController@ApproveSmartlink')->name('affliate.approve-smartlinks');
        Route::get('/rejected-smartlinks', 'Affiliate\AffliateController@RejectedSmartlink')->name('affliate.rejected-smartlinks');

        Route::get('/show-smartlink-request', 'Affiliate\AffliateController@ShowSmartlinkRequest')->name('affliate.show-smartlink-request');
        // Route::get('/show-approve-smartlink-request', 'Affiliate\AffliateController@ShowSmartlinkApproveRequest')->name('affliate.show-smartlink-request');
        // Route::get('/show-reject-smartlink-request', 'Affiliate\AffliateController@ShowSmartlinkRejectedRequest')->name('affliate.show-smartlink-request');
        Route::get('/smartlink-approve-request', 'Affiliate\AffliateController@SmartlinkApproveRequest')->name('affliate.smartlink-approve-request');
        Route::get('/smartlink-reject-request', 'Affiliate\AffliateController@SmartlinkRejectRequest')->name('affliate.smartlink-reject-request');;

        Route::get('/approve-request/{id}', 'Affiliate\OfferController@ApproveRequest')->name('affliate.approve-request');
        Route::get('/reject-request/{id}', 'Affiliate\OfferController@RejectRequest')->name('affliate.reject-request');

        Route::get('/approval-request', 'Affiliate\OfferController@ApprovalRequest')->name('affliate.approval-request');
        Route::get('/approve-approval-request', 'Affiliate\OfferController@ApproveApprovalRequest')->name('affliate.approve-approval-request');
        Route::get('/show-approval-request', 'Affiliate\OfferController@ShowApprovalRequest')->name('affliate.show-approval-request');
        Route::get('/show-approval-request-approved', 'Affiliate\OfferController@ShowApprovalRequestApproved')->name('affliate.show-approval-request-approved');
        Route::get('/delete-approval-request', 'Affiliate\OfferController@DeleteApprovalRequest')->name('affliate.delete-approval-request');

        Route::get('/support/{reply?}', 'Affiliate\AffliateController@Support')->name('affliate.support');
        Route::post('/send-message', 'Affiliate\AffliateController@SendMessage')->name('affliate.send-message');
        Route::get('/view-message/{id}', 'Affiliate\AffliateController@ViewMessage')->name('affliate.view-message');

        Route::get('/pending-offer-process', 'Users\Affliate\OfferController@PendingOfferProcess')->name('affliate.pending-offer-process');
        Route::get('/approve-offer-process', 'Users\Affliate\OfferController@ApproveOfferProcess')->name('affliate.approve-offer-process');
        Route::get('/reject-offer-process', 'Users\Affliate\OfferController@RejectOfferProcess')->name('affliate.reject-offer-process');
        Route::get('/reject-offer-process1', 'Users\Affliate\OfferController@RejectOfferProcess1')->name('affliate.reject-offer-process1');
        Route::get('/wait-offer-process', 'Users\Affliate\OfferController@WaitOfferProcess')->name('affliate.wait-offer-process');
        Route::get('/approve-pending-offer-process', 'Users\Affliate\OfferController@ApprovePendingOfferProcess')->name('affliate.approve-pending-offer-process');
        Route::get('/approve-reject-offer-process', 'Users\Affliate\OfferController@ApproveRejectOfferProcess')->name('affliate.approve-reject-offer-process');
        Route::get('/approve-reject-offer-process1', 'Users\Affliate\OfferController@ApproveRejectOfferProcess1')->name('affliate.approve-reject-offer-process1');
        Route::get('/approve-wait-offer-process', 'Users\Affliate\OfferController@ApproveWaitOfferProcess')->name('affliate.approve-wait-offer-process');
        Route::post('/send-mail', 'Affiliate\AffliateController@SendMail')->name('affliate.send-mail');;
        Route::get('/view-mail', 'Affiliate\AffliateController@ViewMail')->name('affliate.view-mail');;
        Route::get('/mail-room', 'Affiliate\AffliateController@MailRoom')->name('affliate.mail-room');;
        Route::get('/show-mail', 'Affiliate\AffliateController@show_mail')->name('affliate.show-mail');;

        Route::get('/search-pending-offer-process', 'Users\Affliate\OfferController@SearchPendingOfferProcess')->name('affliate.search-pending-offer-process');
        Route::get('/search-approve-offer-process', 'Users\Affliate\OfferController@SearchApproveOfferProcess')->name('affliate.search-approve-offer-process');
        Route::get('/search-wait-offer-process', 'Users\Affliate\OfferController@SearchWaitOfferProcess')->name('affliate.search-wait-offer-process');
        Route::get('/search-reject-offer-process', 'Users\Affliate\OfferController@SearchRejectOfferProcess')->name('affliate.search-reject-offer-process');

        Route::get('/generate-link', 'Affiliate\AffliateController@GenerateLink')->name('affliate.generate-link');;
        Route::get('/payment', 'Affiliate\AffliateController@Payment')->name('affliate.payment');;
    });
});

Auth::routes();


