<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\City;
use App\Neighbor;
use App\Region;
use App\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use App\Price;
use App\Packing;
use App\Package;
use Illuminate\Support\Facades\DB;

class CmsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function prices($locale){
        App::setLocale($locale);
        $prices = Price::all();
        return view('admin.cms.prices',compact('prices'));
    }

    public function editPrice(Request $request, $id,$locale){
        App::setLocale($locale);
        $this->validate($request,[
            'price'=>'required'
        ]);
        $price = Price::find($id);
        $price->price = $request['price'];
        $price->update();
        return redirect()->back();
    }

    public function packages($locale){
        App::setLocale($locale);
        $packages = Package::all();
        return view('admin.cms.packages',compact('packages'));
    }

    public function editPackage(Request $request, $id,$locale){
        App::setLocale($locale);
        $this->validate($request,[
            'rates'=>'required'
        ]);
        $package = Package::find($id);
        $package->rates = $request['rates'];
        $package->amount = $package->quantity*$request['rates'];
        $package->update();
        return redirect()->back();
    }

    public function packings($locale){
        App::setLocale($locale);
        $packings = Packing::all();
        $colors = DB::table('colors')->get();
        return view('admin.cms.packing',compact('packings','colors'));
    }

    public function editPacking(Request $request, $id,$locale){
        App::setLocale($locale);
        $this->validate($request,[
            'type'=>'required',
            'price'=>'required',
        ]);
        $p = Packing::find($id);
        $p->packing_type = $request['type'];
        $p->packing_size = $request['size'];
        $p->packing_price = $request['price'];
        $p->packing_lwh  = $request['lwh'];
        if($p->update()){
            $p->colors()->sync($request->color);
        }
        return redirect()->back();
    }

    public function newPacking(Request $request,$locale){
        App::setLocale($locale);
        $this->validate($request,[
            'type'=>'required',
            'price'=>'required',
        ]);
        $p = new Packing();
        $p->packing_type = $request['type'];
        $p->packing_size = $request['size'];
        $p->packing_price = $request['price'];
        $p->packing_lwh  = $request['lwh'];
        if($p->save()){
            $p->colors()->sync($request->color);
        }
        return redirec.
        t()->back();
    }

    public function deletePacking($id,$locale){
        App::setLocale($locale);
        $p = Packing::find($id);
        $p->delete();
        return redirect()->back();
    }

    public function neighbors($locale){
        App::setLocale($locale);
        $cities = City::where('country','SA')->get();
        $neighbors = Neighbor::all();
        return view('admin.cms.neighbors',compact('cities','neighbors'));
    }

    public function newNeighbor(Request $request, $locale){
        App::setLocale($locale);
        $neighbor = new Neighbor();
        $neighbor->name = $request['name'];
        $neighbor->city = $request['city'];
        $neighbor->region = $request['region'];
        $neighbor->country = $request['country'];
        $neighbor->save();
        return redirect()->back();
    }

    public function getEditNeighbor($id, $locale){
        App::setLocale($locale);
        $neighbor = Neighbor::find($id);
        $cities = City::where('country','SA')->get();
        $city_region = Region::find($neighbor->region);
        $regions = Region::all();
        return view('admin.cms.edit-neighbor',compact('neighbor','cities','regions','city_region'));
    }

    public function postEditNeighbor(Request $request, $id, $locale){
        App::setLocale($locale);
        $n = Neighbor::find($id);
        $n->name = $request['name'];
        $n->region = $request['region'];
        $n->city = $request['city'];
        $n->country = $request['country'];
        $n->update();
        return redirect()->route('admin.cms.neighbors',App::getLocale());
    }

    public function regions($locale){
        App::setLocale($locale);
        $cities = City::where('country','SA')->get();
        $regions = Region::all();
        return view('admin.cms.regions',compact('cities','regions'));
    }

    public function newRegion(Request $request, $locale){
        App::setLocale($locale);
        $region = new Region();
        $region->name = $request['name'];
        $region->city = $request['city'];
        $region->country = $request['country'];
        $region->save();
        return redirect()->back();
    }

    public function getEditRegion(Request $request, $id, $locale){
        App::setLocale($locale);
        $region = Region::find($id);
        $cities = City::where('country','SA')->get();
        return view('admin.cms.edit-region',compact('region','cities'));
    }

    public function postEditRegion(Request $request, $id, $locale){
        App::setLocale($locale);
        $region = Region::find($id);
        $region->name = $request['name'];
        $region->city = $request['city'];
        $region->country = $request['country'];
        $region->update();
        return redirect()->route('admin.cms.regions',App::getLocale());
    }


    public function status($locale){
        App::setLocale($locale);
        $statuses = Status::all();
        return view('admin.cms.status',compact('packings','statuses'));
    }

    public function editStatus(Request $request, $id,$locale){
        App::setLocale($locale);
        $this->validate($request,[
            'status_by'=>'required',
            'name'=>'required',
            'description'=>'required',
        ]);
        $p = Status::find($id);
        $p->name = $request['name'];
        $p->description = $request['description'];
        $p->description_ar = $request['description_ar'];
        $p->status_by = $request['status_by'];
        $p->update();
        return redirect()->back();
    }

    public function newStatus(Request $request,$locale){
        App::setLocale($locale);
        $this->validate($request,[
            'status_by'=>'required',
            'name'=>'required',
            'description'=>'required',
        ]);
        $p = new Status();
        $p->name = $request['name'];
        $p->description = $request['description'];
        $p->description_ar = $request['description_ar'];
        $p->status_by = $request['status_by'];
        $p->save();
        return redirect()->back();
    }

    public function deleteStatus($id,$locale){
        App::setLocale($locale);
        $p = Status::find($id);
        $p->delete();
        return redirect()->back();
    }


    public function customers($locale){
        App::setLocale($locale);
        $customers = Customer::all();

        return view('admin.cms.customers',compact('customers'));
    }

    public function newCustomer(Request $request, $locale){
        App::setLocale($locale);
        $c = new Customer();
        $c->name = $request['name'];
        $c->name_ar = $request['name_ar'];
        $c->link = $request['link'];
        if($request->file('logo')) {
            $file = $request->file('logo');
            $filename = str_random(6) . $file->getClientOriginalName();
            $destinationPath = 'img/customers';
            if ($file->move($destinationPath, $filename)) {
                $c->logo = $filename;
                $c->save();
            }
            return redirect()->back();
        }
    }

    public function deleteCustomer($id,$locale){
        $c = Customer::find($id);
        $c->delete();
        return redirect()->back();
    }

}
