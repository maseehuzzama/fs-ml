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
use Carbon\Carbon;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function packageRequests($locale){
        App::getLocale($locale);
        $newPackageRequests = PackageRequest::where('active',0)->get();
        $packageRequests = PackageRequest::where('active',1)->get();
        return view('admin.package.package-requests',compact('newPackageRequests','packageRequests'));
    }
    public function activePackageRequest(Request $request,$user_id,$id,$ref,$locale){
        App::getLocale($locale);
        $p_r = PackageRequest::find($id);
        $package = Package::where('code',$p_r->package_code)->first();
        $account = Account::where(['user_id'=>$user_id])->first();
        if($package->type == 'inside') {
            $account->package_inside = $package->code;
            $account->package_inside_rates = $package->rates;
            $account->package_inside_quantity = $account->package_inside_quantity+$package->quantity;
            $account->package_inside_validity = Carbon::today()->addDays(30);
        }
        elseif($package->type == 'outside') {
            $account->package_outside = $package->code;
            $account->package_outside_rates = $package->rates;
            $account->package_outside_quantity = $account->package_outside_quantity+$package->quantity;
            $account->package_outside_validity = Carbon::today()->addDays(30);
        }
        $p_r->active = 1;
        $p_r->paid = 1;
        if($p_r->update()){
            if($account->update()){
                return redirect()->route('admin.package-requests',$locale);
            }
        }
        return abort(401,'Something Went Wrong');
    }



}
