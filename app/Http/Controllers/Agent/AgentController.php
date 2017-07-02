<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;
use Auth;
use App\Order;
use App\Status;
use App\Transaction;
use App\AgentTransaction;
use App\Account;
use Illuminate\Support\Facades\DB;
class AgentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:agent');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($locale)
    {
        App::setLocale($locale);
        $agent = Auth::user();
        $myRegions = $agent->regions->pluck('id');
        if($agent->type == 'pick'){
            $newOrders = Order::orderBy('pick_date','asc')->whereIn('s_region',$myRegions)->whereIn('status',['confirm','returning'])->where(['is_submit'=>1,'pick_agent'=>null])->get();
            $pendingOrders = Order::orderBy('pick_date','asc')->whereIn('s_region',$myRegions)->where('status','picked')->where('pick_agent',Auth::user()->username)->get();
            $deliveredOrders = Order::orderBy('pick_date','asc')->whereIn('s_region',$myRegions)->whereIn('status',['delivered','return'])->where('pick_agent',Auth::user()->username)->get();
        }
        elseif($agent->type == 'delivery') {
            $newOrders = Order::orderBy('pick_date','asc')->whereIn('r_region',$myRegions)->where('is_delivery',1)->where(['is_submit'=>1,'deliver_agent'=>null])->where('status','prepared')->where('dlv_type','!=','fed')->get();
            $comingOrders = Order::orderBy('pick_date','asc')->whereIn('r_region',$myRegions)->whereIn('status',['picked','checking','confirm','preparing'])->get();
            $pendingOrders = Order::orderBy('pick_date','asc')->whereIn('r_region',$myRegions)->whereIn('status',['prepared','no-response','delay-weather','delay-customer','transit'])->where('dlv_type','!=','fed')->where('deliver_agent',Auth::user()->username)->where('r_city','Riyadh')->get();
            $deliveredOrders = Order::orderBy('pick_date','asc')->whereIn('r_region',$myRegions)->whereIn('status',['delivered','return'])->where('deliver_agent',Auth::user()->username)->where('dlv_type','!=','fed')->get();
        }
        return view('agent.index',compact('newOrders','pendingOrders','deliveredOrders','comingOrders'));
    }

    public function getNewOrders(){
        $agent = Auth::user();
        $myRegions = $agent->regions->pluck('id');
        if($agent->type == 'pick'){
            $newOrders = Order::orderBy('pick_date','asc')->whereIn('s_region',$myRegions)->whereIn('status',['confirm','returning'])->where('is_submit',1)->get();
            }
        elseif($agent->type == 'delivery') {
            $newOrders = Order::orderBy('pick_date','asc')->where('dlv_type','!=','fed')->whereIn('r_region',$myRegions)->where('is_delivery',1)->where('is_submit',1)->where('status','prepared')->get();
        }
        return view('agent.index',compact('newOrders'));
    }

    public function getOrder($ref_number, $locale){
        App::setLocale($locale);
        $order = Order::where('ref_number',$ref_number)->first();
        if(Auth::user()->type == 'pick'){
            $order->pick_agent = Auth::user()->username;
            if($order->dlv_type == 'fed'){
                $order->deliver_agent = Auth::user()->username;
            }
        }
        elseif(Auth::user()->type == 'delivery'){
            $order->deliver_agent = Auth::user()->username;
        }
        if($order->update()){
            return redirect()->route('agent.order',array($ref_number,$locale));
        }
    }

    public function order($ref_number, $locale){
        App::setLocale($locale);
        $ordr = Order::where('ref_number',$ref_number)->first();
        if(Auth::user()->type == 'pick'){
            if($ordr->dlv_type == 'fed'){
                $statuses = Status::whereIn('status_by',['pick_agent','delivery_agent'])->get();
            }
            else{
                $statuses = Status::where('status_by','pick_agent')->get();
            }
            $order = Order::where('ref_number',$ref_number)->where('status','!=','in-faststar')->where('pick_agent',Auth::user()->username)->first();
        }
        elseif(Auth::user()->type == 'delivery'){
            $statuses = Status::where('status_by','delivery_agent')->get();
            $order = Order::where('ref_number',$ref_number)->where('deliver_agent',Auth::user()->username)->first();
        }
        if($order){
            return view('agent.order',compact('order','statuses'));
        }
        return abort(402,'Order not exists');
    }

    public function changeStatus(Request $request, $ref_number, $locale){
        App::setLocale($locale);
        $this->validate($request, array(
            'status'=>'required'
        ));
        $order = Order::where('ref_number',$ref_number)->first();
        $agent = Auth::user();
        $account = Account::where('user_id', $order->user_id)->first();
//Condition start
        if($order->pick_agent != null  and $agent->type == 'pick'){
            if($order->pick_agent != $agent->username){
                return abort(402,'Order got up by another agent');
            }
        }
        elseif($order->deliver_agent != null  and $agent->type == 'delivery'){
            if($order->deliver_agent != $agent->username){
                return abort(402,'Order got is picked up by another agent');
            }
        }

//end
//condition start
        if(($order->status == 'return') or ($order->status == 'delivered') ){
            return abort(402,'Order already processed');
        }
        elseif($request['status'] == 'delivered'){
            if($order->status == 'delivered'){
                return abort(402,'Already Delivered');
            }
            else{
                if($order->is_cod == 1){
                    if($account){
                        $trans = new Transaction();
                        $trans->name = 'order cah on delivery';
                        $trans->user_id = $order->user_id;
                        $trans->type = 'credit';
                        $trans->amount = $order->return_amount;
                        $trans->balance_before = $account->wallet_amount;
                        $trans->balance = $account->wallet_amount + $trans->amount;
                        $trans->reference = $order->ref_number;
                        DB::transaction(function() use ($trans, $account) {
                            if($trans->save()){
                                $account->wallet_amount = $account->wallet_amount + $trans->amount;
                                $account->update();
                            }
                        });

                    }

                    $agent_trans = new AgentTransaction();
                    $agent_trans->agent_id = Auth::user()->id;
                    $agent_trans->type = 'credit';
                    $agent_trans->amount = $order->cod_amount;
                    $agent_trans->balance_before = $agent->wallet_amount;
                    $agent_trans->balance = $agent->wallet_amount + $order->cod_amount;
                    $agent_trans->name = 'cod';
                    $agent_trans->reference = $order->ref_number;
                    DB::transaction(function() use ($agent_trans, $agent) {
                        if($agent_trans->save()){
                            $agent->wallet_amount = $agent->wallet_amount + $agent_trans->amount;
                            $agent->update();
                        }
                    });

                }
            }
        }
        elseif($request['status'] == 'return'){
            if($order->payment_id = 1){
                if($account){
                    $trans = new Transaction();
                    $trans->name = 'Delivery Charges Returned';
                    $trans->user_id = $order->user_id;
                    $trans->type = 'credit';
                    $trans->amount = $order->total_freight;
                    $trans->balance_before = $account->wallet_amount;
                    $trans->balance = $account->wallet_amount + $trans->amount;
                    $trans->reference = $order->ref_number;

                    DB::transaction(function() use ($trans,$account,$order) {
                        if($trans->save()){
                            $account->wallet_amount = $account->wallet_amount + $trans->amount;
                            if($order->is_in_package == 1){
                                $account->package_inside_quantity =  $account->package_inside_quantity+1;
                            }
                            elseif($order->is_out_package ==1){
                                $account->package_outside_quantity =  $account->package_outside_quantity+1;
                            }
                            else{
                                //
                            }
                            $account->update();
                        }
                    });
                }

            }
        }
        elseif($request['status'] == 'picked'){
            //Take cash from store
            if($order->status != 'confirm'){
                return abort(402,'Order Already Picked Up');
            }
            else{
                if($order->payment_id == 2 and $order->is_submit == 1){
                    $agent_trans = new AgentTransaction();
                    $agent_trans->agent_id = Auth::user()->id;
                    $agent_trans->type = 'credit';
                    $agent_trans->amount = $order->total_freight;
                    $agent_trans->balance_before = $agent->wallet_amount;
                    $agent_trans->balance = $agent->wallet_amount + $order->total_freight;
                    $agent_trans->name = 'Cash From Store';
                    $agent_trans->reference = $order->ref_number;

                    DB::transaction(function() use ($agent_trans,$agent) {
                        if($agent_trans->save()){
                            $agent->wallet_amount = $agent->wallet_amount  + $agent_trans->amount;
                            $agent->update();
                        }
                    });

                }
            }
        }
        elseif($request['status'] == 'pending'){
            if($order->status != 'pending'){
                return abort(402,'Order picked up already');
            }
        }
        elseif(($request['status'] == 'in-faststar') or ($request['status'] == 'preparing' or ($request['status'] == 'prepared') or ($request['status'] == 'transit'))){
            if(($order->status == 'delivered') or ($order->status == 'no-response') or ($order->status == 'return')){
                return abort(402,'Order already processed');
            }
        }
//end
        $order->status = $request['status'];
//condition start
        if($order->update()){
            return redirect()->route('agent.dashboard',array($locale));
        }
    }

    public function pendingOrders($locale){
        App::setLocale($locale);
        $agent = Auth::user();
        $myRegions = $agent->regions->pluck('id');
        if(Auth::user()->type == 'pick'){
            $pendingOrders = Order::orderBy('pick_date','asc')->whereIn('s_region',$myRegions)->whereIn('status',['confirm','returning'])->where('pick_agent',Auth::user()->username)->get();
        }
        elseif(Auth::user()->type == 'delivery'){
            $pendingOrders = Order::orderBy('pick_date','asc')->where('dlv_type','!=','fed')->whereIn('r_region',$myRegions)->whereIn('status',['prepared','no-response','transit','delay-weather','delay-customer'])->where('deliver_agent',Auth::user()->username)->get();
        }
        return view('agent.pending-orders',compact('pendingOrders'));
    }

    public function comingOrders($locale){
        App::setLocale($locale);
        $agent = Auth::user();
        $myRegions = $agent->regions->pluck('id');
        if(Auth::user()->type == 'delivery'){
            $comingOrders = Order::orderBy('pick_date','asc')->where('dlv_type','!=','fed')->whereIn('r_region',$myRegions)->whereIn('status',['picked','checking','confirm','preparing'])->get();
        }
        return view('agent.coming-orders',compact('comingOrders'));
    }

    public function completedOrders($locale){
        App::setLocale($locale);
        $agent = Auth::user();
        $myRegions = $agent->regions->pluck('id');
        if(Auth::user()->type == 'pick'){
            $completedOrders = Order::orderBy('pick_date','asc')->whereIn('s_region',$myRegions)->whereIn('status',['delivered','return'])->where('pick_agent',Auth::user()->username)->get();
        }
        elseif(Auth::user()->type == 'delivery'){
            $completedOrders = Order::orderBy('pick_date','asc')->where('dlv_type','!=','fed')->whereIn('r_region',$myRegions)->whereIn('status',['delivered','return'])->where('deliver_agent',Auth::user()->username)->get();

        }
        return view('agent.completed-orders',compact('completedOrders'));

    }

    public function cashList($locale){
        App::setLocale($locale);
        $transactions = AgentTransaction::where('agent_id',Auth::user()->id)->get();
        return view('agent.cash-list',compact('transactions'));
    }

    public function pickReport($locale){
        App::setLocale($locale);

        $agent = Auth::user();
        $myRegions = $agent->regions->pluck('id');
        $todayOrders = Order::where('pick_date',date('Y-m-d'))->whereIn('status',['confirm','returning'])->where('pick_agent',Auth::user()->username)->get();
        $allOrders = Order::where(['pick_agent'=>Auth::user()->username])->paginate(50);
        return view('agent.pick-report',compact('todayOrders','allOrders'));
    }
    public function deliveryReport($locale){
        App::setLocale($locale);
        $todayOrders = Order::where(['deliver_agent'=>Auth::user()->username,'pick_date'=>date('Y-m-d'),'status'=>'prepared'])->get();
        $allOrders = Order::where(['deliver_agent'=>Auth::user()->username])->paginate(50);
        return view('agent.delivery-report',compact('todayOrders','allOrders'));
    }
}
