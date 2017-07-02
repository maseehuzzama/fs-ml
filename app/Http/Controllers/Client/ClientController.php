<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;
use App\Packing;
use App\PhotoGraphy;
use App\City;
use App\Region;
use App\Neighbor;
use App\State;
USE App\Order;
USE App\Account;
USE App\Transaction;
USE App\Package;
use App\PackageRequest;
use App\Store;
use App\Price;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',(['except'=>'search-order']));
    }

    public function searchOrder(Request $request,$locale){
        App::setLocale($locale);
        $this->validate($request,[
            'search'=>'required',
        ]);
        $order = Order::where('ref_number',$request['search'])->first();
        return view('client.order-show',compact('order'));
    }

    public function index($locale)
    {
        App::setLocale($locale);
        $account = Account::where('user_id',Auth::user()->id)->first();
        $stores = Store::where('user_id',Auth::user()->id)->get();
        $states = State::where('country','SA')->get();
        $cities = City::whereIn('name',['Riyadh'])->get();
        $regions = Region::where('country','SA')->get();
        $transactions = Transaction::orderBy('created_at','desc')->where('user_id',Auth::user()->id)->get();
        return view('client.info',compact('account','stores','states','cities','regions','transactions'));
    }

    public function getNewOrder($locale){
        App::setLocale($locale);
        $packings = Packing::all();
        $photos = PhotoGraphy::all();
        $cities = City::whereIn('name',['Riyadh'])->get();
        $r_cities = City::whereIn('country',['SA'])->get();
        $account = Account::where('user_id',Auth::user()->id)->first();
        $stores = Store::where('user_id',Auth::user()->id)->get();
        $neighbors = Neighbor::where('city','Riyadh')->get();
        $r_list  = App\Receiver::where(['user_id'=>Auth::user()->id])->get();
        return view('client.new-order',compact('packings','photos','cities','r_cities','regions','account','stores','neighbors','r_list'));
    }
    public function postNewOrder(Request $request, $locale){
        App::setLocale($locale);
        if($request['store'] == 'other' or $request['store'] == "") {
            $this->validate($request, array(
                'store_name' => 'required',
                'store_country' => 'required',
                'store_city' => 'required',
                'store_neighbour' => 'required',
                'store_street' => 'required',
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
                    'pick_date' => 'date|after:yesterday',
                    'contains' => 'required',
                    'quantity' => 'required',
                    'weight' => 'required',
                ));
            }
            else{
                $this->validate($request, array(
                    'pick_date' => 'date|after:yesterday',
                    'contains' => 'required',
                    'quantity' => 'required',
                    'weight' => 'required',
                ));
            }

        }

        $latest_order = Order::orderBy('number','=','desc')->latest()->pluck('number');
        $number = $latest_order[0];
        $_city = City::where('name','Riyadh')->pluck('code');
        $city_code = $_city[0];
        $newNum = $number+1;
        $ref_number='FS'.Auth::user()->id.$city_code.'000'.$newNum;

        $r_neighbor = Neighbor::find($request['receiver_neighbour']);


        $order = new Order();
        $order->user_id= Auth::user()->id;
        $order->number = $newNum;
        $order->ref_number = $ref_number;

        //
        $store = Store::find($request['store']);

        if($request['store'] == 'other' or $request['store'] == ""){
            $s_neighbor = Neighbor::find($request['store_neighbour']);
            $order->store_name= $request['store_name'];
            $order->s_country= $request['store_country'];
            $order->s_city = $request['store_city'];
            $order->s_region = $s_neighbor->region;
            $order->s_neighbor_id = $request['store_neighbour'];
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
                $order->s_neighbor_id = $request['store_neighbour'];
                $order->s_neighbor = $s_neighbor->name;
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
                $order->s_neighbor_id = $s_neighbor_id;
                $order->s_neighbor = $s_neighbor->name;
                $order->s_street = $store->street;
                $order->s_phone = $store->phone;
            }
        }
        /////////
        $order->pick_date = $request['pick_date'];
        $order->pick_time = $request['pick_time'];
        /////////
        $order->is_delivery = 1;
        if($request['r_type'] == 'n' or $request['r_type'] == '' or $request['r_search'] == ''){
            $order->r_country= $request['receiver_country'];
            $order->r_city = $request['receiver_city'];
            $order->r_region = $r_neighbor->region;
            $order->r_name = $request['receiver_name'];
            $order->r_neighbor_id = $request['receiver_neighbour'];
            $order->r_neighbor = $r_neighbor->name;
            $order->r_other_neighbor = $request['r_other_neighbor'];
            $order->r_street = $request['receiver_street'];
            $order->r_pincode = $request['receiver_pincode'];
            $order->r_phone = $request['receiver_phone'];

            $ex_rec = App\Receiver::where(['name'=>$request['receiver_name'],'phone'=>$request['receiver_phone']])->first();

            if(!$ex_rec){
                $new_rec = new App\Receiver();
                $new_rec->user_id = Auth::user()->id;
                $new_rec->name = $request['receiver_name'];
                $new_rec->country = $request['receiver_country'];
                $new_rec->city = $request['receiver_city'];
                $new_rec->street = $request['receiver_street'];
                $new_rec->phone = $request['receiver_phone'];
                @$new_rec->region = $r_neighbor->region;
                if($request['receiver_neighbour'] == 0){
                    $new_rec->neighbor = $request['r_other_neighbor'];
                    $new_rec->neighbor_id = 0;
                }
                else{
                    $new_rec->neighbor = $r_neighbor->name;
                    $new_rec->neighbor_id = $request['receiver_neighbour'];

                }
                return $new_rec;
            }
        }
        else{
            $rec = App\Receiver::find($request['r_search']);
            $order->r_country= $rec->country;
            $order->r_city = $rec->city;
            $order->r_region = $rec->region;
            $order->r_name = $rec->name;
            $order->r_neighbor_id = $rec->neighbor_id;
            $order->r_neighbor = $rec->neighbor;
            $order->r_street = $rec->street;
            $order->r_phone = $rec->phone;
        }
        //////////

        $order->contains = $request['contains'];
        $order->quantity = $request['quantity'];
        $order->weight = $request['weight'];


        if ($request['insurance'] == true) {
            $order->is_insurance = 1;
        }
        else{
            $order->is_insurance = 0;
        }


        $account = Account::where('user_id',Auth::user()->id)->first();

        if($request['is_packing'] == true) {
            $order->is_packing = 1;
            @$order->packing_id = $request['packing'];
            @$order->packing_color = $request['packing_color'];
            @$packing = Packing::find($request['packing']);
            if($account){
                if(($order->s_city == 'Riyadh') && ($order->r_city == 'Riyadh')){
                    if(($account->package_inside == 'PI500') and ($account->package_inside_quantity > 0 )){
                        @$order->packing_amount = 0;
                    }
                    else{
                        @$order->packing_amount = $packing->packing_price;
                    }
                }
                else{
                    if(($account->package_outside == 'PO500' and $account->package_outside_quantity > 0 )){
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


        if($order->save()){

            return redirect()->route('client.select-delivery-type',array($locale,$ref_number));
        }
        return abort(403,'Try Again!');
    }

    public function getEditOrder($locale,$id){
        App::setLocale($locale);
        $order = Order::where(['id'=>$id,'user_id'=>Auth::user()->id])->first();
        if(($order->is_submit) == 0  or $order->status == 'pending'){
            $packings = Packing::all();
            $photos = PhotoGraphy::all();
            $cities = City::whereIn('name',['Riyadh'])->get();
            $r_cities = City::whereIn('country',['SA'])->get();
            $regions = Region::where('country','SA')->get();
            $neighbors = Neighbor::where('city','Riyadh')->get();
            $account = Account::where('user_id',Auth::user()->id)->first();
            $stores = Store::where('user_id',Auth::user()->id)->get();
            $se_regions = Region::where('city',$order->s_city)->get();
            $rr_regions = Region::where('city',$order->r_city)->get();
            $se_neighbors = Neighbor::where('city',$order->s_city)->get();
            $rr_neighbors = Neighbor::where('city',$order->r_city)->get();
            return view('client.edit-order',compact('order','packings','photos','cities','r_cities','regions','account','stores','se_regions','rr_regions','se_neighbors','rr_neighbors','neighbors'));
        }
        return abort(403,'Kindly Submit a ticket to edit this order');
    }

    public function postEditOrder(Request $request, $locale, $id){
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

        $account = Account::where('user_id',Auth::user()->id)->first();
        $order = Order::where(['id'=>$id, 'user_id'=>Auth::user()->id])->first();
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
                $order->s_neighbor_id = $request['store_neighbour'];
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
            $order->r_neighbor = $r_neighbor->name;
            $order->r_neighbor_id = $r_neighbor->id;
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
                return redirect()->route('client.select-delivery-type',array($locale,$order->ref_number));
            }
            return abort(403,'Try Again!');
        }
        return abort(403,'No Match');

    }

    public function getSelectDelivery($locale,$ref){
        App::setLocale($locale);
        $order = Order::where(['user_id'=>Auth::user()->id, 'ref_number'=>$ref])->orWhere(['user_id'=>Auth::user()->id, 'id'=>$ref])->first();
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
        $order = Order::where(['user_id'=>Auth::user()->id, 'ref_number'=>$ref])->orWhere(['user_id'=>Auth::user()->id, 'id'=>$ref])->first();
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

    public function getSubmitOrder($locale,$ref){
        App::setLocale($locale);
        $order = Order::where(['user_id'=>Auth::user()->id, 'ref_number'=>$ref])->orWhere(['user_id'=>Auth::user()->id, 'id'=>$ref])->first();
        $account = Account::where('user_id',Auth::user()->id)->first();
        $trans = Transaction::where(['user_id'=>Auth::user()->id,'order_id'=>$order->id, 'reference'=>$order->ref_number,'type'=>'debit'])->first();
        if($order){
            if($order->is_submit == 0 or $order->status == 'pending') {
                return view('client.submit-order', compact('order','account','trans'));
            }
        }
        else{
            return abort(403,'Order already submitted');
        }
        return abort(403,'Order does not match with user');
    }
    public function postSubmitOrder(Request $request, $locale,$id){
        App::setLocale($locale);
        $this->validate($request, array(
            'payment_mode'=>'required',
        ));
        $account = Account::where(['user_id'=>Auth::user()->id])->first();
        $order = Order::where(['id'=>$id,'user_id'=>Auth::user()->id])->first();

        if($order) {
            DB::transaction(function () use ($order, $account, $request,$id) {


                if ($account) {
                    //New Condition
                    if($order->dlv_type == 'fd'){
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
                                $new_trans->user_id = Auth::user()->id;
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
                                $new_trans->user_id = Auth::user()->id;
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
        return redirect()->route('client.orders', App::getLocale());

    }


    public function getCreateAccount($locale){
        App::setLocale($locale);
        $states = State::where('country','SA')->get();
        $cities = City::where('name','Riyadh')->get();
        return view('client.create-account',compact('states','cities'));
    }

    public function postCreateAccount(Request $request, $locale){
        $this->validate($request,array(
            'name'=>'required',
            'activity'=>'required',
            'country'=>'required',
            'city'=>'required',
            'phone'=>'required|max:10|min:10',
            'street'=>'required',
            'bank_name'=>'required',
            'fullname'=>'required',
            'iban'=>'required|max:22|min:22',
        ));
        @$account = Account::where('user_id',Auth::user()->id)->first();
        if(!$account){
            $account = new Account();
            $account->user_id = Auth::user()->id;
            $account->fullname = $request['fullname'];
            $account->iban = 'SA'.$request['iban'];
            $account->bank_name = $request['bank_name'];
            $account->wallet = 1;
            $account->wallet_amount = 0;
            /*store*/
            $neighbor = Neighbor::find($request['neighbourhood']);

            $store = new Store();
            $store->name = $request['name'];
            $store->country_iso = $request['country'];
            $store->phone = $request['phone'];
            $store->city = $request['city'];
            $store->street = $request['street'];
            $store->region_id = $neighbor->region;
            $store->neighbor_id = $request['neighbourhood'];
            $store->user_id = Auth::user()->id;
            if($account->save()){
                if($store->save()){
                    return redirect()->route('client',App::getLocale());
                }
                return abort(403,'Something Went Wrong with store details. Try Again');
            }
            return abort(403,'Something Went Wrong. Try Again');
        }
        return abort(403,'Something Went Wrong. Try Again');
    }

    public function getEditAccount($locale){
        App::setLocale($locale);
        $states = State::where('country','SA')->get();
        $cities = City::whereIn('name',['Riyadh','Jeddah'])->get();
        $account = Account::where('user_id',Auth::user()->id)->first();
        return view('client.edit-account',compact('states','cities','account'));
    }

    public function postEditAccount(Request $request, $locale){
        App::setLocale($locale);
        $this->validate($request,array(
            'bank_name'=>'required',
            'fullname'=>'required',
            'phone'=>'max:10|min:10',
            'iban'=>'required|max:22|min:22',
        ));

        $account = Account::where('user_id',Auth::user()->id)->first();
        $account->bank_name = $request['bank_name'];
        $account->iban = 'SA'.$request['iban'];
        $account->fullname = $request['fullname'];
        if($account->update()){
            return redirect()->route('client',App::getLocale());
        }
    }

    public function getPackageRequest($locale){
        App::setLocale($locale);
        $account = Account::where('user_id',Auth::user()->id)->first();
        $packages = Package::all();
        return view('client.package-request',compact('packages','account'));
    }

    public function postPackageRequest(Request $request, $locale){
        App::setLocale($locale);
        $this->validate($request,array(
            'package'=>'required',
        ));
        $package = Package::find($request['package']);
        $account = Account::where(['user_id'=>Auth::user()->id])->first();

        if($package->type == 'inside'){
            if($account->package_inside_quantity != 0){
                return abort(403,'You can take new package after using old one');
            }
        }
        else{
            if($account->package_outside_quantity != 0){
                return abort(403,'You can take new package after using old one');
            }
        }

        $p_r = new PackageRequest();
        $p_r->user_id = Auth::user()->id;
        $ref_number = 'fs'.Auth::user()->id.time();
        $p_r->ref_number = $ref_number;
        $p_r->account_id = $request['account_id'];
        $p_r->package_code = $package->code;
        $p_r->payment_mode = $request['payment_mode'];
        $p_r->amount = $package->amount;

        DB::transaction(function() use ($request,$account,$package , $p_r,$locale,$ref_number) {

            if ($request['payment_mode'] == 'tfa') {
                if ($account->wallet_amount < $package->amount or $account->wallet_amount == 0) {
                    return abort(403, 'Not Enough Amount');
                } else {
                    $account->wallet_amount = $account->wallet_amount - $package->amount;
                    $trans = new Transaction();
                    $trans->name = 'Package Request -' . $package->code;
                    $trans->type = 'debit';
                    $trans->amount = $package->amount;
                    $trans->account_id = $account->id;
                    $trans->user_id = Auth::user()->id;
                    $trans->reference = $package->code . 'T' . time();
                    $trans->side = 'client';
                    $trans->balance_before = $account->wallet_amount;
                    $trans->balance = $account->wallet_amount - $package->amount;
                    if ($package->type == 'inside') {
                        $account->package_inside = $package->code;
                        $account->package_inside_rates = $package->rates;
                        $account->package_inside_quantity = $account->package_inside_quantity + $package->quantity;
                        $account->package_inside_validity = Carbon::today()->addDays(30);
                    } elseif ($package->type == 'outside') {
                        $account->package_outside = $package->code;
                        $account->package_outside_rates = $package->rates;
                        $account->package_outside_quantity = $account->package_outside_quantity + $package->quantity;
                        $account->package_outside_validity = Carbon::today()->addDays(30);
                    }
                    if ($account->update()) {
                        if ($trans->save()) {
                            $p_r->active = 1;
                            $p_r->paid = 1;
                        }
                    }
                   $p_r->save();
                }
            } else {
                $p_r->active = 0;
                $p_r->paid = 0;
                $p_r->save();
            }
        });
        if($request['payment_mode'] == 'tfa'){
            return redirect()->route('client', App::getLocale());
        }
        else{
            return redirect()->route('client.package.invoice', array($locale, $ref_number))->with('success', 'Successful');
        }
        return abort(403,'Something Went Wrong. Try Again! Go Back');
    }

    public function getPackageInvoice($locale,$ref_num){
        App::setLocale($locale);
        $p_r = PackageRequest::where(['user_id'=>Auth::user()->id,'ref_number'=>$ref_num])->first();
        if($p_r->user_id === Auth::user()->id){
            $package = Package::where('code',$p_r->package_code)->first();
            $account = Account::where('user_id',Auth::user()->id)->first();
            return view('invoices.package-request',compact('p_r','package','account'));
        }
        return abort(403,'You are not a legal man/woman');
    }

    public function getCreateStore($locale){
        App::setLocale($locale);
        $states = State::where('country','SA')->get();
        $cities = City::whereIn('name',['Riyadh','Jeddah'])->get();
        $regions = City::where('country','SA')->get();
        return view('client.create-store',compact('states','cities','regions'));

    }

    public function postCreateStore(Request $request, $locale){
        App::setLocale($locale);
        $this->validate($request,array(
            'name'=>'required',
            'country'=>'required',
            'city'=>'required',
            'street'=>'required',
            'phone'=>'required',
            'neighbourhood'=>'required',
        ));

        $neighbor = Neighbor::find($request['neighbourhood']);

        $store = new Store();
        $store->name = $request['name'];
        $store->activity = $request['activity'];
        $store->country_iso = $request['country'];
        $store->city = $request['city'];
        $store->region_id = $neighbor->region;
        $store->street = $request['street'];
        $store->neighbor_id = $request['neighbourhood'];
        $store->phone = $request['phone'];
        $store->user_id = Auth::user()->id;
        if($store->save()){
            return redirect()->route('client',App::getLocale());
        }
        return abort(403,'Something Went Wrong. Try Again');
    }

    public function getEditStore($locale,$id){
        App::setLocale($locale);
        $store = Store::where(['id'=>$id,'user_id'=>Auth::user()->id])->first();
        if($store){
            $s_regions = Region::where('city',$store->city)->get();
            $states = State::where('country','SA')->get();
            $cities = City::whereIn('name',['Riyadh','Jeddah'])->get();
            $regions = Region::where('country','SA')->get();
            return view('client.edit-store', compact('store','states','cities','regions','s_regions'));
        }
        return abort(403, 'No Store exist');

    }

    public function postEditStore(Request $request, $locale,$id){
        App::setLocale($locale);
        $this->validate($request,array(
            'name'=>'required',
            'country'=>'required',
            'city'=>'required',
            'street'=>'required',
            'phone'=>'max:10|min:10',
            'neighbourhood'=>'required',
        ));

        $neighbor = Neighbor::find($request['neighbourhood']);
        $store = Store::find($id);
        if($store->user_id === Auth::user()->id){
            $store->name = $request['name'];
            $store->activity = $request['activity'];
            $store->country_iso = $request['country'];
            $store->city = $request['city'];
            $store->region_id = $neighbor->region;
            $store->street = $request['street'];
            $store->neighbor_id = $request['neighbourhood'];
            $store->phone = $request['phone'];
            if($store->update()){
                return redirect()->route('client',App::getLocale());
            }
            return abort(403,'Something Went Wrong. Try Again');
        }
        return abort(403, "You don't have permission.");

    }

    public function deleteStore($locale,$id){
        App::setlocale($locale);
        $store = Store::find($id);
        if($store->user_id === Auth::user()->id){
            if($store->delete()){
                return redirect()->route('client',App::getLocale());
            }
            return abort(403,'Something Went Wrong. Try Again');
        }
        return abort(403, "You don't have permission.");
    }

    public function orders($locale){
        App::setLocale($locale);

        $pendingOrders = Order::where([['user_id', '=', Auth::user()->id], ['is_submit', '=', 1], ['is_photo', '=', 0],])
            ->whereNotIn('status',['delivered','return','done'])
            ->get();
        $deliveredOrders = Order::where([['user_id', '=', Auth::user()->id], ['is_photo', '=', 0]])
            ->whereIn('status',['delivered','return'])
            ->get();

        $photoOrders = Order::where([
            ['user_id', '=', Auth::user()->id],
            ['is_photo', '=', 1]
        ])->get();

        return view('client.orders',compact('pendingOrders','deliveredOrders','photoOrders'));
    }

    /*public function getNewOrder($locale,$ref_number){
        App::setLocale($locale);
        $order = Order::where(['ref_number'=>$ref_number,'user_id'=>Auth::user()->id])->first();
        if($order){
            $packings = Packing::all();
            $photos = PhotoGraphy::all();
            $cities = City::whereIn('name',['Riyadh','Jeddah'])->get();
            $account = Account::where('user_id',Auth::user()->id)->first();
            if(($order->is_submit == 0 or $order->status == 'pending')){
                return view('client.new-order',compact('order','packings','photos','cities','account'));
            }
            else{
                return abort(403,'Order already submitted');
            }
        }
        return abort(403,'Order does not match with user');
    }
    public function postNewOrder(Request $request,$locale,$ref_number){
        App::setLocale($locale);
        $this->validate($request, array(
            'contains' => 'required',
            'quantity' => 'required',
            'weight' => 'required',
        ));
        $account = Account::where('user_id',Auth::user()->id)->first();
        $order = Order::where(['ref_number'=>$ref_number,'user_id'=>Auth::user()->id])->first();
        if($order) {
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
                @$order->packing_amount = $packing->packing_price;
            }
            else{
                $order->is_packing = 0;
                $order->packing_id = null;
                $order->packing_color = null;
                $order->packing_amount = 0;
            }
/*
            if ($request['storage'] == 1) {
                $order->is_storage = 1;
                $order->storage_amount = 25;
            }


            if($request['photo'] == true){
                $order->is_photo = 1;
                $order->photo_description = $request['photo_description'];
                $photo = AddOnServices::where('name', 'photography')->first();
                $order->photo_amount = $photo->price;
            }
            else{
                $order->is_photo = 0;
                $order->photo_description = null;
                $order->photo_amount = 0;
            }

            $order->spl_req = $request['spl_req'];


            if($account == true){
                if (($order->s_city == 'Riyadh') && ($order->r_city == 'Riyadh')) {
                    $package = Package::where('code', $account->package_inside)->first();
                    if ($account->package_inside_quantity > 0) {
                        $dlv_chrgs = $package->rates;
                    } elseif ($account->package_inside_quantity === 0) {

                        $price_var = Price::where('service_code','DI')->first();
                        $dlv_chrgs = $price_var->price;
                    }
                    $order->dlv_chrgs = $dlv_chrgs;
                }
                elseif (($order->s_city !== 'Riyadh') or ($order->r_city !== 'Riyadh')) {
                    $package = Package::where('code', $account->package_outside)->first();
                    if ($account->package_outside_quantity > 0) {
                        $dlv_chrgs = $package->rates;
                    }
                    elseif ($account->package_outside_quantity == 0) {
                        $price_var = Price::where('service_code','DO')->first();
                        $dlv_chrgs = $price_var->price;
                    }
                    $order->dlv_chrgs = $dlv_chrgs;
                }
            }
            else{
                if(($order->s_city == 'Riyadh') && ($order->r_city == 'Riyadh')){
                    $price_var = Price::where('service_code','PI')->first();
                    $dlv_chrgs = $price_var->price;
                }
                else{
                    $price_var = Price::where('service_code','PO')->first();
                    $dlv_chrgs = $price_var->price;
                }
            }
            $order->total_freight = $freight =   $order->packing_amount + $dlv_chrgs;

            if ($order->save()) {
                return redirect()->route('client.submit-order', array(App::getLocale(),$ref_number));
            }
        }
        return abort(403,'Order already submitted');
    }

    public function getEditOrder($locale,$ref_number){
        App::setLocale($locale);
        $order = Order::where(['ref_number'=>$ref_number,'user_id'=>Auth::user()->id])->first();
        if(($order->is_submit) == 0  or $order->status == 'pending'){
            $packings = Packing::all();
            $photos = PhotoGraphy::all();
            $cities = City::whereIn('name',['Riyadh','Jeddah'])->get();
            $account = Account::where('user_id',Auth::user()->id)->first();
            if($order->status == 'pending'){
                return view('client.edit-order',compact('order','packings','photos','cities','account'));
            }
            return abort(403,'Order already submitted');
        }
        return abort(403,'Order does not match with user');
    }


    public function postEditOrder(Request $request,$locale,$ref_number){
        App::setLocale($locale);
        $this->validate($request, array(
            'contains' => 'required',
            'quantity' => 'required',
            'weight' => 'required',
        ));
        $account = Account::where('user_id',Auth::user()->id)->first();
        $order = Order::where(['ref_number'=>$ref_number,'user_id'=>Auth::user()->id])->first();
        if(($order->is_submit) === 0  or $order->status == 'pending') {
            $order->contains = $request['contains'];
            $order->quantity = $request['quantity'];
            $order->weight = $request['weight'];

            if($request['is_packing'] == true) {
                $order->is_packing = 1;
                @$order->packing_id = $request['packing'];
                @$order->packing_color = $request['packing_color'];
                @$packing = Packing::find($request['packing']);
                @$order->packing_amount = $packing->packing_price;
            }
            else{
                $order->is_packing = 0;
                $order->packing_id = null;
                $order->packing_color = null;
                $order->packing_amount = 0;
            }


            if ($request['insurance'] == true) {
                $order->is_insurance = 1;
                $order->insurance_amount = $request['shipment_amount']*10/100;
            }
            else{
                $order->is_insurance = 0;
                $order->insurance_amount = 0;
            }

            /*
                        if ($request['storage'] == 1) {
                            $order->is_storage = 1;
                            $order->storage_amount = 25;
                        }
            */

    /*if($request['photo'] == true){
        $order->is_photo = 1;
        $order->photo_description = $request['photo_description'];
        $photo = AddOnServices::where('name', 'photography')->first();
        $order->photo_amount = $photo->price;
    }
    else{
        $order->is_photo = 0;
        $order->photo_description = null;
        $order->photo_amount = 0;
    }

    $order->spl_req = $request['spl_req'];

    if($account == true){
        if (($order->s_city == 'Riyadh') && ($order->r_city == 'Riyadh')) {
            $package = Package::where('code', $account->package_inside)->first();
            if ($account->package_inside_quantity > 0) {
                $dlv_chrgs = $package->rates;
            } elseif ($account->package_inside_quantity === 0) {

                $price_var = Price::where('service_code','DI')->first();
                $dlv_chrgs = $price_var->price;
            }
            $order->dlv_chrgs = $dlv_chrgs;
        }
        elseif (($order->s_city !== 'Riyadh') or ($order->r_city !== 'Riyadh')) {
            $package = Package::where('code', $account->package_outside)->first();
            if ($account->package_outside_quantity > 0) {
                $dlv_chrgs = $package->rates;
            }
            elseif ($account->package_outside_quantity == 0) {
                $price_var = Price::where('service_code','DO')->first();
                $dlv_chrgs = $price_var->price;
            }
            $order->dlv_chrgs = $dlv_chrgs;
        }
    }
    else{
        if(($order->s_city == 'Riyadh') && ($order->r_city == 'Riyadh')){
            $price_var = Price::where('service_code','PI')->first();
            $dlv_chrgs = $price_var->price;
        }
        else{
            $price_var = Price::where('service_code','PO')->first();
            $dlv_chrgs = $price_var->price;
        }
    }
    $order->total_freight = $freight =    $order->packing_amount + $dlv_chrgs;
    if ($order->update()) {
        return redirect()->route('client.submit-order', array(App::getLocale(),$ref_number));
    }
}
return abort(403,'Order already submitted');
}

    */
}
