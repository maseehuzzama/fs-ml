<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Router;
use Illuminate\Http\Request;
use App\GeneralSetting;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $setting = GeneralSetting::orderBy('id','desc')->first();

        View::share(['logo'=>$setting->logo,'phone'=>$setting->phone,'email'=>$setting->email,'phone_another'=>$setting->phone_another,]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
