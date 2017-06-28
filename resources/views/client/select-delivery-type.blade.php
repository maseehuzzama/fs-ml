@extends('layouts.master')
@section('meta-title')
	<meta name="description" content="">
	<meta name="author" content="">
	<title>{{trans('general.submit-order')}}| {{trans('general.tagline')}}</title>
@endsection
@section('custom-css')
	<style>
		.loadinggif {
	background: orange no-repeat right center;
	border: 1px solid tomato;
	outline: none;
	}
	</style>
@endsection
@section('custom-js')
	<script>
	</script>
@endsection
@section('content')
	<section class="page-title-section">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="page-header-wrap {{(App::getLocale() === 'ar') ? 'breadcrumb-right':''}}">
						<div class="page-header">
							<h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">{{trans('general.submit-order')}}</h1>
						</div>
						<ol class="breadcrumb">
							<li><a href="{{route('welcome',App::getLocale())}}">{{trans('menu.home')}}</a></li>
							<li><a href="{{route('client',App::getLocale())}}">{{trans('menu.client')}}</a></li>
							<li class="active">{{trans('general.submit-order')}}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section-padding">
		<div class="container">
			<div class="row">
				<h3 class="text-center text-white" style="background: #31708f; margin: 10px 50px 0px 50px;">Select Delivery Type - {{trans('form.step2')}}</h3>
				<div class="col-xs-12 {{(App::getLocale() === 'ar') ? 'text-right':''}}" style="border: 1px solid #31708f; padding: 30px;">
					<form  method="post" action="{{route('client.select-delivery-type',array(App::getLocale(),$order->ref_number))}}"  class="row">
						{{csrf_field()}}
						<div class="form-section">
							<div class="form-group col-xs-12">
								<div class="row">
									<label for="spl_req">Delivery Type</label><br>
									@if($order->s_city == 'Riyadh' and $order->r_city == 'Riyadh')
									<div class="col-sm-12 col-md-4">
										<input type="radio" name="delivery_type"  value="fd"><span>Fast Delivery(24 Hours)</span>
									</div>
									<div class="col-sm-12 col-md-4">
										<input type="radio" name="delivery_type"  value="fed"><span>Fast Express Delivery(3 Hours)</span>
									</div>
									@else
									<div class="col-sm-12 col-md-4">
										<input type="radio" name="delivery_type" value="fs"><span>Fast Shipping(48 Hours)</span>
									</div>
									@endif
								</div>
							</div>
						</div>
						<input type="submit" class="btn btn-primary" value="{{trans('general.next')}}">
						<a href="{{route('client.edit-order',array(App::getLocale(),$order->id))}}" class="btn btn-default">{{trans('general.back')}}</a>
					</form>
				</div>
			</div>
		</div>
	</section>
@endsection

