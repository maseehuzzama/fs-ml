@extends('layouts.master')
@section('meta-title')
	<meta name="description" content="">
	<meta name="author" content="">
	<title>{{trans('general.edit-store')}}| {{trans('general.tagline')}}</title>
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
							<h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">{{trans('general.edit-store')}}</h1>
						</div>
						<ol class="breadcrumb">
							<li><a href="{{route('welcome',App::getLocale())}}">{{trans('menu.home')}}</a></li>
							<li><a href="{{route('client',App::getLocale())}}">{{trans('menu.client')}}</a></li>
							<li class="active">{{trans('general.edit-store')}}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section-padding">
		<div class="container">
			<div class="row">
				<h3 class="text-center text-white" style="background: #31708f; margin: 10px 50px 0px 50px;">{{trans('general.edit-store')}}</h3>

				<div class="col-xs-12 {{(App::getLocale() === 'ar') ? 'text-right':''}}" style="border: 1px solid #31708f; padding: 30px;">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
						<form  method="post" action="{{route('client.edit-store',array(App::getLocale(),$store->id))}}">
							{{csrf_field()}}
							<div class="form-section col-xs-12">
								<div class="row">
									<input type="hidden" name="country" value="SA">
									<div class="form-group col-sm-12 col-md-4">
										<label for="name">{{trans('form.store-name')}}</label>
										<input type="text" id="name" name="name"  class="form-control" value="{{@$store->name}}" required>
									</div>

									<div class="form-group col-sm-12 col-md-4">
										<label for="activity">{{trans('form.activity')}}</label>
										<input type="text" id="activity" name="activity" value="{{@$store->activity}}" class="form-control">
									</div>

									<div class="form-group col-sm-12 col-md-4">
										<label for="city">{{trans('form.city')}}</label>
										<select class="form-control" id="city" name="city"  required>
											<option value="{{@$store->city}}">{{@$store->city}}</option>
											@foreach($cities as $city)
												<option value="{{$city->name}}">{{$city->name}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="row">
									<script>
										$('#city').on('change',function(e){
											console.log(e);
											var city = e.target.value;
											$.get('../../../ajax-get-neighbors?city_id=' +city, function(data){
												$('#neighbor').empty();
												$.each(data, function(index, obj){
													$('#neighbor').append('<option value="'+obj.id+'">'+obj.name+'</option>');
												})
											});
										});
									</script>
									<div class="form-group col-sm-11 col-md-4">
										<label for="neighbor">{{trans('form.neighbour')}}</label>
										<select class="form-control" id="neighbor" name="neighbourhood" required>
											<option value="{{@$store->neighbor_id}}">{{@$store->neighbors->name}}</option>
										</select>
									</div>
									<div class="form-group col-sm-12 col-md-4">
										<label for="street">{{trans('form.street')}}</label>
										<input id="street" name="street" type="text" class="form-control"  value="{{@$store->street}}">
									</div>
									<div class="form-group col-sm-12 col-md-4">
										<label for="phone">{{trans('form.mobile')}}</label>
										<input id="phone" name="phone" type="text" class="form-control" value="{{@$store->phone}}" placeholder="Enter Mobile or Phone Number">
									</div>
								</div>
								<div class="row">
									<input type="submit" value="{{trans('form.update')}}" class="btn btn-info" style="margin-left: 20px">
									<input type="submit" data-dismiss="modal" value="{{trans('form.cancel')}}" class="btn btn-warning" style="margin-left: 20px">
								</div>
							</div>
						</form>
				</div>
			</div>
		</div>
	</section>
@endsection

