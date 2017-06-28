<?php

namespace App\Http\Controllers\CLient;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;
use App\Packing;
use App\PhotoGraphy;
use App\City;
use App\Region;
USE App\Order;
USE App\Account;
use App\Store;
use App\PhotoOrder;
use App\Neighbor;
use Auth;

class OtherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getOtherNewOrder($locale){
        App::setLocale($locale);
        $packings = Packing::all();
        $photos = PhotoGraphy::all();
        $cities = City::whereIn('name',['Riyadh'])->get();
        $regions = Region::where('country','SA')->get();
        $account = Account::where('user_id',Auth::user()->id)->first();
        $stores = Store::where('user_id',Auth::user()->id)->get();
        return view('client.others.new-order',compact('packings','photos','cities','regions','account','stores'));
    }

    public function postOtherNewOrder(Request $request, $locale){

        App::setLocale($locale);
        if($request['store'] == 'other') {
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

        $latest_order = Order::orderBy('number','=','desc')->latest()->pluck('number');
        $number = $latest_order[0];
        $_city = City::where('name','Riyadh')->pluck('code');
        $city_code = $_city[0];
        $newNum = $number+1;

        $order = new Order();

        $ref_number='FS'.Auth::user()->id.$city_code.'000'.$newNum;

        $order->number = $newNum;
        $order->ref_number = $ref_number;
        $order->user_id = Auth::user()->id;

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
                $order->s_neighbor_id = $s_neighbor->id;
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
        $order->photo_reference = $ref_number;
////////////////////////////
        $p_order = new PhotoOrder();

        $p_order->ref_number = $ref_number;
        $p_order->user_id = Auth::user()->id;
        $p_order->quantity = $request['photo_quantity'];
        $p_order->description = $request['photo_description'];
        if($request['PhotoAddress'] == 'same'){
            $p_order->address = 'same as store address';
        }
        else{
            $p_order->address = $request['photo_address'];
        }
//////////////////////
        if($order->save()){
            if($p_order->save()){
                $order->is_submit = 1;
                $order->update();
                return redirect()->route('client.orders',App::getLocale())->with('success','Order Placed successfully');
            }
        }
    }

    public function getOtherEditOrder($locale,$ref_number){
        App::setLocale($locale);
        $packings = Packing::all();
        $photos = PhotoGraphy::all();
        $cities = City::whereIn('name',['Riyadh'])->get();
        $regions = Region::where('country','SA')->get();
        $neighbors = Neighbor::where('city','Riyadh')->get();
        $account = Account::where('user_id',Auth::user()->id)->first();
        $stores = Store::where('user_id',Auth::user()->id)->get();
        $order = Order::where(['id'=>$ref_number,'user_id'=>Auth::user()->id])->first();

        $p_order = PhotoOrder::where(['ref_number'=>$order->ref_number,'user_id'=>Auth::user()->id])->first();
        if($order->status == 'pending'){
            return view('client.others.edit-order',compact('packings','photos','cities','regions','account','stores','neighbors','order','p_order'));
        }
        return abort(403,'Order already submitted');
    }


    public function postOtherEditOrder(Request $request, $locale,$ref_number){

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

        $order = Order::where(['ref_number'=>$ref_number,'user_id'=>Auth::user()->id])->first();

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
                $order->s_neighbor_id = $s_neighbor->id;
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
        $order->photo_reference = $ref_number;
////////////////////////////
        $p_order = PhotoOrder::where(['ref_number'=>$ref_number,'user_id'=>Auth::user()->id])->first();

        $p_order->quantity = $request['photo_quantity'];
        $p_order->description = $request['photo_description'];
        if($request['PhotoAddress'] == 'same' or $request['PhotoAddress'] == ""){
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
                return redirect()->route('client.orders',App::getLocale())->with('success','Order Updated successfully');
            }
        }
    }

}
