@extends('layouts.master')
@section('meta-title')
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Offers and Prices | Fast Star for Delivery</title>
@endsection
@section('content')
	<section class="page-title-section">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="page-header-wrap {{(App::getLocale() === 'ar') ? 'breadcrumb-right':''}}">
						<div class="page-header">
							<h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">{{trans('prices.page-title')}}</h1>
						</div>
						<ol class="breadcrumb">
							<li><a href="{{route('home',App::getLocale())}}">{{trans('menu.home')}}</a></li>
							<li class="active">{{trans('menu.prices')}}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>


	<section class="pricing-home" style="padding: 50px">
		<div class="container">
			<div class="row text-center">
				<h1 class="text-uppercase">{{trans('home.best-price')}}</h1>
				<div class="price-tab" role="tabpanel">
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#individual" aria-controls="individual" role="tab" data-toggle="tab"><i class="flaticon-logistics15"></i> {{trans('home.one-dlv')}}</a></li>
						<li role="presentation"><a href="#prepaid" aria-controls="prepaid" role="tab" data-toggle="tab"><i class="flaticon-logistics18"></i>{{trans('home.prepaid-package')}}</a></li>
					</ul>

					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active fade in" id="individual">
							<div class="css-tab-content">
								<div class="row">
									<div class="col-sm-4 col-md-4 col-xs-12">
										<div class="box-1 center">
											<div class="panel panel-info panel-pricing">
												<div class="panel-heading">
													<h3>{{trans('home.inside-riyadh')}}</h3>
												</div>
												<div class="panel-body text-center">
													<p><strong>{{$di->price}}{{trans('home.one-in')}}</strong></p>
												</div>
												<ul class="list-group text-center">
													<li class="list-group-item"><strong>{{trans('home.time')}}</strong><br>
														{{trans('home.in-time')}}</li>
												</ul>
												<div class="panel-footer"> <a class="btn btn-lg btn-block btn-info"  href="{{route('client.new-order',App::getLocale())}}"   id="join1">Order Now</a> </div>
											</div>
										</div>
									</div>

									<div class="col-sm-4 col-md-4 col-xs-12">
										<div class="box-1 center">
											<div class="panel panel-info panel-pricing">
												<div class="panel-heading">
													<h3>{{trans('home.inside-riyadh')}} - {{trans('home.express')}}</h3>
												</div>
												<div class="panel-body text-center">
													<p><strong>{{$die->price}}{{trans('home.one-in')}}</strong></p>
												</div>
												<ul class="list-group text-center">
													<li class="list-group-item"><strong>{{trans('home.time')}}</strong><br>
														{{trans('home.express-time')}}</li>
												</ul>
												<div class="panel-footer"> <a class="btn btn-lg btn-block btn-info"  href="{{route('client.new-order',App::getLocale())}}"   id="join1">Order Now</a> </div>
											</div>
										</div>
									</div>
									<div class="col-sm-4 col-md-4 col-xs-12">
										<div class="box-1 center">
											<div class="panel panel-success panel-pricing">
												<div class="panel-heading">
													<h3>{{trans('home.outside-riyadh')}}</h3>
												</div>
												<div class="panel-body text-center">
													<p><strong>{{$do->price}}{{trans('home.one-out')}}</strong></p>
												</div>
												<ul class="list-group text-center">
													<li class="list-group-item"><strong>{{trans('home.time')}}</strong><br>
														{{trans('home.out-time')}}</li>
												</ul>
												<div class="panel-footer"> <a class="btn btn-lg btn-block btn-success"  href="{{route('client.new-order',App::getLocale())}}"  id="join2">Order Now</a> </div>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>


						<div role="tabpanel" class="tab-pane fade" id="prepaid">
							<div class="css-tab-content">
								<div class="row">
									<div class="col-sm-offset-3 col-sm-6 col-md-6 col-xs-12">
										<div class="box-1 center">
											<div class="panel panel-info panel-pricing">
												<div class="panel-heading">
													<h3>{{trans('home.inside-riyadh')}}</h3>
												</div>
												<ul class="list-group text-center">
													@foreach($inPackages as $package)
														<li class="list-group-item"><strong>{{$package->quantity}} {{trans('general.orders')}}</strong><br>
															{{$package->rates}}{{trans('general.sar')}}/{{trans('general.order')}}
														</li>
													@endforeach
												</ul>
												<div class="panel-footer"> <a class="btn btn-lg btn-block btn-info"  href="{{route('client.package',App::getLocale())}}"   id="join1">GET IT</a> </div>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection