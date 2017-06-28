<span style="display: none">@if(App::getLocale() == 'en'){{ $lang = 'ar' }} @else {{$lang = 'en'}}  @endif</span>
<li>

    <a class="btn btn-sm btn-primary" href="{{route(Route::current()->getName(),[$lang,@$order->ref_number])}}" >
        @if(App::getLocale() == 'en'){{ trans('menu.arabic')}} @else {{'English'}}  @endif </a>
</li>
