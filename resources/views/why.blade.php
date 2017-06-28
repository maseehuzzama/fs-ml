@extends('layouts.master')
@section('meta-title')
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Why Fast Star</title>
@endsection
@section('custom-css')
	<style>
		.items{
			margin-top: 100px;
		}
		.items .item img{
			max-height: 150px;
		}
	</style>
@endsection
@section('content')
	<section class="page-title-section">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="page-header-wrap {{(App::getLocale() === 'ar') ? 'breadcrumb-right':''}}">
						<div class="page-header">
							<h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">{{trans('why.page-title')}}</h1>
						</div>
						<ol class="breadcrumb">
							<li><a href="{{route('home',App::getLocale())}}">{{trans('menu.home')}}</a></li>
							<li class="active">{{trans('menu.why')}}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>


	<section class="section-padding ">
		<div class="container" style="width: 80%">
			<div class="row text-center">
				<div class="col-xs-12">
					<h2 class="section-title">{{trans('home.why-us')}}</h2>
					<span class="section-sub">{!! trans('home.why-us-info') !!}</span>
				</div>
			</div> <!-- /.row -->

			<div class="row items text-center">
				<div class="item col-xs-12" style="box-shadow: 0 0 10px 0; padding: 20px; margin-bottom: 20px">
					<div class="row">
						<div class="item-pic col-xs-12 col-sm-4 col-md-3">
							<img src="{{url('img/secure.png')}}"/>
						</div>
						<div class="item-content col-xs-12 col-sm-8 col-md-9 {{(App::getLocale() == 'ar')? 'text-right':'text-left'}}">
							<h3>{{trans('home.why1-title')}}</h3>
							<p>{!! trans('home.why1-info') !!}</p>
						</div>
					</div>
				</div>
				<div class="item col-xs-12" style="box-shadow: 0 0 10px 0; padding: 20px; margin-bottom: 20px">
					<div class="row">
						<div class="item-pic col-xs-12 col-sm-4 col-md-3">
							<img src="{{url('img/track.png')}}"/>
						</div>
						<div class="item-content col-xs-12 col-sm-8 col-md-9 {{(App::getLocale() == 'ar')? 'text-right':'text-left'}}">
							<h3>{{trans('home.why2-title')}}</h3>
							<p>{!! trans('home.why2-info') !!}</p>
						</div>
					</div>
				</div>
				<div class="item col-xs-12" style="box-shadow: 0 0 10px 0; padding: 20px;margin-bottom: 20px">
					<div class="row">
						<div class="item-pic col-xs-12 col-sm-4 col-md-3">
							<img src="{{url('img/fast.png')}}"/>
						</div>
						<div class="item-content col-xs-12 col-sm-8 col-md-9 {{(App::getLocale() == 'ar')? 'text-right':'text-left'}}">
							<h3>{{trans('home.why3-title')}}</h3>
							<p>{!! trans('home.why3-info') !!}</p>
						</div>
					</div>
				</div>
			</div><!-- /.row -->
		</div><!-- /.container -->
	</section>

@endsection