@extends('layouts.master')
@section('meta-title')
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Fast Star for Delivery | Home Page</title>
@endsection
@section('custom-css')
	<style>
		.carousel-inner .item img{
			opacity: 0.8;
		}
	</style>
@endsection
@section('content')
	<div id="main-carousel" class="carousel slide hero-slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			@foreach($slides as $index => $slide )
			<li data-target="#main-carousel" data-slide-to="{{$index}}" class="{{$index == 0?'active':''}}"></li>
			@endforeach
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox" style="background: #000000;">
			@foreach($slides as $index => $slide )
			<div class="item {{$index == 0?'active':''}}">
				<img src="{{url('img/slider/'.$slide->image)}}" alt="Fast Star">
				<!--Slide Image-->
				<div class="container">
					<div class="carousel-caption pull-left">
						<h1 class="animated lightSpeedIn text-white text-uppercase">{{($slide->title_ar == true and App::getLocale() =='ar')? $slide->title_ar:$slide->title }}</h1>
						<p style="color: #FFFFFF" class="lead animated lightSpeedIn">{{($slide->tagline_ar == true and App::getLocale() =='ar')? $slide->tagline_ar:$slide->tagline }}</p>

						<a class="btn btn-primary animated lightSpeedIn" href="#">{{($slide->link_name_ar == true and App::getLocale() =='ar')? $slide->link_name_ar:$slide->link_name }}</a>

					</div>
					<!--.carousel-caption-->
				</div>
				<!--.container-->
			</div>
			<!--.item-->
			@endforeach
		</div>
		<!--.carousel-inner-->

		<!-- Controls -->
		<a class="left carousel-control" href="#main-carousel" role="button" data-slide="prev">
			<i class="fa fa-angle-left" aria-hidden="true"></i>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#main-carousel" role="button" data-slide="next">
			<i class="fa fa-angle-right" aria-hidden="true"></i>
			<span class="sr-only">Next</span>
		</a>
	</div>
	<!-- #main-carousel-->

	<!-- services start -->
	<section class="service-home section-padding">
		<div class="container text-center">
			<div class="row">
				<div class="col-xs-12">
					<h2 class="section-title">{{trans('home.services-title')}}</h2>
				</div>
			</div> <!-- /.row -->

			@foreach($services->chunk(3) as $items)
			<div class="row content-row">
				@foreach($items as $service)
				<div class="col-sm-4">
					<div class="service">
						<div class="service-thumb-home">
							<a href="#"><img src="{{url('img/service/'.$service->service_image)}}" alt=""></a>
						</div>
						<h3>{{App::getLocale() == 'ar'?$service->service_name_ar:$service->service_name}}</h3>
						<p> {!! App::getLocale() == 'ar'?$service->service_description_ar:$service->service_description !!}</p>
						<a class="readmore" href="#">{{trans('general.read-more')}} &nbsp;<i class="fa fa-angle-right"></i> </a>
					</div>
				</div><!-- /.col-sm-4 -->
				@endforeach
			</div> <!-- /.row -->
			@endforeach
		</div><!-- /.container -->
	</section>
	<!-- services end -->

	<!-- featuer-section start -->
	<section class="feature-section section-padding">
		<div class="container">
			<div class="row">
				<div class="btn-group pull-left">
					<a class="btn btn-primary" data-toggle="modal" data-target="#orderModal">{{trans('general.book-order')}}</a>
					<a class="btn btn-default" data-toggle="modal" data-target="#trackModal">{{trans('general.track-order')}}</a>
				</div>
			</div>
		</div>
	</section>
	<!-- featuer-section end -->

	<!-- why-us-setion start -->
	<section class="why-us-setion section-padding">
		<div class="container">
			<div class="row text-center">
				<div class="col-xs-12">
					<h2 class="section-title">{{trans('home.why-us')}}</h2>
					<span class="section-sub">{!! trans('home.why-us-info') !!}</span>
				</div>
			</div> <!-- /.row -->

			<div class="row content-row">
				<div class="col-md-12">
					<div class="css-tab" role="tabpanel">

						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active"><a href="#secure" aria-controls="secure" role="tab" data-toggle="tab"><i class="flaticon-logistics15"></i> {{trans('home.why1')}}</a></li>
							<li role="presentation"><a href="#trackable" aria-controls="trackable" role="tab" data-toggle="tab"><i class="flaticon-logistics18"></i> {{trans('home.why2')}}</a></li>
							<li role="presentation"><a href="#fast" aria-controls="fast" role="tab" data-toggle="tab"><i class="flaticon-logistics16"></i> {{trans('home.why3')}}</a></li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active fade in" id="secure">
								<div class="css-tab-content">
									<div class="row">
										<div class="col-md-6">
											<img src="{{url('img/secure.png')}}" alt="">
										</div><!-- /.col-md-6 -->

										<div class="col-md-6 content-text">
											<h3>{{trans('home.why1-title')}}</h3>
											<p>{!! trans('home.why1-info') !!}</p>
										</div><!-- /.col-md-6 -->
									</div><!-- /.row -->
								</div><!-- /.css-tab-content -->
							</div>
							<div role="tabpanel" class="tab-pane fade" id="trackable">
								<div class="css-tab-content">
									<div class="row">
										<div class="col-md-6">
											<img src="{{url('img/track.png')}}" alt="">
										</div><!-- /.col-md-6 -->

										<div class="col-md-6 content-text">
											<h3>{{trans('home.why2-title')}}</h3>
											<p>{!! trans('home.why2-info') !!}</p>
											<a class="btn btn-primary animated lightSpeedIn" data-toggle="modal" data-target="#trackModal">{{trans('general.track-order')}}</a>

										</div><!-- /.col-md-6 -->
									</div><!-- /.row -->
								</div><!-- /.css-tab-content -->
							</div>
							<div role="tabpanel" class="tab-pane fade" id="fast">
								<div class="css-tab-content">
									<div class="row">
										<div class="col-md-6">
											<img src="{{url('img/fast.png')}}" alt="">
										</div><!-- /.col-md-6 -->

										<div class="col-md-6 content-text">
											<h3>{{trans('home.why3-title')}}</h3>
											<p>{!! trans('home.why3-info') !!}</p>
										</div><!-- /.col-md-6 -->
									</div><!-- /.row -->
								</div><!-- /.css-tab-content -->
							</div>
						</div>
					</div><!-- /.css-tab -->
				</div><!-- /.col-md-12 -->
			</div><!-- /.row -->

		</div><!-- /.container -->
	</section>
	<!-- why-us-setion end -->

	<section class="pricing-home" style="background: url('{{url('img/gradientbg.png')}}'); background-size:cover;  padding: 50px">
		<div class="container">
			<div class="row text-center">
				<h1 class="text-white text-uppercase">{{trans('home.best-price')}}</h1>
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
	<!-- testimonial-section start -->
	<section class=" section-padding {{(App::getLocale() ==='ar')?'hidden':''}}">
		<div class="container text-center">
			<div class="row">
				<div class="col-xs-12">
					<h2 class="section-title">We are Trusted By</h2>
					<span class="section-sub">Find Our Regular Clients</span>
				</div>
			</div> <!-- /.row -->
			<hr>
			<div class="partner-section">
				<div class="row row-content">
					<div class="col-md-12">
						<div class="owl-carousel partner-carousel">
							@foreach($customers as $item)
							<div class="item">
								<a href="{{$item->link?$item->link:'#'}}"><img src="{{url('img/customers/'.$item->logo)}}" alt="{{$item->name}}"></a>
							</div>
							@endforeach
						</div>

						<div class="partner-carousel-navigation">
							<a class="prev"><i class="fa fa-angle-left"></i></a>
							<a class="next"><i class="fa fa-angle-right"></i></a>
						</div><!-- /.partner-carousel-navigation -->


					</div><!-- /.col-md-12 -->
				</div><!-- /.row -->
			</div><!-- /.partner-section -->
		</div><!-- /.container -->
	</section>
	<!-- testimonial-section end -->

	<!-- counter start -->
	<section class="counter-section hidden" data-stellar-background-ratio="0.5">
		<div class="container">
			<div class="row text-center">
				<div class="col-sm-6 col-xs-12">
					<div class="counter-block">
						<span class="count-description flaticon-boat"><strong class="timer">799</strong>order delivered</span>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class="counter-block">
						<span class="count-description flaticon-international"><strong class="timer">19</strong>order in queue</span>
					</div>
				</div>
			</div> <!-- /.row -->
		</div><!-- /.container -->
	</section><!-- /.counter-section -->
	<!-- counter end -->
@endsection