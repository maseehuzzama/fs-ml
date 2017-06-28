<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Redirect;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function index(){


        if(!\Session::has('locale')){
            $get = App::get(Input::get('locale'));
            dd($get);
        }
        else{
            $set = App::setLocale('locale','ar');
            dd($set);
        }
        return Redirect::back();
    }
}
