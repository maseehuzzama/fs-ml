<?php
use Illuminate\Support\Facades\Input;

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
    return redirect('/en');
})->name('welcome.general');
Route::group(['prefix' => '{locale}'], function () {
    Route::pattern('locale', 'en|ar');
    Route::get('/', function ($locale) {
        App::setLocale($locale);
        return view('welcome');
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
        return view('services');
    })->name('services');

    Route::get('/offers-and-prices', function ($locale) {
        App::setLocale($locale);
        return view('prices');
    })->name('prices');

    Route::get('/our-customers', function ($locale) {
        App::setLocale($locale);
        return view('customers');
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
        'uses'=>'Client\ClientController@searchOrder',
        'as'=>'search-order',
    ]);
});


/*Client-Area-Routes*/
Auth::routes();

Route::get('/home', function () {
    return redirect('/en/client-area');
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
        'as'=>'client.create-store'
    ]);
    Route::post('/create-store', [
            'uses'=>'Client\ClientController@postCreateStore',
            'as'=>'client.create-store'
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
        'as'=>'client.package'
    ]);

    Route::post('/package-request', [
        'uses'=>'Client\ClientController@postPackageRequest',
        'as'=>'client.package'
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

Route::group(['middleware' => 'roles','roles'=>['superadmin'],'prefix' => '/admin'], function () {

    Route::pattern('locale', 'en|ar');

    Route::get('/{locale}', 'Admin\AdminController@index')->name('admin.dashboard');


    Route::get('/order/{id}/{locale}',[
        'uses'=>'Admin\AdminController@order',
        'as'=>'admin.order'
    ]);


    Route::get('/pending-orders/{locale}', function ($locale) {
        App::setLocale($locale);
        return view('admin.pending-orders');
    })->name('admin.pending-orders');

    Route::get('/completed-orders/{locale}', function ($locale) {
        App::setLocale($locale);
        return view('admin.completed-orders');
    })->name('admin.completed-orders');

    Route::pattern('locale', 'en|ar');

    /*Admins*/

    Route::post('/get-accountant-amount/{id}/{email}/{locale}',[
        'uses'=>'Admin\AdminController@takeAccountantAmount',
        'as'=>'admin.take-accountant-amount',
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

    Route::get('/{id}/{email}/{locale}',[
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
    Route::get('/package-requests/{locale}',[
        'uses'=>'Admin\PackageController@packageRequests',
        'as'=>'admin.package-requests',
    ]);

    Route::post('/active-package-request/{user_id}/{id}/{ref}/{locale}',[
        'uses'=>'Admin\PackageController@activePackageRequest',
        'as'=>'admin.active-package-request',
    ]);
    /*Ticket*/
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