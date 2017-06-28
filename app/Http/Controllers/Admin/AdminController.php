<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;
use App\Order;
use App\PhotoOrder;
use Auth;
use App\Admin;
use App\Role;
use App\AdminTransaction;
use App\Agent;
use App\Status;
use App\Transaction;
use App\AgentTransaction;
use App\User;
use App\Account;
use App\Store;
use App\City;
use App\Region;
use App\Neighbor;
use App\Package;
use App\PackageRequest;
use App\PhotoGraphy;
use App\Packing;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use App\Price;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */



    public function index($locale)
    {
        App::setLocale($locale);
        $adminCities = DB::table('admin_city')->where('admin_id',Auth::user()->id)->pluck('city');
        if(Auth::user()->hasRole('superadmin')){
            $newDeliveryOrders = Order::where('is_delivery',1)->whereIn('status',['pending','picked'])->get();
        }
        else{
            /*$newDeliveryOrders = Order::where('is_delivery',1)
                ->whereIn('status',['pending','prepared'])
                ->whereIn('s_city',$adminCities)
                ->orWhereIn('r_city',$adminCities)
                ->get();
            */
            $newDeliveryOrders = Order::where('is_delivery',1)->whereIn('status',['pending','picked'])->get();
        }
        if(Auth::user()->hasRole('superadmin')) {
            $newOtherOrders = Order::where(['is_delivery' => 0])->whereIn('status',['pending','picked'])->get();
        }
        else{
            //$newOtherOrders = Order::where(['status' => 'pending', 'is_delivery' => 0])->whereIn('s_city', $adminCities)->get();
            $newOtherOrders = Order::where(['is_delivery' => 0])->whereIn('status',['pending','picked'])->get();

        }
        $packageRequests = PackageRequest::where('active',0)->get();
        $tickets = App\Ticket::where('status','Open')->where('stage','new')->get();
        return view('admin.index',compact('newOrders','newDeliveryOrders','newOtherOrders','packageRequests','tickets'));
    }

    public function allOrders($locale){
        App::setLocale($locale);
        $allOrders = Order::paginate(50);
        return view('admin.all-orders',compact('allOrders'));
    }
    public function order($id, $locale){
        App::setLocale($locale);
        $order = Order::find($id);
        $photoOrder = PhotoOrder::where('ref_number','=',$order->ref_number)->first();
        $statuses = Status::where('status_by','admin')->get();
        return view('admin.order',compact('order','photoOrder','statuses'));
    }

    public function changeStatus(Request $request, $id, $locale)
    {
        App::setLocale($locale);
        $this->validate($request, array(
            'status' => 'required'
        ));
        $order = Order::find($id);
        if($order->satus == 'pending'){
            return abort(401,'Order still in Pending/Not Picked UP');
        }
        else{
            if($request['status'] == 'prepared'){

                $client = new Client(['base_uri' => 'http://sgw01.cm.nl/']);

                $response = $client->request('GET',
                    '/gateway.ashx?producttoken=3a0eb501-0151-420a-879d-cf139e82e141&body=Order contains '.$order->contains.' ready to reach you soon.&to=00966'.$order->r_phone.'&from=FastStar&reference='.$order->id);
                if($response){
                    $order->status = $request['status'];
                }
            }
            else{
                $order->status = $request['status'];
            }
            if($order->update()){
                return redirect()->back();
            }
        }

    }

    public function pendingOrders($locale)
    {
        App::setLocale($locale);
        $adminCities = DB::table('admin_city')->where('admin_id',Auth::user()->id)->pluck('city');
        if(Auth::user()->hasRole('superadmin')) {
            $pendingOrders = Order::where('is_delivery', 1)->whereNotIn('status', ['delivered', 'processed','return'])
                ->get();
        }
        else {
            /*$pendingOrders = Order::where('is_delivery', 1)->whereNotIn('status', ['delivered', 'processed'])
                ->whereIn('s_city', $adminCities)
                ->orWhereIn('r_city', $adminCities)
                ->get();*/
            $pendingOrders = Order::where('is_delivery', 1)->whereNotIn('status', ['delivered', 'processed','return'])
                ->get();
        }
        return view('admin.pending-orders',compact('pendingOrders'));
    }

    public function completedOrders($locale)
    {
        App::setLocale($locale);
        $adminCities = DB::table('admin_city')->where('admin_id',Auth::user()->id)->pluck('city');
        if(Auth::user()->hasRole('superadmin')) {
            $completedOrders = Order::where('is_delivery',1)->whereIn('status',['delivered','processed','return'])->get();
        }
        else{
            /*$completedOrders = Order::where('is_delivery',1)->whereIn('status',['delivered','processed'])
                ->whereIn('s_city',$adminCities)
                ->orWhereIn('r_city',$adminCities)
                ->get();*/

            $completedOrders = Order::where('is_delivery',1)->whereIn('status',['delivered','processed','return'])->get();
        }
        return view('admin.completed-orders',compact('completedOrders'));
    }

    public function getEditOrder($id,$locale){
        App::setLocale($locale);
        $order = Order::find($id);
        if($order) {
            $stores = Store::where('user_id', $order->user_id)->get();
            $account = Account::where('user_id', $order->user_id)->get();
            $cities = City::whereIn('name',['Riyadh'])->get();
            $r_cities = City::whereIn('country',['SA'])->get();
            $neighbors = Neighbor::where('city', 'Riyadh')->get();
            $packings = App\Packing::all();
            return view('admin.edit-order', compact('order', 'cities','r_cities', 'packings', 'stores', 'account','neighbors'));
        }
        return abort(401,'Order does not exist!');
    }

    public function postEditOrder(Request $request,$id,$locale){
        App::setLocale($locale);
        if($request['store'] == 'other' or $request['store'] == "") {
            $this->validate($request, array(
                'store_name' => 'required',
                'store_country' => 'required',
                'store_city' => 'required',
                'store_neighbour' => 'required',
                'store_street' => 'required',
                'receiver_country' => 'required',
                'receiver_city' => 'required',
                'receiver_name' => 'required',
                'receiver_city' => 'required',
                'receiver_neighbour' => 'required',
                'receiver_street' => 'required',
                'receiver_phone' => 'min:9|max:9',
                'pick_date' => 'date|after:yesterday',
                'contains' => 'required',
                'quantity' => 'required',
                'weight' => 'required',
            ));
        }
        else{
            if($request['store_address'] == "other"){
                $this->validate($request, array(
                    'store_city' => 'required',
                    'store_neighbour' => 'required',
                    'store_street' => 'required',
                    'receiver_city' => 'required',
                    'receiver_name' => 'required',
                    'receiver_city' => 'required',
                    'receiver_phone' => 'min:9|max:9',
                    'receiver_street' => 'required',
                    'pick_date' => 'date|after:yesterday',
                    'contains' => 'required',
                    'quantity' => 'required',
                    'weight' => 'required',
                ));
            }
            else{
                $this->validate($request, array(
                    'receiver_city' => 'required',
                    'receiver_name' => 'required',
                    'receiver_city' => 'required',
                    'receiver_phone' => 'min:9|max:9',
                    'receiver_street' => 'required',
                    'pick_date' => 'date|after:yesterday',
                    'contains' => 'required',
                    'quantity' => 'required',
                    'weight' => 'required',
                ));
            }

        }
        $order = Order::find($id);
        $account = Account::where('user_id',$order->user_id)->first();
        if($order){
            $r_neighbor = Neighbor::find($request['receiver_neighbour']);
            $store = Store::find($request['store']);
            if($request['store'] == 'other' or $request['store'] == ""){
                $s_neighbor = Neighbor::find($request['store_neighbour']);
                $order->store_name= $request['store_name'];
                $order->s_country= $request['store_country'];
                $order->s_city = $request['store_city'];
                $order->s_region = $s_neighbor->region;
                $order->s_neighbor = $s_neighbor->name;
                $order->s_neighbor_id = $s_neighbor->id;
                $order->s_other_neighbor = $request['s_other_neighbor'];
                $order->s_street = $request['store_street'];
                $order->s_phone = $request['store_phone'];
            }
            else
            {
                if($request['store_address'] == 'other')
                {
                    $s_neighbor_id = $request['store_neighbour'];
                    $s_neighbor = Neighbor::find($s_neighbor_id);
                    $order->store_name= $store->name;
                    $order->s_country = $request['store_country'];
                    $order->s_city = $request['store_city'];
                    $order->s_region = $s_neighbor->region;
                    $order->s_neighbor = $s_neighbor->name;
                    $order->s_neighbor_id = $request['store_neighbour'];
                    $order->s_other_neighbor = $request['s_other_neighbor'];
                    $order->s_street = $request['store_street'];
                    $order->s_phone = $request['store_phone'];
                }
                else
                {
                    $s_neighbor_id = $store->neighbor_id;
                    $s_neighbor = Neighbor::find($s_neighbor_id);
                    $order->store_name= $store->name;
                    $order->s_country= $store->country_iso;
                    $order->s_city = $store->city;
                    $order->s_region = $s_neighbor->region;
                    $order->s_neighbor = $s_neighbor->name;
                    $order->s_neighbor_id = $s_neighbor_id;
                    $order->s_street = $store->street;
                    $order->s_phone = $store->phone;
                }
            }

            $order->pick_date = $request['pick_date'];
            $order->pick_time = $request['pick_time'];

            $order->is_delivery = 1;
            $order->r_country= $request['receiver_country'];
            $order->r_city = $request['receiver_city'];
            $order->r_region = $r_neighbor->region;
            $order->r_name = $request['receiver_name'];
            $order->r_neighbor_id = $r_neighbor->id;
            $order->r_neighbor = $r_neighbor->name;
            $order->r_other_neighbor = $request['r_other_neighbor'];
            $order->r_street = $request['receiver_street'];
            $order->r_pincode = $request['receiver_pincode'];
            $order->r_phone = $request['receiver_phone'];

            $order->contains = $request['contains'];
            $order->quantity = $request['quantity'];
            $order->weight = $request['weight'];

            if ($request['insurance'] == true) {
                $order->is_insurance = 1;
            }
            else{
                $order->is_insurance = 0;
            }


            if($request['is_packing'] == true) {
                $order->is_packing = 1;
                @$order->packing_id = $request['packing'];
                @$order->packing_color = $request['packing_color'];
                @$packing = Packing::find($request['packing']);
                if($account){
                    if(($order->s_city == 'Riyadh') && ($order->r_city == 'Riyadh')){
                        if(($account->package_inside == 'PI500' and $account->package_inside_quantity > 0 ) or ($order->is_in_package == 1 and $order->in_package == 'PI500')){
                            @$order->packing_amount = 0;
                        }
                        else{
                            @$order->packing_amount = $packing->packing_price;
                        }
                    }
                    else{
                        if(($account->package_outside == 'PO500' and $account->package_outside_quantity > 0 )  or ($order->is_out_package == 1 and $order->out_package == 'PO500')){
                            @$order->packing_amount = 0;
                        }
                        else{
                            @$order->packing_amount = $packing->packing_price;
                        }
                    }
                }
                else{
                    @$order->packing_amount = $packing->packing_price;
                }
            }
            else{
                $order->is_packing = 0;
                $order->packing_id = null;
                $order->packing_color = null;
                $order->packing_amount = 0;
            }

            $order->spl_req = $request['spl_req'];

            if($order->update()){
                return redirect()->route('admin.select-delivery-type',array($order->ref_number,App::getLocale()));
            }
            return abort(401,'Try Again!');
        }
        return abort(403,'No Match');
    }

    public function getSelectDelivery($locale,$ref){
        App::setLocale($locale);
        $order = Order::where(['ref_number'=>$ref])->orWhere(['id'=>$ref])->first();
        $account = Account::where('user_id',Auth::user()->id)->first();
        if($order){
            if($order->is_submit == 0 or $order->status == 'pending') {
                return view('client.select-delivery-type', compact('order','account'));
            }
        }
        else{
            return abort(403,'Order already submitted');
        }
        return abort(403,'Order does not match with user');
    }

    public function postSelectDelivery(Request $request, $locale, $ref){
        App::setLocale($locale);
        $this->validate($request, array(
            'delivery_type'=>'required',
        ));
        $order = Order::where(['ref_number'=>$ref])->orWhere(['id'=>$ref])->first();
        $account = Account::where(['user_id'=>Auth::user()->id])->first();

        if($order){
            if($order->weight >= 16){
                $weight_chrgs = ($request['weight'] - 15)*2;
            }
            else{
                $weight_chrgs = 0;
            }

            if($request['delivery_type'] == 'fed'){
                $price_var = Price::where('service_code','DIE')->first();
                $dlv_chrgs = $price_var->price+$weight_chrgs;
            }
            elseif($request['delivery_type'] == 'fs'){
                $price_var = Price::where('service_code','DO')->first();
                $dlv_chrgs = $price_var->price+$weight_chrgs;
            }
            else {
                if ($account == true) {
                    if (($order->s_city == 'Riyadh') && ($order->r_city == 'Riyadh')) {
                        if ($account->package_inside_quantity > 0 or ($order->is_in_package == 1 and $order->in_package == 'PI500')) {
                            $dlv_chrgs = 0 + $weight_chrgs;
                        } else {
                            $price_var = Price::where('service_code', 'DI')->first();
                            $dlv_chrgs = $price_var->price + $weight_chrgs;
                        }
                    } elseif (($order->s_city !== 'Riyadh') or ($order->r_city !== 'Riyadh')) {
                        if ($account->package_outside_quantity > 0 or ($order->is_out_package == 1 and $order->out_package == 'PO500')) {
                            $dlv_chrgs = 0 + $weight_chrgs;
                        } else {
                            $price_var = Price::where('service_code', 'DO')->first();
                            $dlv_chrgs = $price_var->price + $weight_chrgs;
                        }
                    }
                } else {
                    if (($order->s_city == 'Riyadh') && ($order->r_city == 'Riyadh')) {
                        $price_var = Price::where('service_code', 'DI')->first();
                        $dlv_chrgs = $price_var->price + $weight_chrgs;
                    } else {
                        $price_var = Price::where('service_code', 'DO')->first();
                        $dlv_chrgs = $price_var->price + $weight_chrgs;
                    }
                }
            }
            $order->dlv_chrgs = $dlv_chrgs;
            $order->total_freight = $freight = $order->packing_amount + $order->dlv_chrgs;
            $order->dlv_type = $request['delivery_type'];
            $order->save();
            return redirect()->route('client.submit-order',[$locale,$order->id]);
        }

    }

    public function getSubmitOrder($id, $locale){
        App::setLocale($locale);
        $order = Order::find($id);
        $account = Account::where('user_id',$order->user_id)->first();
        $trans = Transaction::where(['user_id'=>$order->user_id,'order_id'=>$order->id, 'reference'=>$order->ref_number,'type'=>'debit'])->first();

        if($order){
            if($order->is_submit == 0 or $order->status == 'pending') {
                return view('admin.submit-order', compact('order','account','trans'));
            }
        }
        return abort(401,'Order already submitted');

    }
    public function postSubmitOrder(Request $request,$id,$locale){
        App::setLocale($locale);
        $this->validate($request, array(
            'payment_mode'=>'required',
        ));
        $order = Order::where(['id'=>$id])->first();
        $account = Account::where(['user_id'=>$order->user_id])->first();
        if($order) {
            DB::transaction(function () use ($order, $account, $request,$id) {


                if ($account) {
                    //New Condition
                    if ($order->is_submit == 0) {
                        if (($order->s_city == 'Riyadh') && ($order->r_city == 'Riyadh')) {
                            if (($account->package_inside_quantity > 0) and ($account->package_inside_quantity != null)) {
                                $order->is_in_package = 1;
                                $order->in_package = $account->package_inside_code;
                                $account->package_inside_quantity = $account->package_inside_quantity - 1;
                            }
                        } elseif (($order->s_city !== 'Riyadh') or ($order->r_city !== 'Riyadh')) {
                            if (($account->package_outside_quantity > 0) and ($account->package_outside_quantity != null)) {
                                $order->is_out_package = 1;
                                $order->out_package = $account->package_outside_code;
                                $account->package_outside_quantity = $account->package_outside_quantity - 1;
                            }
                        } else {
                            return abort(403, 'Something Wrong!');
                        }
                    } else {
                        ///
                    }



                    if($request['payment_mode'] == 3){
                        if (($order->s_city == 'Riyadh') && ($order->r_city == 'Riyadh')) {
                            if ($account->package_inside_quantity > 0  or ($order->is_in_package == 1)) {
                                $order->total_freight = $order->total_freight;
                            }
                            else{
                                $order->total_freight = $order->total_freight+3;
                            }

                        } elseif (($order->s_city !== 'Riyadh') or ($order->r_city !== 'Riyadh')) {
                            if ($account->package_outside_quantity > 0 or ($order->is_out_package == 1)) {
                                $order->total_freight = $order->total_freight;
                            }
                            else{
                                $order->total_freight = $order->total_freight+3;
                            }
                        }
                    }
                    else{
                        $order->total_freight = $order->total_freight;
                    }
                    //New Condition
                    $transaction = Transaction::where(['user_id' => Auth::user()->id, 'order_id' => $id, 'reference' => $order->ref_number, 'type' => 'debit'])->first();

                    if ($order->total_freight > 0) {

                        if ($transaction) {
                            $account->wallet_amount = $account->wallet_amount + $transaction->amount;
                            $transaction->delete();
                            if (($request['payment_mode'] == 1) or ($request['payment_mode'] == 'tfa')) {
                                $new_trans = new Transaction();
                                $new_trans->name = 'Order Delivery Charges';
                                $new_trans->type = 'debit';
                                $new_trans->user_id = $order->user_id;
                                $new_trans->order_id = $order->id;
                                $new_trans->reference = $order->ref_number;
                                $new_trans->amount = $order->total_freight;
                                $new_trans->balance_before = $account->wallet_amount;
                                $new_trans->balance = $account->wallet_amount - $order->total_freight;
                                if ($new_trans->save()) {
                                    $account->wallet_amount = $account->wallet_amount - $order->total_freight;
                                } else {
                                    return abort(403, 'Something Wrong in New Transcation!');
                                }
                            }
                        }
                        else {
                            if (($request['payment_mode'] == 1) or ($request['payment_mode'] == 'tfs')) {
                                $new_trans = new Transaction();
                                $new_trans->name = 'Order Delivery Charges';
                                $new_trans->type = 'debit';
                                $new_trans->user_id = $order->user_id;
                                $new_trans->order_id = $order->id;
                                $new_trans->reference = $order->ref_number;
                                $new_trans->amount = $order->total_freight;
                                $new_trans->balance_before = $account->wallet_amount;
                                $new_trans->balance = $account->wallet_amount - $order->total_freight;
                                if ($new_trans->save()) {
                                    $account->wallet_amount = $account->wallet_amount - $order->total_freight;
                                } else {
                                    return abort(403, 'Something Wrong in New Transcation!');
                                }
                            } elseif (($request['payment_mode'] == 2) or ($request['payment_mode'] == 'tfs')) {
                                $order->is_cod = 0;
                                $order->cod_amount = 0;
                                $order->return_amount = 0;
                            } elseif (($request['payment_mode'] == 3) or ($request['payment_mode'] == 'cod')) {
                                $order->is_cod = 1;
                                $order->cod_amount = $request['cod_amount'];
                                $order->return_amount = $request['cod_amount'] - $order->total_freight;
                            }
                        }
                    }
                    else//total_freight = 0
                    {
                        if ($transaction) {
                            $account->wallet_amount = $account->wallet_amount + $transaction->amount;
                            $transaction->delete();
                        }

                        if(($request['payment_mode'] == 4)){
                            if($request['is_cod']){
                                $order->is_cod = 1;
                                $order->cod_amount = $request['cod_amount'];
                                $order->return_amount = $request['cod_amount'];
                            }
                            else{
                                $order->is_cod = 0;
                                $order->cod_amount = 0;
                                $order->return_amount = 0;
                            }
                        }
                    }
                    $order->payment_id = $request['payment_mode'];
                    $account->update();
                } else {
                    if (($request['payment_mode'] == 3) or ($request['payment_mode'] == 'cod')) {
                        $order->is_cod = 1;
                        $order->cod_amount = $request['cod_amount'];
                        $order->total_freight = $order->total_freight+3;
                        $order->return_amount = $request['cod_amount'] - $order->total_freight;
                    } elseif (($request['payment_mode'] == 2) or ($request['payment_mode'] == 'tfs')) {
                        $order->is_cod = 0;
                        $order->cod_amount = 0;
                        $order->return_amount = 0;
                    }
                    else {
                        return abort(401, 'Not Allowed');
                    }
                    $order->payment_id = $request['payment_mode'];
                }
                $order->is_submit = 1;
                if ($order->update()) {
                    return redirect()->route('client.orders', App::getLocale());
                } else {
                    return abort(403, 'Something Wrong in saving order!');
                }
            });
        }
        else{
            return abort(403,'Order does not match with user');
        }
    }


/*Other-Orders*/
    public function pendingOtherOrders($locale)
    {
        App::setLocale($locale);
        //$pendingOrders = Order::where('is_delivery',0)->whereNotIn('status',['delivered','processed'])->whereIn('s_city',[Auth::user()->city,'r_city',Auth::user()->city])->get();
        $pendingOrders = Order::where('is_delivery',0)->whereNotIn('status',['delivered','processed'])->get();
        return view('admin.other-orders.pending-other-orders',compact('pendingOrders'));
    }

    public function completedOtherOrders($locale)
    {
        App::setLocale($locale);
        //$completedOrders = Order::where('is_delivery',0)->whereIn('status',['delivered','processed'])->whereIn('s_city',[Auth::user()->city,'r_city',Auth::user()->city])->get();
        $completedOrders = Order::where('is_delivery',0)->whereIn('status',['delivered','processed'])->get();
        return view('admin.other-orders.completed-other-orders',compact('completedOrders'));
    }


    public function getOtherEditOrder($id,$locale){
        App::setLocale($locale);
        $order = Order::find($id);
        $packings = Packing::all();
        $photos = PhotoGraphy::all();
        $cities = City::whereIn('name',['Riyadh','Jeddah'])->get();
        $regions = Region::where('country','SA')->get();
        $neighbors = Neighbor::where('city','Riyadh')->get();
        $account = Account::where('user_id',$order->user_id)->first();
        $stores = Store::where('user_id',$order->user_id)->get();
        $p_order = PhotoOrder::where(['ref_number'=>$order->ref_number,'user_id'=>$order->user_id])->first();
        if($order->status == 'pending'){
            return view('admin.other-orders.edit-order',compact('packings','photos','cities','regions','neighbors','account','stores','order','p_order'));
        }
        return abort(403,'Order already submitted');
    }
    public function postOtherEditOrder(Request $request,$id,$locale){
        App::setLocale($locale);
        if($request['store'] == 'other' or $request['store'] == "") {
            $this->validate($request, array(
                'store_country' => 'required',
                'store_city' => 'required',
                'store_neighbour' => 'required',
                'store_street' => 'required',
                'photo_quantity' => 'required',
                'photo_address' => 'required',
                'photo_description' => 'required',
                'contains' => 'required',
                'quantity' => 'required',
                'weight' => 'required',
            ));
        }
        else{
            $this->validate($request, array(
                'store' => 'required',
                'photo_quantity' => 'required',
                'photo_description' => 'required',
                'contains' => 'required',
                'quantity' => 'required',
                'weight' => 'required',
            ));
        }

        $order = Order::where('id',$id)->first();

        $store = Store::find($request['store']);

        if($request['store'] == 'other' or $request['store'] == ""){
            $s_neighbor = Neighbor::find($request['store_neighbour']);
            $order->store_name= $request['store_name'];
            $order->s_country= $request['store_country'];
            $order->s_city = $request['store_city'];
            $order->s_region = $s_neighbor->region;
            $order->s_neighbor_id = $s_neighbor->id;
            $order->s_neighbor = $s_neighbor->name;
            $order->s_other_neighbor = $request['s_other_neighbor'];
            $order->s_street = $request['store_street'];
            $order->s_phone = $request['store_phone'];
        }
        else
        {
            if($request['store_address'] == 'other')
            {
                $s_neighbor_id = $request['store_neighbour'];
                $s_neighbor = Neighbor::find($s_neighbor_id);
                $order->store_name= $store->name;
                $order->s_country = $request['store_country'];
                $order->s_city = $request['store_city'];
                $order->s_region = $s_neighbor->region;
                $order->s_neighbor = $s_neighbor->name;
                $order->s_neighbor_id = $s_neighbor->id;
                $order->s_other_neighbor = $request['s_other_neighbor'];
                $order->s_street = $request['store_street'];
                $order->s_phone = $request['store_phone'];
            }
            else
            {
                $s_neighbor_id = $store->neighbor_id;
                $s_neighbor = Neighbor::find($s_neighbor_id);
                $order->store_name= $store->name;
                $order->s_country= $store->country_iso;
                $order->s_city = $store->city;
                $order->s_region = $s_neighbor->region;
                $order->s_neighbor_id = $s_neighbor->id;
                $order->s_neighbor = $s_neighbor->name;
                $order->s_street = $store->street;
                $order->s_phone = $store->phone;
            }
        }
        $order->pick_date = $request['pick_date'];
        $order->pick_time = $request['pick_time'];
        $order->contains = $request['contains'];
        $order->quantity = $request['quantity'];
        $order->weight = $request['weight'];

        $order->is_photo = 1;
////////////////////////////
        $p_order = PhotoOrder::where(['ref_number'=>$order->ref_number,'user_id'=>$order->user_id])->first();

        $p_order->quantity = $request['photo_quantity'];
        $p_order->description = $request['photo_description'];
        if($request['photo_address'] == 'same' or $request['photo_address'] == ""){
            $p_order->address = 'same as store address';
        }
        else{
            $p_order->address = $request['photo_address'];
        }
//////////////////////
        if($order->update()){
            if($p_order->update()){
                $order->is_submit = 1;
                $order->update();
                return redirect()->route('admin.order',array($order->id,App::getLocale()))->with('success','Order Updated successfully');
            }
        }
    }


    public function updateOtherOrderPrice(Request $request,$id,$ref_number,$locale){
        App::setLocale($locale);
        $order = Order::where(['id'=>$id,'ref_number'=>$ref_number])->first();
        if($order){
            $p_order = PhotoOrder::where(['ref_number'=>$order->ref_number,'user_id'=>$order->user_id])->first();
            if($p_order){
                $p_order->price = $request['photo_price'];
                if($p_order->update()){
                    return redirect()->route('admin.order',array($order->id,App::getLocale()))->with('success','Order Updated successfully');
                }
            }
            return abort(401,'Order does not exists');
        }
        return abort(401,'Order does not exists');

    }


    /*Customer-Management*/
    public function customers($locale){
        App::setLocale($locale);
        $adminCities = DB::table('admin_city')->where('admin_id',Auth::user()->id)->pluck('city');
        if(Auth::user()->hasRole('superadmin')){
            $customers = User::paginate(1);
        }
        else{
            //$customers = User::whereIn('city',$adminCities)->get();
            $customers = User::paginate(1);

        }

        return view('admin.customers', compact('customers'));
    }
    public function customer($id,$email,$locale){
        App::setLocale($locale);
        $adminCities = DB::table('admin_city')->where('admin_id',Auth::user()->id)->pluck('city');
        if(Auth::user()->hasRole('superadmin')){
            $customer = User::where(['id'=>$id,'email'=>$email])->first();
            $stores = Store::where('user_id',$id)->get();
        }
        else{
            $customer = User::where(['id'=>$id,'email'=>$email])->first();
            $stores = Store::where('user_id',$id)->get();
        }
        if($customer){
            return view('admin.customer-show', compact('customer','stores'));

        }
        else{
            return abort(401,'No Customer Exist');
        }
    }

    public function transferClientAmount(Request $request, $id,$email, $locale){

        App::setLocale($locale);
        $this->validate($request, [
            'amount'=>'required',
            'reference'=>'required|unique:transactions',
            'file' => 'image|mimes:jpeg,png,jpg,gif|max:500'
        ]);

        /*$adminCities = DB::table('admin_city')->where('admin_id',Auth::user()->id)->pluck('city');
        $user = User::where('id',$id)->whereIn('city',$adminCities)->first();*/

        $user = User::where(['id'=>$id,'email'=>$email])->first();

        $trans = Transaction::where(['user_id'=>$id, 'reference'=>$request['reference']])->first();

        if(!$user  and !(Auth::user()->hasRole('superadmin'))){
            return abort(401,'Something Wrong!');
        }
        if(count($trans) >= 1){
            return abort(401,'Transaction Already done!');
        }

        $account = Account::where('user_id',$id)->first();
        if($request['amount'] <= $account->wallet_amount){
            /*Transaction*/
            $transaction = new Transaction();
            $transaction->name = 'Transfer By Site Admin';
            $transaction->type = 'debit';
            $transaction->user_id = $id;
            $transaction->reference = $request['reference'];
            $transaction->side = 'site-admin';
            $transaction->site_admin = Auth::user()->id;
            $transaction->amount = $request['amount'];
            $transaction->balance_before = $account->wallet_amount;
            $transaction->balance = $account->wallet_amount - $request['amount'];

            if($request->hasFile('file')){
                $file = $request->file('file');
                $filename = time().$file->getClientOriginalName();
                $destinationPath = 'files/transactions';
                if($file->move($destinationPath, $filename)){
                    $transaction->file = $filename;
                }
            }
            DB::transaction(function() use ($transaction, $request,$account) {

                    $transaction->save();
                    $account->wallet_amount = $account->wallet_amount - $request['amount'];
                    $account->update();
            });
            return redirect()->route('admin.customer', array($id, $email, App::getLocale()))->with('success', 'Amount Transfered');
        }
        else{
            return abort(401,'Customers Wallet Amount is less than transfer amount');
        }
    }
    /*Branch-and-Employee*/
    public function agents($locale){
        App::setLocale($locale);
        $adminCities = DB::table('admin_city')->where('admin_id',Auth::user()->id)->pluck('city');
        if(Auth::user()->hasRole('superadmin')){
            $agents = Agent::all();
        }
        else{
            $agents = Agent::whereIn('city',$adminCities)->get();
        }
        return view('admin.agents.our-agents',compact('agents'));
    }

    public function getNewAgent($locale){
        App::setLocale($locale);
        $countries = DB::table('countries')->get();
        $cities = DB::table('cities')->where('country','SA')->get();
        return view('admin.agents.new-agent', compact('countries','cities'));
    }

    public function postNewAgent(Request $request, $locale){
        App::setLocale($locale);
        $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|unique:agents|max:255',
            'email' => 'required|email|max:255|unique:agents',
            'phone' => 'required|max:20',
            'country' => 'required',
            'city' => 'required',
            'region' => 'required',
            'password' => 'required|min:6',
        ]);

        $agent = new Agent();
        $agent->username = $request['username'];
        $agent->password = bcrypt($request['password']);
        $agent->name = $request['name'];
        $agent->email = $request['email'];
        $agent->phone = $request['phone'];
        $agent->country = $request['country'];
        $agent->city = $request['city'];
        $agent->type = $request['type'];
        if($agent->save()){
            $agent->regions()->sync($request->region);
            return redirect()->route('admin.dashboard',App::getLocale());
        }
    }

    public function getEditAgent($id, $locale){
        App::setLocale($locale);
        $countries = DB::table('countries')->get();
        $cities = DB::table('cities')->where('country','SA')->get();
        $agent = Agent::find($id);
        if($agent){
            $agentRegionIds = $agent->regions->pluck('id');
            $agentRegions = Region::whereIn('id',$agentRegionIds)->get();
            $cityRegions = Region::where('city',$agent->city)->whereNotIn('id',$agentRegionIds)->get();
            return view('admin.agents.edit-agent', compact('countries','cities','agent','agentRegions','cityRegions'));
        }
        return abort(401,'Record Not found');
    }

    public function postEditAgent(Request $request,  $id, $locale){
        App::setLocale($locale);
        $this->validate($request, [
            'name' => 'required|max:255',
            'phone' => 'required|max:20',
            'country' => 'required',
            'city' => 'required',
        ]);

        $agent = Agent::find($id);
        if($request['password'] == ""){
            $agent->password = bcrypt($request['password']);
        }
        $agent->name = $request['name'];
        $agent->phone = $request['phone'];
        $agent->country = $request['country'];
        $agent->city = $request['city'];
        $agent->type = $request['type'];
        if($agent->update()){
            if($request->region == true){
                $agent->regions()->sync($request->region);
            }
            return redirect()->route('admin.agents',App::getLocale());
        }
    }
    public function agent($id,$locale){
        App::setLocale($locale);
        $agent = Agent::find($id);
        if($agent == true){
            return view('admin.agents.agent-show', compact('agent'));
        }
        return abort(401,'Record Not found');
    }

    public function takeAgentAmount(Request $request, $id,$email,$locale){
        App::setLocale($locale);
        $agent = Agent::where(['id'=>$id,'email'=>$email])->first();

        if(!$agent  and !(Auth::user()->hasRole('superadmin'))){
            return abort(401,'Something Wrong!');
        }
        if($request['amount'] <= $agent->wallet_amount){
            $ref = $agent->id.Auth::user()->id.time();
            /*Transaction*/
            $transaction = new AgentTransaction();
            $transaction->name = 'Taken By '.Auth::user()->name.'-'.Auth::user()->email;
            $transaction->type = 'debit';
            $transaction->agent_id = $id;
            $transaction->amount = $request['amount'];
            $transaction->balance_before = $agent->wallet_amount;
            $transaction->balance = $agent->wallet_amount - $request['amount'];
            $transaction->reference = $ref;

            /*Admin-Transaction*/
            $admin_trans = new AdminTransaction();
            $admin_trans->name = 'From '.$agent->name.'-'.$agent->email;
            $admin_trans->type = 'credit';
            $admin_trans->admin_id = Auth::user()->id;
            $admin_trans->amount = $request['amount'];
            $admin_trans->balance_before = Auth::user()->wallet_amount;
            $admin_trans->balance = Auth::user()->wallet_amount + $request['amount'];
            $admin_trans->reference = $ref;
            DB::transaction(function() use ($transaction, $admin_trans,$agent,$request,$id) {
                if($transaction->save()){
                    if($admin_trans->save()){
                        $agent->wallet_amount = $agent->wallet_amount - $request['amount'];
                        if($agent->update()){
                            Auth::user()->wallet_amount = Auth::user()->wallet_amount + $request['amount'];
                            Auth::user()->update();

                        }
                    }
                }
            });
            return redirect()->route('admin.agent',array($id,App::getLocale()))->with('success','Amount Transfered');
        }
        else{
            return abort(401,'Agent Wallet Amount is less than transfer amount');
        }
        return abort(401,'Something Went Wrong');
    }

    /*Admin*/
    public function admins($locale){
        App::setLocale($locale);
        if(Auth::user()->hasRole('superadmin')){
            $admins = Admin::all();
        }
        else{
            $admins = Admin::where('by_admin',Auth::user()->id)->get();
        }
        return view('admin.admins.our-admins',compact('admins'));
    }

    public function getNewAdmin($locale){
        App::setLocale($locale);
        $countries = DB::table('countries')->get();
        $cities = DB::table('cities')->where('country','SA')->get();
        if(Auth::user()->hasRole('superadmin')){
            $roles = Role::all();
        }
        elseif(Auth::user()->hasRole('admin')){
            $roles = Role::where('name','subadmin')->get();
        }
        return view('admin.admins.new-admin', compact('countries','cities','roles'));
    }

    public function postNewAdmin(Request $request, $locale){
        App::setLocale($locale);
        $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|unique:agents|max:255',
            'email' => 'required|email|max:255|unique:agents',
            'phone' => 'required|max:20',
            'country' => 'required',
            'city' => 'required',
            'password' => 'required|min:6',
        ]);

        $admin = new Admin();
        $admin->by_admin = Auth::user()->id;
        $admin->username = $request['username'];
        $admin->password = bcrypt($request['password']);
        $admin->name = $request['name'];
        $admin->email = $request['email'];
        $admin->phone = $request['phone'];
        $admin->country = $request['country'];
        $admin->city = $request['city'];
        $admin->type = $request['type'];
        if($admin->save()) {
            $admin->roles()->attach(Role::where('name',$request['type'])->first());
            return redirect()->route('admin.admins', App::getLocale());
        }
        return abort(401,'Not saved');
    }


    public function getEditAdmin($id,$locale){
        App::setLocale($locale);
        $countries = DB::table('countries')->get();
        $cities = DB::table('cities')->where('country','SA')->get();
        if(Auth::user()->hasRole('superadmin')){
            $roles = Role::all();
            $admin = Admin::where(['id'=>$id])->whereIn('type',['superadmin','admin','subadmin'])->first();
            if(!$admin){
                return abort(401,'Something Wrong!');
            }
        }
        elseif(Auth::user()->hasRole('admin')){
            $roles = Role::where('name','subadmin')->get();
            $admin = Admin::where(['id'=>$id])->whereIn('type',['subadmin'])->first();
            if(!$admin){
                return abort(401,'Something Wrong!');
            }
        }

        return view('admin.admins.edit-admin', compact('countries','cities','roles','admin'));
    }

    public function postEditAdmin(Request $request, $id, $locale){
        App::setLocale($locale);
        $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|unique:agents|max:255',
            'email' => 'required|email|max:255|unique:agents',
            'phone' => 'required|max:20',
            'country' => 'required',
            'city' => 'required',
        ]);

        $admin = Admin::find($id);
        $admin->by_admin = Auth::user()->id;
        $admin->username = $request['username'];
        $admin->password = bcrypt($request['password']);
        $admin->name = $request['name'];
        $admin->email = $request['email'];
        $admin->phone = $request['phone'];
        $admin->country = $request['country'];
        $admin->city = $request['city'];
        $admin->type = $request['type'];
        if($admin->save()) {
            $admin->roles()->attach(Role::where('name',$request['type'])->first());
            return redirect()->route('admin.admins', App::getLocale());
        }
        return abort(401,'Not saved');
    }

    public function assignWorkCity(Request $request, $id,$email,$locale){
        App::setLocale($locale);
        $this->validate($request, [
            'city'=>'required'
        ]);
        $city = City::find($request['city']);
        $admin = Admin::where(['id'=>$id,'email'=>$email])->first();
         $insert =DB::table('admin_city')->insert(
            ['admin_id' => $admin->id, 'city_id' => $request['city'],'city'=>$city->name,'country'=>'SA']
        );
        if($insert == true){
            return redirect()->route('admin.admins',App::getLocale());
        }
    }

    public function admin($id,$email,$locale){
        App::setLocale($locale);
        $cities = City::where('country','SA')->get();
        if(Auth::user()->hasRole('superadmin')){
            $admin = Admin::where(['id'=>$id,'email'=>$email])->first();
        }
        else{
            $admin = Admin::where(['id'=>$id,'email'=>$email])->where('by_admin',Auth::user()->id)->first();
        }
        if($admin){
            return view('admin.admins.admin-show', compact('cities','admin'));
        }
        return abort(401,'Record Not found');
    }


    /*SuperVisor Account*/
    public function takeSupervisorAmount(Request $request, $id,$email,$locale){
        App::setLocale($locale);
        $person = Admin::where(['id'=>$id,'email'=>$email,'type'=>'subadmin'])->first();

        if(!$person  and !(Auth::user()->hasRole('superadmin'))){
            return abort(401,'Something Wrong!');
        }
        if($request['amount'] <= $person->wallet_amount){
            $ref = $person->id.Auth::user()->id.time();
            /*Transaction*/
            $transaction = new AdminTransaction();
            $transaction->name = 'Taken By '.Auth::user()->name.'-'.Auth::user()->email;
            $transaction->type = 'debit';
            $transaction->admin_id = $id;
            $transaction->amount = $request['amount'];
            $transaction->balance_before = $person->wallet_amount;
            $transaction->balance = $person->wallet_amount - $request['amount'];
            $transaction->reference = $ref;

            if($transaction->save()){
                $admin_trans = new AdminTransaction();
                $admin_trans->name = 'From '.$person->name.'-'.$person->email;
                $admin_trans->type = 'credit';
                $admin_trans->admin_id = Auth::user()->id;
                $admin_trans->amount = $request['amount'];
                $admin_trans->balance_before = Auth::user()->wallet_amount;
                $admin_trans->balance = Auth::user()->wallet_amount + $request['amount'];
                $admin_trans->reference = $ref;

                DB::transaction(function() use ($admin_trans, $person,$request) {
                    if($admin_trans->save()){
                        $person->wallet_amount = $person->wallet_amount - $request['amount'];
                        if($person->update()){
                            Auth::user()->wallet_amount = Auth::user()->wallet_amount + $request['amount'];
                            Auth::user()->update();
                        }
                    }
                });
                return redirect()->route('admin.admin',array($id,$email,App::getLocale()))->with('success','Amount Transfered');
            }
        }
        else{
            return abort(401,'Supervisor Wallet Amount is less than transfer amount');
        }
        return abort(401,'Something Went Wrong');
    }


    /*Accountant-account*/
    public function takeAccountantAmount(Request $request, $id,$email,$locale){
        App::setLocale($locale);
        $person = Admin::where(['id'=>$id,'email'=>$email,'type'=>'admin'])->first();

        if(!$person  and !(Auth::user()->hasRole('superadmin'))){
            return abort(401,'Something Wrong!');
        }
        if($request['amount'] <= $person->wallet_amount){
            $ref = $person->id.Auth::user()->id.time();
            /*Transaction*/
            $transaction = new AdminTransaction();
            $transaction->name = 'Taken By SuperAdmin-'.Auth::user()->name.'-'.Auth::user()->email;
            $transaction->type = 'debit';
            $transaction->admin_id = $id;
            $transaction->amount = $request['amount'];
            $transaction->balance_before = $person->wallet_amount;
            $transaction->balance = $person->wallet_amount - $request['amount'];
            $transaction->reference = $ref;

            if($transaction->save()){
                $admin_trans = new AdminTransaction();
                $admin_trans->name = 'From Accountant-'.$person->name.'-'.$person->email;
                $admin_trans->type = 'credit';
                $admin_trans->admin_id = Auth::user()->id;
                $admin_trans->amount = $request['amount'];
                $admin_trans->balance_before = Auth::user()->wallet_amount;
                $admin_trans->balance = Auth::user()->wallet_amount + $request['amount'];
                $admin_trans->reference = $ref;

                DB::transaction(function() use ($admin_trans, $person,$request) {
                    if($admin_trans->save()){
                        $person->wallet_amount = $person->wallet_amount - $request['amount'];
                        if($person->update()){
                            Auth::user()->wallet_amount = Auth::user()->wallet_amount + $request['amount'];
                            Auth::user()->update();

                        }
                    }
                });
                return redirect()->route('admin.admin',array($id,$email,App::getLocale()))->with('success','Amount Transfered');
            }
        }
        else{
            return abort(401,'Accountant Wallet Amount is less than transfer amount');
        }
        return abort(401,'Something Went Wrong');
    }
    /*Reports*/
    public function getAccountReport($id, $email, $locale){
        App::setLocale($locale);
        if($id == Auth::user()->id or Auth::user()->hasRole('superadmin') or Auth::user()->hasRole('admin')){
            $fromDate = date('Y-m-d' . ' 00:00:00', time()); //need a space after dates.
            $toDate = date('Y-m-d' . ' 23:59:59', time());
            $transactions = AdminTransaction::where('admin_id',$id)->whereBetween('created_at',[$fromDate,$toDate])->get();
            $admin = Admin::where(['id'=>$id,'email'=>$email])->first();
            if($admin){
                return view('admin.admins.account-report',compact('transactions','admin'));
            }
            return abort(401, 'Something Went Wrong or Record Not Found');
        }
        return abort(401,'Insufficient Permission');
    }
    public function postAccountReport(Request $request, $id, $email, $locale){
        App::setLocale($locale);
        if($id == Auth::user()->id or Auth::user()->hasRole('superadmin') or Auth::user()->hasRole('admin')){
            $fromDate = date($request['from'] . ' 00:00:00', time()); //need a space after dates.
            $toDate = date($request['to'] . ' 23:59:59', time());
            $transactions = AdminTransaction::where('admin_id',$id)->whereBetween('created_at',[$fromDate,$toDate])->get();
            $admin = Admin::where(['id'=>$id,'email'=>$email])->first();
            if($admin){
                $from = $request['from'];
                $to = $request['to'];
                return view('admin.admins.account-report',compact('transactions','admin','from','to'));
            }
            return abort(401, 'Something Went Wrong or Record Not Found');
        }
        return abort(401,'Insufficient Permission');
    }

    public function getOrdersByDate($locale){
        App::setLocale($locale);
        $fromDate = date('Y-m-d' . ' 00:00:00', time()); //need a space after dates.
        $toDate = date('Y-m-d' . ' 23:59:59', time());
        $orders = Order::whereBetween('created_at',[$fromDate,$toDate])->get();

        return view('admin.reports.orders-by-date',compact('orders'));
    }
    public function postOrdersByDate(Request $request, $locale){
        App::setLocale($locale);
        $fromDate = date($request['from'] . ' 00:00:00', time()); //need a space after dates.
        $toDate = date($request['to'] . ' 23:59:59', time());
        $orders = Order::whereBetween('created_at',[$fromDate,$toDate])->get();
        $from = $request['from'];
        $to = $request['to'];
        return view('admin.reports.orders-by-date',compact('orders','from','to'));
    }
    public function getOrdersByStatus($locale){
        App::setLocale($locale);
        $orders = Order::orderBy('created_at','desc')->get();
        $statuses = Status::all();
        return view('admin.reports.orders-by-status',compact('orders','statuses'));
    }
    public function postOrdersByStatus(Request $request, $locale){
        App::setLocale($locale);
        $orders = Order::orderBy('created_at','desc')->where('status',$request['status'])->get();
        $statuses = Status::all();
        $stats = $request['status'];
        return view('admin.reports.orders-by-status',compact('orders','statuses','stats'));
    }
    public function getOrdersByAgent($locale){
        App::setLocale($locale);
        $orders = Order::orderBy('created_at','desc')->get();
        $agents = Agent::all();
        return view('admin.reports.orders-by-agent',compact('orders','agents'));
    }
    public function postOrdersByAgent(Request $request, $locale){
        App::setLocale($locale);
        $orders = Order::orderBy('created_at','desc')->where('pick_agent',$request['agent'])->orwhere('deliver_agent',$request['agent'])->get();
        $agents = Agent::all();
        $agnt = $request['agent'];
        return view('admin.reports.orders-by-agent',compact('orders','agents','agnt'));
    }

    public function getOrdersByClient($locale){
        App::setLocale($locale);
        $orders = Order::orderBy('created_at','desc')->get();
        $clients = User::all();
        return view('admin.reports.orders-by-client',compact('orders','clients'));
    }
    public function postOrdersByClient(Request $request, $locale){
        App::setLocale($locale);
        $orders = Order::orderBy('created_at','desc')->where('user_id',$request['client'])->get();
        $clients = User::all();
        $clint = User::find($request['client']);

        return view('admin.reports.orders-by-client',compact('orders','clients','clint'));
    }

    /*Search-Section*/
    public function searchOrders(Request $request,$locale){
        App::setLocale($locale);
        $this->validate($request,[
            'search'=>'required'
        ]);
        $searchOrders = Order::orderBy('created_at','desc')
            ->where('id','=',$request['search'])
            ->orWhere('ref_number','=',$request['search'])
            ->orWhere('ref_number','=',$request['search'])
            ->orWhere('pick_agent','like','%'.$request['search'].'%')
            ->orWhere('deliver_agent','like','%'.$request['search'].'%')
            ->orWhere('user_id','=',$request['search'])
            ->orWhere('s_city','like','%'.$request['search'].'%')
            ->orWhere('r_city','like','%'.$request['search'].'%')
            ->orWhere('status','like','%'.$request['search'].'%')
            ->paginate(50);
        return view('admin.search.orders',compact('searchOrders'));
    }

    public function searchCustomers(Request $request,$locale){
        App::setLocale($locale);
        $this->validate($request,[
            'search'=>'required'
        ]);
        $searchCustomers = User::orderBy('created_at','desc')
            ->where('id','=',$request['search'])
            ->orWhere('email','=',$request['search'])
            ->orWhere('phone','=',$request['search'])
            ->orWhere('city','like','%'.$request['search'].'%')
            ->paginate(0);
        return view('admin.search.customers',compact('searchCustomers'));
    }
}
