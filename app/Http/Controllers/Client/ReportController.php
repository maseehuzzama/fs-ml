<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use Auth;
use App\Status;
use App;

class ReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getOrdersByDate($locale){
        App::setLocale($locale);
        $fromDate = date('Y-m-d' . ' 00:00:00', time()); //need a space after dates.
        $toDate = date('Y-m-d' . ' 23:59:59', time());
        $orders = Order::whereBetween('created_at',[$fromDate,$toDate])->where('user_id',Auth::user()->id)->get();

        return view('client.reports.orders-by-date',compact('orders'));
    }
    public function postOrdersByDate(Request $request, $locale){
        App::setLocale($locale);
        $fromDate = date($request['from'] . ' 00:00:00', time()); //need a space after dates.
        $toDate = date($request['to'] . ' 23:59:59', time());
        $orders = Order::whereBetween('created_at',[$fromDate,$toDate])->where('user_id',Auth::user()->id)->get();
        $from = $request['from'];
        $to = $request['to'];
        return view('client.reports.orders-by-date',compact('orders','from','to'));
    }
    public function getOrdersByStatus($locale){
        App::setLocale($locale);
        $orders = Order::orderBy('created_at','desc')->where('user_id',Auth::user()->id)->get();
        $statuses = Status::all();
        return view('client.reports.orders-by-status',compact('orders','statuses'));
    }
    public function postOrdersByStatus(Request $request, $locale){
        App::setLocale($locale);
        $orders = Order::orderBy('created_at','desc')->where(['status'=>$request['status'],'user_id'=>Auth::user()->id])->get();
        $statuses = Status::all();
        $stats = $request['status'];
        return view('client.reports.orders-by-status',compact('orders','statuses','stats'));
    }
}
