<?php
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

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
    return redirect('/ar');
})->name('welcome.general');


Route::group(['prefix' => '{locale}'], function () {
    Route::pattern('locale', 'en|ar');
    Route::get('/', function ($locale) {
        App::setLocale($locale);
        $slides = App\Slider::all();
        $services = App\Services::all();
        $di = App\Price::where('service_code','DI')->first();
        $die = App\Price::where('service_code','DIE')->first();
        $do = App\Price::where('service_code','DO')->first();
        $inPackages = App\Package::where('type','inside')->get();
        $outPackages = App\Package::where('type','outside')->get();
        $customers = \App\Customer::orderBy('created_at','desc')->take(20)->get();
        return view('welcome',compact('slides','di','die','do','inPackages','outPackages','services','customers'));
    })->name('welcome');
    Route::get('/who-we-are', function ($locale) {
        App::setLocale($locale);
        return view('about');
    })->name('about');
    Route::get('/why-faststar', function ($locale) {
        App::setLocale($locale);
        return view('why');
    })->name('why');
    Route::get('/services', function ($locale) {
        App::setLocale($locale);
        $services = App\Services::all();
        return view('services',compact('services'));
    })->name('services');

    Route::get('/offers-and-prices', function ($locale) {
        App::setLocale($locale);
        $di = App\Price::where('service_code','DI')->first();
        $die = App\Price::where('service_code','DIE')->first();
        $do = App\Price::where('service_code','DO')->first();
        $inPackages = App\Package::where('type','inside')->get();
        $outPackages = App\Package::where('type','outside')->get();
        return view('prices',compact('di','die','do','inPackages','outPackages'));
    })->name('prices');

    Route::get('/our-customers', function ($locale) {
        App::setLocale($locale);
        $customers = \App\Customer::orderBy('created_at','desc')->paginate(50);
        return view('customers', compact('customers'));
    })->name('customers');

    Route::get('/contact', function ($locale) {
        App::setLocale($locale);
        return view('contact');
    })->name('contact');
    Route::get('/privacy-policy', function ($locale) {
        App::setLocale($locale);
        return view('privacy');
    })->name('privacy');

    Route::post('/search-order',[
        'uses'=>'AppController@searchOrder',
        'as'=>'search-order',
    ]);

    Route::post('/send-email',[
        'uses'=>'AppController@postContact',
        'as'=>'send-email'
    ]);
});


/*Client-Area-Routes*/

Route::group(['prefix' => '{locale}'], function () {
    Route::pattern('locale', 'en|ar');
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
});


// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::get('register/verify/{token}', [
    'uses' => 'Auth\RegisterController@verify'
]);

Route::get('register/send-verification-mail', 'Auth\RegisterController@verificationMailForm')->name('user-verification');
Route::post('register/send-verification-mail/', 'Auth\RegisterController@sendVerificationMail')->name('user-verification');

Route::get('/home', function () {
    return redirect('/ar/client-area');
})->name('home')->middleware('auth');

