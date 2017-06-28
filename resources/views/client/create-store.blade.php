@extends('layouts.master')
@section('meta-title')
	<meta name="description" content="">
	<meta name="author" content="">
	<title>{{trans('general.edit-account')}} | {{trans('general.tagline')}}</title>
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
							<h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">Enter Store</h1>
						</div>
						<ol class="breadcrumb">
							<li><a href="{{route('welcome',App::getLocale())}}">{{trans('menu.home')}}</a></li>
							<li><a href="{{route('client',App::getLocale())}}">{{trans('menu.client')}}</a></li>
							<li class="active">Create Store</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section-padding">
		<div class="container">
			<div class="row">
				<h3 class="text-center text-white" style="background: #31708f; margin: 10px 50px 0px 50px;">Enter Your Details</h3>
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
					<form method="post" action="{{route('client.create-store',App::getLocale())}}"  class="row">
						{{csrf_field()}}
						<div class="form-section col-xs-12">
							<div class="row">
								<div class="form-group col-sm-12">
									<label for="name">{{trans('form.name')}}</label>
									<input type="text" id="name" name="name"  class="form-control" placeholder="Enter Store/Shop Name" required>
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label for="country">Country</label>
									<select class="form-control" id="country" name="country" required>
										<option value="SA">Saudi Arabia</option>
									</select>
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label for="state">{{trans('form.state')}}</label>
									<select class="form-control" id="state" name="state" required>
										<option value="10">Ar Riyad</option>
										@foreach($states as $state)
											<option value="{{$state->name}}">{{$state->name}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label for="city">{{trans('form.city')}}</label>
									<select class="form-control" id="city" name="city" required>
										<option value="Riyadh">Riyadh</option>
										@foreach($cities as $city)
											<option value="{{$city->name}}">{{$city->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="row">
								<script>
									$('#s_city').on('change',function(e){
										console.log(e);
										var city_id = e.target.value;
										$.get('../ajax-get-neighbors?city_id=' +city_id, function(data){
											$('#s_neighbor').empty();
											$.each(data, function(index, obj){
												$('#s_neighbor').append('<option value="'+obj.id+'">'+obj.name+'</option>');
											})
										});
									});
								</script>
								<div class="form-group col-sm-11 col-md-6">
									<label for="region">{{trans('form.neighbor')}}</label>
									<select class="form-control" id="s_neighbor" name="neighbourhood" required>
										<option value="">--Select--</option>
									</select>
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label for="street">{{trans('form.street')}}</label>
									<input id="street" name="street" type="text" class="form-control" placeholder="Enter Street">
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label for="phone">Mobile</label>
									<input  type="number" id="phone" name="phone" class="form-control" placeholder="">
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

