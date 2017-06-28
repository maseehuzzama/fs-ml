@extends('layouts.master')
@section('meta-title')
	<meta name="description" content="">
	<meta name="author" content="">
	<title>About | Fast Star for Delivery</title>
@endsection
@section('content')
	<section class="page-title-section">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="page-header-wrap {{(App::getLocale() === 'ar') ? 'breadcrumb-right':''}}">
						<div class="page-header">
							<h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">{{trans('about.page-title')}}</h1>
						</div>
						<ol class="breadcrumb">
							<li><a href="{{route('home',App::getLocale())}}">{{trans('menu.home')}}</a></li>
							<li class="active">{{trans('menu.about')}}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>


	<!-- about-intro-section -->
	<section class="about-intro-section">
		<div class="container">
			<div class="row">
				<div class="col-md-7 {{(App::getLocale()==='ar'?'col-sm-offset-5':'')}}">
					<div class="about-intro">
						<h2>{{trans('about.welcome')}}</h2>
						<p {{(App::getLocale()==='ar'?'lead':'')}}>{!! trans('about.description') !!}</p>
					</div><!-- /.about-intro -->
				</div><!-- /.col-md-7 -->
				<div class="col-md-5"></div>
			</div><!-- /.row -->
		</div><!-- /.container -->
	</section>
	<!-- /.about-intro-section -->

	<!--vicion-section -->
	<section class="vision-section">
		<div class="container text-center">
			<h2>{{trans('about.vision')}}</h2>
			<div class="vision-timeline">
				<div id="visionCarousel" class="carousel slide carousel-fade" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#visionCarousel" data-slide-to="0" class="active"></li>
						<li data-target="#visionCarousel" data-slide-to="1"></li>
						<li data-target="#visionCarousel" data-slide-to="2"></li>
					</ol>

					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<div class="item active">
							<div class="vision-title text-center">
								<span class="title">{{trans('about.vision1-title')}}</span>
							</div>
							<div class="vision-info">
								<h3>{!! trans('about.vision1-info') !!}</h3>
							</div>
						</div><!-- /.item -->
						<div class="item">
							<div class="vision-title text-center">
								<span class="title">{{trans('about.vision2-title')}}</span>
							</div>
							<div class="vision-info">
								<h3>{!! trans('about.vision2-info') !!}</h3><br>
							</div>
						</div><!-- /.item -->

						<div class="item">
							<div class="vision-title text-center">
								<span class="title">{{trans('about.vision3-title')}}</span>
							</div>
							<div class="vision-info">
								<h3>{{trans('about.vision3-info')}}</h3>
							</div>
						</div><!-- /.item -->

					</div><!-- /.carousel-inner -->
				</div><!-- /.carousel -->
			</div><!-- /.vision-line -->
		</div><!-- /.container -->
	</section>
	<!--/.vision-section -->
@endsection