Route::group(['middleware'=>'auth','prefix' => '{locale}/client-area'], function () {

    Route::pattern('locale', 'en|ar');

    Route::get('/', [
        'uses'=>'Client\ClientController@index',
        'as'=>'client'
    ]);

    Route::get('/create-account', [
        'uses'=>'Client\ClientController@getCreateAccount',
        'as'=>'client.create-account'
    ]);
    Route::post('/create-account', [
        'uses'=>'Client\ClientController@postCreateAccount',
        'as'=>'client.create-account'
    ]);

    Route::get('/edit-account', [
        'uses'=>'Client\ClientController@getEditAccount',
        'as'=>'client.edit-account'
    ]);
    Route::post('/edit-account', [
        'uses'=>'Client\ClientController@postEditAccount',
        'as'=>'client.edit-account'
    ]);

    Route::get('/create-store', [
        'uses'=>'Client\ClientController@getCreateStore',
        'as'=>'client.create-store',
        'middleware'=>'account-creation',
    ]);
    Route::post('/create-store', [
            'uses'=>'Client\ClientController@postCreateStore',
            'as'=>'client.create-store',
        'middleware'=>'account-creation',
    ]);


    Route::get('/edit-store/{id}', [
            'uses'=>'Client\ClientController@getEditStore',
            'as'=>'client.edit-store'
    ]);

    Route::post('/edit-store/{id}', [
        'uses'=>'Client\ClientController@postEditStore',
        'as'=>'client.edit-store'
    ]);


    Route::get('/delete-store/{id}', [
            'uses'=>'Client\ClientController@deleteStore',
            'as'=>'client.delete-store'
    ]);


    Route::get('/other-services/new-order', [
        'uses'=>'Client\OtherController@getOtherNewOrder',
        'as'=>'client.other-new-order'
    ]);

    Route::post('/other-services/new-order', [
        'uses'=>'Client\OtherController@postOtherNewOrder',
        'as'=>'client.other-new-order'
    ]);

    Route::get('/other-services/edit-order/{ref_number}', [
        'uses'=>'Client\OtherController@getOtherEditOrder',
        'as'=>'client.other-edit-order'
    ]);

    Route::post('/other-services/edit-order/{id}', [
        'uses'=>'Client\OtherController@postOtherEditOrder',
        'as'=>'client.other-edit-order'
    ]);

    ////

    Route::get('/new-delivery-order', [
        'uses'=>'Client\ClientController@getNewOrder',
        'as'=>'client.new-order'
    ]);

    Route::post('/new-delivery-order', [
        'uses'=>'Client\ClientController@postNewOrder',
        'as'=>'client.new-order'
    ]);

    Route::get('/edit-delivery-order/{id}', [
        'uses'=>'Client\ClientController@getEditOrder',
        'as'=>'client.edit-order'
    ]);

     Route::post('/edit-delivery-order/{id}', [
        'uses'=>'Client\ClientController@postEditOrder',
        'as'=>'client.edit-order'
    ]);

/*
    Route::get('/new-delivery-order/{ref_number}', [
        'uses'=>'Client\ClientController@getNewOrder',
        'as'=>'client.new-order'
    ]);

    Route::post('/new-delivery-order/{ref_number}', [
        'uses'=>'Client\ClientController@postNewOrder',
        'as'=>'client.new-order'
    ]);

    Route::get('/edit-delivery-order-o/{ref_number}', [
        'uses'=>'Client\ClientController@getEditOrder',
        'as'=>'client.edit-order'
    ]);

    Route::post('/edit-delivery-order-o/{ref_number}', [
        'uses'=>'Client\ClientController@postEditOrder',
        'as'=>'client.edit-order'
    ]);

*/
    Route::get('/select-delivery-type/{ref}', [
        'uses'=>'Client\ClientController@getSelectDelivery',
        'as'=>'client.select-delivery-type'
    ]);

    Route::post('/select-delivery-type/{ref}', [
        'uses'=>'Client\ClientController@postSelectDelivery',
        'as'=>'client.select-delivery-type'
    ]);

    Route::get('/submit-delivery-order/{ref}', [
        'uses'=>'Client\ClientController@getSubmitOrder',
        'as'=>'client.submit-order'
    ]);

    Route::post('/submit-delivery-order/{id}', [
        'uses'=>'Client\ClientController@postSubmitOrder',
        'as'=>'client.submit-order'
    ]);


    Route::get('/package-request', [
        'uses'=>'Client\ClientController@getPackageRequest',
        'as'=>'client.package',
        'middleware'=>'account-creation',

    ]);

    Route::post('/package-request', [
        'uses'=>'Client\ClientController@postPackageRequest',
        'as'=>'client.package',
        'middleware'=>'account-creation',
    ]);



    Route::get('/orders', [
        'uses'=>'Client\ClientController@orders',
        'as'=>'client.orders'
    ]);

    Route::get('/package-request/invoice/{ref_number}', [
        'uses'=>'Client\ClientController@getPackageInvoice',
        'as'=>'client.package.invoice'
    ]);

    /*Ticket-System-Routes*/
    Route::get('/support/new-ticket',[
        'uses'=>'Client\TicketController@getNewTicket',
        'as'=>'client.new-ticket'
    ]);

    Route::post('/support/new-ticket',[
        'uses'=>'Client\TicketController@postNewTicket',
        'as'=>'client.new-ticket'
    ]);

    Route::get('/support/my-tickets',[
        'uses'=>'Client\TicketController@myTickets',
        'as'=>'client.my-tickets'
    ]);

    Route::get('/support/ticket-{id}',[
        'uses'=>'Client\TicketController@ticketShow',
        'as'=>'client.ticket-show'
    ]);

    Route::post('/support/reply-ticket',[
        'uses'=>'Client\TicketController@postReplyTicket',
        'as'=>'client.reply-ticket'
    ]);

    Route::get('reports/orders-by-date',[
        'uses'=>'Client\ReportController@getOrdersByDate',
        'as'=>'client.reports.orders-by-date',
    ]);

    Route::post('reports/orders-by-date',[
        'uses'=>'Client\ReportController@postOrdersByDate',
        'as'=>'client.reports.orders-by-date',
    ]);

    /*By-Satus*/
    Route::get('reports/orders-by-status',[
        'uses'=>'Client\ReportController@getOrdersByStatus',
        'as'=>'client.reports.orders-by-status',
    ]);
    Route::post('reports/orders-by-status',[
        'uses'=>'Client\ReportController@postOrdersByStatus',
        'as'=>'client.reports.orders-by-status',
    ]);
});

/*Agent-Area-Routes*/
Route::get('/agent/login','Auth\Agent\LoginController@showLoginForm')->name('agent.login');
Route::post('/agent/login','Auth\Agent\LoginController@login')->name('agent.login.submit');
Route::get('/agent', function () {
    return redirect('/agent/en');
})->name('agent')->middleware('auth:agent');

Route::group(['middleware'=>'auth:agent','prefix' => '/agent'], function () {

    Route::pattern('locale', 'en|ar');
    Route::get('/{locale}', 'Agent\AgentController@index')->name('agent.dashboard');

    Route::get('/get-new-orders/', 'Agent\AgentController@getNewOrders')->name('agent.new-orders');

    Route::get('/get-order/{ref_number}/{locale}',[

        'uses'=>'Agent\AgentController@getOrder',
        'as'=>'agent.get-order',
    ]);
    Route::get('/order/{ref_number}/{locale}',[

        'uses'=>'Agent\AgentController@order',
        'as'=>'agent.order',
    ]);

    Route::post('/order/{ref_number}/{locale}',[

        'uses'=>'Agent\AgentController@changeStatus',
        'as'=>'agent.change-status',
    ]);

    Route::get('/pending-orders/{locale}', [

        'uses'=>'Agent\AgentController@pendingOrders',
        'as'=>'agent.pending-orders',
    ]);

    Route::get('/coming-orders/{locale}', [

        'uses'=>'Agent\AgentController@comingOrders',
        'as'=>'agent.coming-orders',
    ]);

    Route::get('/completed-orders/{locale}',[
        'uses'=>'Agent\AgentController@completedOrders',
        'as'=>'agent.completed-orders',
    ]);


    Route::get('/cash-list/{locale}', [
        'uses'=>'Agent\AgentController@cashList',
        'as'=>'agent.cash-list',
    ]);

    Route::get('/pick-report/{locale}', [
        'uses'=>'Agent\AgentController@pickReport',
        'as'=>'agent.pick-report',
    ]);
    Route::get('/delivery-report/{locale}', [
        'uses'=>'Agent\AgentController@deliveryReport',
        'as'=>'agent.delivery-report',
    ]);

    Route::get('/send-report/{locale}', function ($locale) {
        App::setLocale($locale);
        return view('agent.send-report');
    })->name('agent.send-report');

});

/*Admin-Area-Routes*/
Route::get('/admin/login','Auth\Admin\LoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login','Auth\Admin\LoginController@login')->name('admin.login.submit');
Route::get('/admin', function () {
        return redirect('/admin/en');
})->name('admin')->middleware('auth:admin');

