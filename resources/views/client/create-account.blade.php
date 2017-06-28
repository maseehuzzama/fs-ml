@extends('layouts.master')
@section('meta-title')
	<meta name="description" content="">
	<meta name="author" content="">
	<title>{{trans('form.create-account')}} | {{trans('general.tagline')}}</title>
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
							<h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">{{trans('general.account-create-title')}}</h1>
						</div>
						<ol class="breadcrumb">
							<li><a href="{{route('welcome',App::getLocale())}}">{{trans('menu.home')}}</a></li>
							<li><a href="{{route('client',App::getLocale())}}">{{trans('menu.client')}}</a></li>
							<li class="active">{{trans('general.account-create-title')}}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section-padding">
		<div class="container">
			<div class="row">
				<h3 class="text-center text-white" style="background: #31708f; margin: 10px 50px 0px 50px;">{{trans('general.enter-store-account-details')}}</h3>
				@if (count($errors) > 0)
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<div class="col-xs-12 {{(App::getLocale() === 'ar') ? 'text-right':''}}" style="border: 1px solid #31708f; padding: 30px;">
					<form method="post" action="{{route('client.create-account',App::getLocale())}}"  class="row">
						{{csrf_field()}}
						<div class="form-section col-xs-12"><h3>{{trans('general.store-details')}}</h3>
							<div class="row">
								<input type="hidden" name="country" value="SA">
								<div class="form-group col-sm-12 col-md-4">
									<label for="name">{{trans('form.name')}}</label>
									<input type="text" id="name" name="name"  class="form-control" placeholder="Enter Store/Shop Name" value="{{old('name')}}" required>
								</div>

								<div class="form-group col-sm-12 col-md-4">
									<label for="activity">{{trans('form.activity')}}</label>
									<input type="text" id="activity" name="activity" class="form-control" value="{{old('activity')}}" required>
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label for="phone">{{trans('form.phone')}}</label>
									<input type="text" id="phone" name="phone" max="10" class="form-control" value="{{old('phone')}}" required>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-sm-12 col-md-4">
									<label for="city">{{trans('form.city')}}</label>
									<select class="form-control" id="city" name="city" required>
										<option value="">--select--</option>
										@foreach($cities as $city)
											<option value="{{$city->name}}">{{$city->name}}</option>
										@endforeach
									</select>
								</div>
								<script>
									$('#city').on('change',function(e){
										console.log(e);
										var city = e.target.value;
										$.get('../../ajax-get-neighbors?city=' +city, function(data){
											$('#s_neighbor').empty();
											$.each(data, function(index, obj){
												$('#neighbor').append('<option value="'+obj.id+'">'+obj.name+'</option>');
											})
										});
									});
								</script>
								<div class="form-group col-sm-12 col-md-4">
									<label for="neigbor">{{trans('form.neighbour')}}</label>
									<select class="form-control" id="neighbor" name="neighbourhood"  required>
										<option value="">--Select--</option>
									</select>
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label for="street">{{trans('form.street')}}</label>
									<input id="street" name="street" type="text" class="form-control" value="{{old('street')}}"  placeholder="Enter Street" required>
								</div>
							</div>
						</div>
						<div class="form-section">
							<h3>{{trans('form.create-account')}}</h3>
							<div class="row">
								<div class="form-group col-sm-12 col-md-4">
									<label for="bank_name">{{trans('form.bank_name')}}</label>
									<input id="bank_name" name="bank_name" type="text" class="form-control" placeholder="Enter Bank Name" value="{{old('bank_name')}}" required>
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label for="fullname">{{trans('form.account-name')}}</label>
									<input type="text" id="fullname" name="fullname"  class="form-control" placeholder="Enter Your Fullname attach with bank account" value="{{old('fullname')}}"  required>
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label for="iban">{{trans('general.iban')}}</label>
									<div class="form-inline">
										<label><b>SA-</b></label>
										<input type="number" id="iban" name="iban" class="form-control" placeholder="only numbers" value="{{old('iban')}}" maxlength="22" min="22"  style="width: 80%">
									</div>
								</div>
							</div>
							<div class="row">
								<input type="submit" value="{{trans('general.submit')}}" class="btn btn-primary">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
@endsection

