<?php

namespace App\Http\Controllers\Admin;

use App\GeneralSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use App\Slider;
use Illuminate\Support\Facades\DB;
use Symfony\Component\EventDispatcher\Tests\Service;
use App\Services;
class ThemeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    public function slider($locale){
        App::setLocale($locale);
        $slides = Slider::all();
        return view('admin.theme.slider',compact('slides'));
    }

    public function newSlide(Request $request,$locale){
        App::setLocale($locale);
        $this->validate($request,[
            'number'=>'required',
            'title'=>'required|max:255',
            'tagline'=>'required|max:255',
            'link_name'=>'required|max:255',
            'link'=>'required|max:255',
            'keywords'=>'required|max:255',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif|max:500',
        ]);

        $slide = new Slider();
        $slide->slide_number = $request['number'];
        $slide->title = $request['title'];
        $slide->title_ar = $request['title_ar'];
        $slide->tagline = $request['tagline'];
        $slide->tagline_ar = $request['tagline_ar'];
        $slide->link_name = $request['link_name'];
        $slide->link_name_ar = $request['link_name_ar'];
        $slide->link = $request['link'];
        $slide->keywords = $request['keywords'];

        if($request->file('image')){
            $file = $request->file('image');
            $filename = str_random(6).$file->getClientOriginalName();
            $destinationPath = 'img/slider';
            if($file->move($destinationPath, $filename)){
                $slide->image = $filename;
                $slide->save();
            }
            else{
                return abort(401,'Image Not Uploaded');
            }
        }

        return redirect()->back();
    }
    public function deleteSlide($id,$locale){
        App::setLocale($locale);
        $slide = Slider::find($id);
        $slide->delete();
        return redirect()->back();
    }


    public function services($locale){
        App::setLocale($locale);
        $services = Services::all();
        return view('admin.theme.services',compact('services'));
    }
    public function newService(Request $request,$locale){
        App::setLocale($locale);
        $this->Validate($request, array(

            'service_name'=>'required|unique:services',
            'service_description'=>'required',
            'service_number'=>'required|unique:services',
            'service_image'=>'required|image|mimes:jpeg,png,jpg,gif|max:500',
        ));

        $fileName = time().'.'.$request->service_image->getClientOriginalName();
        $file = request()->file('service_image');
        $destinationPath = 'img/service';
        if ($file->move($destinationPath, $fileName)) {
            Services::create(array(
                'service_name' => $request['service_name'],
                'service_name_ar' => $request['service_name_ar'],
                'service_description' => $request['service_description'],
                'service_description_ar' => $request['service_description_ar'],
                'service_number' => $request['service_number'],
                'service_slug' => str_slug($request['service_name']),
                'keywords' => $request['keywords'],
                'service_image' => $fileName,
                'service_icon' => $request['service_icon'],
                'service_type' => $request['service_type'],
                'published'=>1,
            ));
            return redirect()->back()->with('success','A new service has been entered');
        }
    }


    public  function editService($id,$locale){
        App::setLocale($locale);
        $service = Services::findOrFail($id);
        return view('admin.theme.edit-service', compact('service'));

    }

    public function updateService(Request $request,$id){
        $this->Validate($request, array(
            'service_name'=>'required',
            'service_name_ar'=>'required',
            'service_description'=>'required',
            'service_description_ar'=>'required',
            'service_number'=>'required',
        ));

        if($request->file('service_image')) {
            $fileName = time() . '.' . $request->service_image->getClientOriginalName();
            $file = request()->file('service_image');
            $destinationPath = 'img/service';
            if ($file->move($destinationPath, $fileName)) {
                $service = Services::findOrFail($id);
                $service->service_name = $request['service_name'];
                $service->service_name_ar = $request['service_name_ar'];
                $service->service_description = $request['service_description'];
                $service->service_description_ar = $request['service_description_ar'];
                $service->service_slug = str_slug($request['service_name']);
                $service->service_number = str_slug($request['service_number']);
                $service->keywords = $request['keywords'];
                $service->service_image = $fileName;
                $service->service_icon = $request['service_icon'];
                $service->save();
            }
        }
        else{
            $service = Services::findOrFail($id);
            $service->service_name = $request['service_name'];
            $service->service_name_ar = $request['service_name_ar'];
            $service->service_description = $request['service_description'];
            $service->service_description_ar = $request['service_description_ar'];
            $service->service_slug = str_slug($request['service_name']);
            $service->service_number = str_slug($request['service_number']);
            $service->service_icon = $request['service_icon'];
            $service->keywords = $request['keywords'];
            $service->save();
        }
        return redirect()->route('admin.theme.services',App::getLocale())->with('success','Service has been updated');
    }

    public  function deleteService($id,$locale){
        App::setLocale($locale);
        $service = Services::find($id);
        $service->delete();
        return redirect()->back();
    }



    public function generalSettings($locale){
        App::setLocale($locale);
        $setting = DB::table('general_settings')->first();
        return view('admin.theme.general',compact('setting'));

    }

    public function editSettings(Request $request, $locale){
        App::setLocale($locale);
        $setting = GeneralSetting::first();

        $setting->phone = $request['phone'];
        $setting->phone_another = $request['phone_another'];
        $setting->email = $request['email'];

        if($request->file('logo')){
            $file = $request->file('logo');
            $filename = $file->getClientOriginalName();
            $destinationPath = 'img';
            if($file->move($destinationPath, $filename)){
                $setting->logo = $filename;
                $setting->save();
            }
        }
        else{
            $setting->save();
        }
        return redirect()->back();
    }



}
