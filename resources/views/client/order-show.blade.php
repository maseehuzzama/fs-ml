@extends('layouts.master')
@section('meta-title')
	<meta name="description" content="">
	<meta name="author" content="">
	<title>{{trans('general.order')}} | {{trans('general.tagline')}} </title>
@endsection
@section('custom-css')
@endsection
@section('custom-js')
@endsection
@section('content')
	<section class="page-title-section">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="page-header-wrap {{(App::getLocale() === 'ar') ? 'breadcrumb-right':''}}">
						<div class="page-header">
							<h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">Order #{{@$order->id}}-Reference #{{@$order->ref_number}}</h1>
						</div>
						<ol class="breadcrumb">
							<li><a href="{{route('welcome',App::getLocale())}}">{{trans('menu.home')}}</a></li>
							<li><a href="{{route('client',App::getLocale())}}">{{trans('menu.client')}}</a></li>
							<li><a href="{{route('client.orders',App::getLocale())}}">{{trans('menu.orders')}}</a> </li>
							<li class="active">Order</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section-padding">
		<div class="container">
			<div class="row text-center">
				<div class="col-md-6">
					<h4>Contains: {{@$order->contains}}</h4><br>
				</div><!-- /.col-md-12 -->
				<div class="col-md-6">
					<h4>Status: {{@$order->status}}</h4><br>
				</div><!-- /.col-md-12 -->
			</div>
		</div>
	</section>
@endsection