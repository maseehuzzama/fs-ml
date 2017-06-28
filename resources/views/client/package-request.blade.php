@extends('layouts.master')
@section('meta-title')
	<meta name="description" content="">
	<meta name="author" content="">
	<title>{{trans('menu.package-request')}} | {{trans('general.tagline')}}</title>
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
							<h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">{{trans('menu.package-request')}}</h1>
						</div>
						<ol class="breadcrumb">
							<li><a href="{{route('welcome',App::getLocale())}}">{{trans('menu.home')}}</a></li>
							<li><a href="{{route('client',App::getLocale())}}">{{trans('menu.client')}}</a></li>
							<li class="active">{{trans('menu.package-request')}}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section-padding">
		<div class="container">
			<div class="row">
				<h3 class="text-center text-white" style="background: #31708f; margin: 10px 50px 0px 50px;">{{trans('menu.package-request')}}</h3>
				<div class="col-xs-12 {{(App::getLocale() === 'ar') ? 'text-right':''}}" style="border: 1px solid #31708f; padding: 30px;">
					<form method="post" action="{{route('client.package',App::getLocale())}}"  class="row">
						{{csrf_field()}}
						<div class="form-section col-xs-12"><h3>{{trans('client.package-details')}}</h3>
							<div class="row">
								<div class="form-group col-sm-12 col-md-6">
									<label for="package">{{trans('client.package')}}</label>
									<select id="package" name="package" class="form-control">
										<option value="">---{{trans('general.select-one')}}--</option>
										@foreach($packages as $package)
											<option value="{{$package->id}}">{{$package->type}} Riyadh - {{$package->quantity}} orders at {{$package->rates}}SAR/Order</option>
										@endforeach
									</select>
								</div>

								<div class="form-group col-sm-12 col-md-6">
									<label for="payment_mode">{{trans('form.payment-method')}}</label>
									<select id="payment_mode" name="payment_mode" class="form-control">
										<option value="">---{{trans('general.select-one')}}--</option>
										<option value="tfa">Take from Account</option>
										<option value="bank">Bank Transfer or Deposit</option>
										<option value="cash">Submit Cash to Agent or Office</option>
									</select>
								</div>
								<input type="hidden" name="account_id" value="{{$account->user_id}}">
							</div>
						</div>
						<div class="form-section">
							<input type="submit" value="{{trans('general.submit')}}" class="btn btn-primary">
						</div>
					</form>

				</div>
			</div>
		</div>
	</section>
@endsection

