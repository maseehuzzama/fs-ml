@extends('layouts.master')
@section('meta-title')
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Services | Fast Star for Delivery</title>
@endsection
@section('content')
	<section class="page-title-section">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
                    <div class="page-header-wrap {{(App::getLocale() === 'ar') ? 'breadcrumb-right':''}}">
                        <div class="page-header">
                            <h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">{{trans('services.page-title')}}</h1>
                        </div>
                        <ol class="breadcrumb">
                            <li><a href="{{route('home',App::getLocale())}}">{{trans('menu.home')}}</a></li>
                            <li class="active">{{trans('menu.services')}}</li>
                        </ol>
                    </div>
				</div>
			</div>
		</div>
	</section>

	<section class="service-page-contents section-padding">
		<div class="container">
			<div class="text-center">
				<h2 class="section-title">{{trans('services.page-title')}}</h2>
				<span class="section-sub">{{trans('services.description')}}</span>
			</div>

			<div class="service-blocks">
				@foreach($services->chunk(3) as $items)
				<div class="row">
					@foreach($items as $service)
					<div class="col-sm-4">
						<div class="service-block clearfix">
							<div class="service-icon">
								<i class="{{$service->service_icon}}"></i>
							</div>
							<div class="service-content">
								<h3>{{App::getLocale() == 'ar'?$service->service_name_ar:$service->service_name}}</h3>
								<p> {!! App::getLocale() == 'ar'?$service->service_description_ar:$service->service_description !!}</p>
							</div>
						</div><!-- /.service-block -->
					</div><!-- /.col-sm-4 -->
					@endforeach
				</div><!-- /.row -->
				@endforeach
			</div><!-- /.service-blocks -->
		</div><!-- /.container -->
	</section>
@endsection