Route::get('admin/password/reset', 'Auth\Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin/password/email', 'Auth\Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin/password/reset/{token}', 'Auth\Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('admin/password/reset', 'Auth\Admin\ResetPasswordController@reset');

Route::group(['middleware' => 'roles','roles'=>['superadmin'],'prefix' => '/admin'], function () {

    Route::pattern('locale', 'en|ar');


    /*Admins*/

    Route::post('/get-accountant-amount/{id}/{email}/{locale}',[
        'uses'=>'Admin\AdminController@takeAccountantAmount',
        'as'=>'admin.take-accountant-amount',
    ]);
    /*CMS*/
    Route::get('/cms/packages/{locale}',[
        'uses'=>'Admin\CmsController@packages',
        'as'=>'admin.cms.packages',
    ]);

    Route::post('/cms/edit-package/{id}/{locale}',[
        'uses'=>'Admin\CmsController@editPackage',
        'as'=>'admin.cms.edit-package',
    ]);

    Route::get('/cms/prices/{locale}',[
        'uses'=>'Admin\CmsController@prices',
        'as'=>'admin.cms.prices',
    ]);

    Route::post('/cms/edit-price/{id}/{locale}',[
        'uses'=>'Admin\CmsController@editPrice',
        'as'=>'admin.cms.edit-price',
    ]);

    Route::get('/cms/packings/{locale}',[
        'uses'=>'Admin\CmsController@packings',
        'as'=>'admin.cms.packings',
    ]);

    Route::post('/cms/edit-packing/{id}/{locale}',[
    'uses'=>'Admin\CmsController@editPacking',
        'as'=>'admin.cms.edit-packing',
    ]);
    Route::post('/cms/new-packing/{locale}',[
    'uses'=>'Admin\CmsController@newPacking',
        'as'=>'admin.cms.new-packing',
    ]);
    Route::get('/cms/delete-packing/{id}/{locale}',[
        'uses'=>'Admin\CmsController@deletePacking',
        'as'=>'admin.cms.delete-packing',
    ]);

    Route::get('/cms/status/{locale}',[
        'uses'=>'Admin\CmsController@status',
        'as'=>'admin.cms.status',
    ]);

    Route::post('/cms/edit-status/{id}/{locale}',[
    'uses'=>'Admin\CmsController@editStatus',
        'as'=>'admin.cms.edit-status',
    ]);
    Route::post('/cms/new-status/{locale}',[
    'uses'=>'Admin\CmsController@newStatus',
        'as'=>'admin.cms.new-status',
    ]);
    Route::get('/cms/delete-status/{id}/{locale}',[
        'uses'=>'Admin\CmsController@deleteStatus',
        'as'=>'admin.cms.delete-status',
    ]);


    Route::get('/cms/neighbors/{locale}',[
        'uses'=>'Admin\CmsController@neighbors',
        'as'=>'admin.cms.neighbors',
    ]);

    Route::post('/cms/new-neighbor/{locale}',[
        'uses'=>'Admin\CmsController@newNeighbor',
        'as'=>'admin.cms.new-neighbor',
    ]);

    Route::get('/cms/edit-neighbor/{id}/{locale}',[
        'uses'=>'Admin\CmsController@getEditNeighbor',
        'as'=>'admin.cms.edit-neighbor',
    ]);
     Route::post('/cms/edit-neighbor/{id}/{locale}',[
        'uses'=>'Admin\CmsController@postEditNeighbor',
        'as'=>'admin.cms.edit-neighbor',
    ]);

    Route::get('/cms/delete-neighbor/{id}/{locale}',[
        'uses'=>'Admin\CmsController@deleteNeighbor',
        'as'=>'admin.cms.delete-neighbor',
    ]);

    Route::get('/cms/regions/{locale}',[
        'uses'=>'Admin\CmsController@regions',
        'as'=>'admin.cms.regions',
    ]);
    Route::post('/cms/new-region/{locale}',[
        'uses'=>'Admin\CmsController@newRegion',
        'as'=>'admin.cms.new-region',
    ]);

    Route::get('/cms/edit-region/{id}/{locale}',[
        'uses'=>'Admin\CmsController@getEditRegion',
        'as'=>'admin.cms.edit-region',
    ]);

    Route::post('/cms/edit-region/{id}/{locale}',[
        'uses'=>'Admin\CmsController@postEditRegion',
        'as'=>'admin.cms.edit-region',
    ]);

    Route::get('/cms/customers/{locale}',[
        'uses'=>'Admin\CmsController@customers',
        'as'=>'admin.cms.customers',
    ]);

    Route::post('/cms/edit-customer/{id}/{locale}',[
        'uses'=>'Admin\CmsController@editCustomer',
        'as'=>'admin.cms.edit-customer',
    ]);
    Route::post('/cms/new-customer/{locale}',[
        'uses'=>'Admin\CmsController@newCustomer',
        'as'=>'admin.cms.new-customer',
    ]);
    Route::get('/cms/delete-customer/{id}/{locale}',[
        'uses'=>'Admin\CmsController@deleteCustomer',
        'as'=>'admin.cms.delete-customer',
    ]);



    Route::get('/theme/slider/{locale}',[
        'uses'=>'Admin\ThemeController@slider',
        'as'=>'admin.theme.slider',
    ]);

    Route::post('/theme/new-slide/{locale}',[
        'uses'=>'Admin\ThemeController@newSlide',
        'as'=>'admin.theme.new-slide',
    ]);

    Route::get('/theme/edit-slide/{id}/{locale}',[
        'uses'=>'Admin\ThemeController@editSlide',
        'as'=>'admin.theme.edit-slide',
    ]);

    Route::post('/theme/edit-slide/{id}/{locale}',[
        'uses'=>'Admin\ThemeController@updateSlide',
        'as'=>'admin.theme.edit-slide',
    ]);

    Route::get('/theme/delete-slide/{id}/{locale}',[
        'uses'=>'Admin\ThemeController@deleteSlide',
        'as'=>'admin.theme.delete-slide',
    ]);

  Route::get('/theme/services/{locale}',[
        'uses'=>'Admin\ThemeController@services',
        'as'=>'admin.theme.services',
    ]);

    Route::post('/theme/new-service/{locale}',[
        'uses'=>'Admin\ThemeController@newService',
        'as'=>'admin.theme.new-service',
    ]);

    Route::get('/theme/edit-service/{id}/{locale}',[
        'uses'=>'Admin\ThemeController@editService',
        'as'=>'admin.theme.edit-service',
    ]);

    Route::post('/theme/edit-service/{id}/{locale}',[
        'uses'=>'Admin\ThemeController@updateService',
        'as'=>'admin.theme.edit-service',
    ]);
    Route::get('/theme/delete-service/{id}/{locale}',[
        'uses'=>'Admin\ThemeController@deleteService',
        'as'=>'admin.theme.delete-service',
    ]);

    Route::get('/theme/general-settings/{locale}',[
        'uses'=>'Admin\ThemeController@generalSettings',
        'as'=>'admin.theme.general-settings',
    ]);

    Route::post('/theme/edit-settings/{locale}',[
        'uses'=>'Admin\ThemeController@editSettings',
        'as'=>'admin.theme.edit-settings',
    ]);

});

Route::group(['middleware' => 'roles','roles'=>['superadmin','admin'],'prefix' => '/admin'], function () {

    Route::pattern('locale', 'en|ar');

    /*Transfer-client-Amount*/
    Route::post('/transfer-client-amount/{id}/{email}/{locale}',[
        'uses'=>'Admin\AdminController@transferClientAmount',
        'as'=>'admin.transfer-client-amount',
    ]);

    /*Admins*/

    Route::get('/new-admin/{locale}',[
        'uses'=>'Admin\AdminController@getNewAdmin',
        'as'=>'admin.new-admin',
    ]);

    Route::post('/new-admin/{locale}',[
        'uses'=>'Admin\AdminController@postNewAdmin',
        'as'=>'admin.new-admin',
    ]);

    Route::get('edit-admin/{id}/{locale}',[
        'uses'=>'Admin\AdminController@getEditAdmin',
        'as'=>'admin.edit-admin',
    ]);

    Route::post('/edit-admin/{id}/{locale}',[
        'uses'=>'Admin\AdminController@postEditAdmin',
        'as'=>'admin.edit-admin',
    ]);

    Route::get('/our-admins/{locale}',[
        'uses'=>'Admin\AdminController@admins',
        'as'=>'admin.admins',
    ]);

    Route::get('/our-admins/{id}/{email}/{locale}',[
        'uses'=>'Admin\AdminController@admin',
        'as'=>'admin.admin',
    ]);

    Route::post('/assign-city/{id}/{email}/{locale}',[
        'uses'=>'Admin\AdminController@assignWorkCity',
        'as'=>'admin.admins.assign-work-city',
    ]);

    Route::post('/get-supervisor-amount/{id}/{email}/{locale}',[
        'uses'=>'Admin\AdminController@takeSupervisorAmount',
        'as'=>'admin.take-supervisor-amount',
    ]);
    /*Package-requests*/
    Route::get('/admin/package-requests/{locale}',[
        'uses'=>'Admin\PackageController@packageRequests',
        'as'=>'admin.package-requests',
    ]);

    Route::post('/admin/active-package-request/{user_id}/{id}/{ref}/{locale}',[
        'uses'=>'Admin\PackageController@activePackageRequest',
        'as'=>'admin.active-package-request',
    ]);
    Route::get('/new-tickets/{locale}',[
        'uses'=>'Admin\TicketController@newTickets',
        'as'=>'admin.new-tickets',
    ]);

    Route::get('/pending-tickets/{locale}',[
        'uses'=>'Admin\TicketController@pendingTickets',
        'as'=>'admin.pending-tickets',
    ]);

    Route::get('/closed-tickets/{locale}',[
        'uses'=>'Admin\TicketController@closedTickets',
        'as'=>'admin.closed-tickets',
    ]);

    Route::get('/ticket/{id}-{ticket_id}{locale}',[
        'uses'=>'Admin\TicketController@ticket',
        'as'=>'admin.ticket',
    ]);

    Route::post('/reply-ticket{locale}',[
        'uses'=>'Admin\TicketController@postReplyTicket',
        'as'=>'admin.reply-ticket',
    ]);

});

Route::group(['middleware' => 'roles','roles'=>['superadmin','admin','subadmin'],'prefix' => '/admin'], function () {

    Route::pattern('locale', 'en|ar');

    Route::get('/{locale}', 'Admin\AdminController@index')->name('admin.dashboard');

    Route::get('/all-orders/{locale}',[
        'uses'=>'Admin\AdminController@allOrders',
        'as'=>'admin.all-orders'
    ]);

    Route::get('/order/{id}/{locale}',[
        'uses'=>'Admin\AdminController@order',
        'as'=>'admin.order'
    ]);

    Route::post('/order/{id}/{locale}',[
        'uses'=>'Admin\AdminController@changeStatus',
        'as'=>'admin.change-status',
    ]);

    Route::get('/pending-orders/{locale}', [
        'uses'=>'Admin\AdminController@pendingOrders',
        'as'=>'admin.pending-orders',
    ]);

    Route::get('/completed-orders/{locale}', [
        'uses'=>'Admin\AdminController@completedOrders',
        'as'=>'admin.completed-orders',
    ]);

    Route::get('/edit-order/{id}/{locale}', [
        'uses'=>'Admin\AdminController@getEditOrder',
        'as'=>'admin.edit-order',
    ]);
    Route::post('/edit-order/{id}/{locale}', [
        'uses'=>'Admin\AdminController@postEditOrder',
        'as'=>'admin.edit-order',
    ]);


    Route::get('/select-delivery-type/{ref}/{locale}', [
        'uses'=>'Client\ClientController@getSelectDelivery',
        'as'=>'admin.select-delivery-type'
    ]);

    Route::post('/select-delivery-type/{ref}/{locale}', [
        'uses'=>'Client\ClientController@postSelectDelivery',
        'as'=>'admin.select-delivery-type'
    ]);

    Route::get('/submit-order/{id}/{locale}', [
        'uses'=>'Admin\AdminController@getSubmitOrder',
        'as'=>'admin.submit-order',
    ]);

    Route::post('/submit-order/{id}/{locale}', [
        'uses'=>'Admin\AdminController@postSubmitOrder',
        'as'=>'admin.submit-order',
    ]);

    /*Other-Orders*/
    Route::get('/pending-other-orders/{locale}', [
        'uses'=>'Admin\AdminController@pendingOtherOrders',
        'as'=>'admin.pending-other-orders',
    ]);

    Route::get('/completed-other-orders/{locale}', [
        'uses'=>'Admin\AdminController@completedOtherOrders',
        'as'=>'admin.completed-other-orders',
    ]);

    Route::get('/edit-other-order/{id}/{locale}', [
        'uses'=>'Admin\AdminController@getOtherEditOrder',
        'as'=>'admin.edit-other-order',

    ]);
    Route::post('/edit-other-order/{id}/{locale}', [
        'uses'=>'Admin\AdminController@postOtherEditOrder',
        'as'=>'admin.edit-other-order',
    ]);

    Route::post('/update-other-order-price/{id}/{ref_number}/{locale}', [
        'uses'=>'Admin\AdminController@updateOtherOrderPrice',
        'as'=>'admin.update-other-order-price',
    ]);

    /*Cutomer-Management*/


    Route::get('/customers/{locale}',[
        'uses'=>'Admin\AdminController@customers',
        'as'=>'admin.customers',
    ]);

    Route::get('/customer/{id}/{email}/{locale}',[
        'uses'=>'Admin\AdminController@customer',
        'as'=>'admin.customer',
    ]);

    Route::get('/subscribers/{locale}',[
        'uses'=>'Admin\AdminController@subscribers',
        'as'=>'admin.subscribers',
    ]);

    /*Agents*/

    Route::get('/new-agent/{locale}',[
        'uses'=>'Admin\AdminController@getNewAgent',
        'as'=>'admin.new-agent',
    ]);

    Route::post('/new-agent/{locale}',[
        'uses'=>'Admin\AdminController@postNewAgent',
        'as'=>'admin.new-agent',
    ]);

    Route::get('edit-agent/{id}/{locale}',[
        'uses'=>'Admin\AdminController@getEditAgent',
        'as'=>'admin.edit-agent',
    ]);

    Route::post('/edit-agent/{id}/{locale}',[
        'uses'=>'Admin\AdminController@postEditAgent',
        'as'=>'admin.edit-agent',
    ]);

    Route::get('/delete-agent/{id}/{locale}',[
        'uses'=>'Admin\AdminController@deleteAgent',
        'as'=>'admin.delete-agent',
    ]);


    Route::get('/our-agents/{locale}',[
        'uses'=>'Admin\AdminController@agents',
        'as'=>'admin.agents',
    ]);

    Route::get('/agent/{id}/{locale}',[
        'uses'=>'Admin\AdminController@agent',
        'as'=>'admin.agent',
    ]);

    Route::post('/get-agent-amount/{id}/{email}/{locale}',[
        'uses'=>'Admin\AdminController@takeAgentAmount',
        'as'=>'admin.take-agent-amount',
    ]);

    /*Reports*/
    Route::get('/account-report/{id}/{email}/{locale}',[
        'uses'=>'Admin\AdminController@getAccountReport',
        'as'=>'admin.account-report',
    ]);

    Route::post('/account-report/{id}/{email}/{locale}',[
        'uses'=>'Admin\AdminController@postAccountReport',
        'as'=>'admin.account-report',
    ]);
    /*By-date*/
    Route::get('reports/orders-by-date/{locale}',[
        'uses'=>'Admin\AdminController@getOrdersByDate',
        'as'=>'admin.reports.orders-by-date',
    ]);

    Route::post('reports/orders-by-date/{locale}',[
        'uses'=>'Admin\AdminController@postOrdersByDate',
        'as'=>'admin.reports.orders-by-date',
    ]);

    /*By-Satus*/
    Route::get('reports/orders-by-status/{locale}',[
        'uses'=>'Admin\AdminController@getOrdersByStatus',
        'as'=>'admin.reports.orders-by-status',
    ]);
    Route::post('reports/orders-by-status/{locale}',[
        'uses'=>'Admin\AdminController@postOrdersByStatus',
        'as'=>'admin.reports.orders-by-status',
    ]);

    /*By-Agent*/
    Route::get('reports/orders-by-agent/{locale}',[
        'uses'=>'Admin\AdminController@getOrdersByAgent',
        'as'=>'admin.reports.orders-by-agent',
    ]);
    Route::post('reports/orders-by-agent/{locale}',[
        'uses'=>'Admin\AdminController@postOrdersByAgent',
        'as'=>'admin.reports.orders-by-agent',
    ]);
    /*By-Client*/
    Route::get('reports/orders-by-client/{locale}',[
        'uses'=>'Admin\AdminController@getOrdersByClient',
        'as'=>'admin.reports.orders-by-client',
    ]);
    Route::post('reports/orders-by-client/{locale}',[
        'uses'=>'Admin\AdminController@postOrdersByClient',
        'as'=>'admin.reports.orders-by-client',
    ]);

    /*Search-Routes*/
    Route::post('search-orders/{locale}',[
        'uses'=>'Admin\AdminController@searchOrders',
        'as'=>'admin.search-orders',
    ]);
    Route::post('search-customers/{locale}',[
        'uses'=>'Admin\AdminController@searchCustomers',
        'as'=>'admin.search-customers',
    ]);
});
/*Ajax Routes*/

Route::get('/ajax-search-receiver/receiver/',function(){
    $rcvr = Input::get('search');
    $receiver = \App\Receiver::orderBy('created_at','desc')
        ->where('phone','=',$rcvr)
        ->orWhere('name','like','%'.$rcvr.'%')
        ->get();
        return Response::json($receiver);
});

Route::get('update-package-orders',function(){
   if(Auth::user()){
      $account = DB::table('accounts')->where('user_id', Auth::user()->id)->first();
       $insideDate = $account->package_inside_validity;
       $outsideDate = $account->package_inside_validity;
       //$r_in_days =   Carbon::today()->diffInDays(new Carbon($insideDate));
       //$r_out_days =   Carbon::today()->diffInDays(new Carbon($insideDate));
       if($insideDate < date('Y-m-d')){
           DB::table('accounts')->where('user_id', Auth::user()->id)->update(['package_inside_quantity'=>0]);
       }
       else{
           return false;
       }
       if($outsideDate < date('Y-m-d')){
           DB::table('accounts')->where('user_id', Auth::user()->id)->update(['package_outside_quantity'=>0]);
       }
       else{
           return false;
       }
   }
    else{
        return 'Something Wrong';
    }
});

Route::get('/insurance-calc',function(){
    $shipment_amount = Input::get('shipment_amount');
    if($shipment_amount > 500){
        $insurance_amount = $shipment_amount*10/100;
    }
    elseif($shipment_amount <= 500){
        $insurance_amount = 0;
    }
    return Response::json($insurance_amount);
});
Route::get('/ajax-get-store',function(){

    $store_id = Input::get('store_id');
    $store = App\Store::where('id','=',$store_id)->get();
    return Response::json($store);
});
Route::get('/ajax-get-receiver',function(){

    $r_id = Input::get('id');
    $receiver = DB::table('receivers')->where('id','=',$r_id)->first();
    return Response::json($receiver);
});

Route::get('/ajax-get-cities',function(){

    $state_code = Input::get('state_code');
    $cities = App\City::where('region','=',$state_code)->get();
    return Response::json($cities);
});

Route::get('/ajax-get-regions',function(){

    $city = Input::get('city');
    $region = App\Region::where('city','=',$city)->get();
    return Response::json($region);
});

Route::get('/ajax-get-neighbors',function(){

    $city = Input::get('city');
    $neighbor = App\Neighbor::where('city','=',$city)->get();
    return Response::json($neighbor);
});


Route::get('/ajax-packing-color',function(){

    $p_id = Input::get('packing_id');
    $color_ids = DB::table('packing_color')->where('packing_id',$p_id)->pluck('color_id');
    $colors = App\Color::whereIn('id',$color_ids)->get();
    return Response::json($colors);
});