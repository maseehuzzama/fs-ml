@extends('layouts.master')
@section('meta-title')
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Edit Order | Fast Star for Delivery</title>
@endsection
@section('custom-css')
<!--[if IE]
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<![endif]-->
@endsection
@section('custom-js')
<!--[if IE]
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
		$( function() {
			$( "#pick_date" ).datepicker();
		} );
	</script>
<![endif]-->
@endsection
@section('content')
	<section class="page-title-section">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="page-header-wrap {{(App::getLocale() === 'ar') ? 'breadcrumb-right':''}}">
						<div class="page-header">
							<h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">{{trans('client.edit-order-address',array(App::getLocale(),$order->ref_number))}}</h1>
						</div>
						<ol class="breadcrumb">
							<li><a href="{{route('home',App::getLocale())}}">{{trans('menu.home')}}</a></li>
							<li><a href="{{route('home',App::getLocale())}}">{{trans('menu.client')}}</a></li>
							<li class="active">Edit Order</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section-padding">
		<div class="container">
			<div class="row">
				<h3 class="text-center text-white" style="background: #31708f; margin: 10px 50px 0px 50px;">{{trans('client.new-order-form-title')}} - Step 1</h3>
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
					<form method="post" action="{{route('client.edit-order-address',[App::getLocale(),$order->ref_number])}}"  class="row">
						{{csrf_field()}}

						<div class="form-section">
							<div class="col-sm-12">
								<h3>Place of Taking Shipment</h3>
								<!--store-selection-->
								@if(count(@$stores)>=1)
									<div class="form-group store-sec col-sm-12">
										<select id="store" name="store" class="form-control">
											<option value="">--Select Store--</option>
											@foreach(@$stores as $store)
												<option value="{{@$store->id}}">{{@$store->name}}-{{@$store->street}}-{{@$store->city}}</option>
											@endforeach
											<option value="other">Other Place</option>

										</select>
									</div>
									@endif
											<!--actual-form-start-->
							</div>
							<div id="other_store" class="col-sm-12">
								<div class="form-group col-sm-12 col-md-6">
									<label for="s_name">Store Name</label>
									<input type="text" id="s_name" name="store_name" value="{{$order->store_name}}" class="form-control" required>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="s_country">{{trans('form.country')}}</label>
									<select id="s_country" class="form-control country" name="store_country" required>
										<OPTION value="SA">Saudi Arabia</OPTION>
									</select>
								</div>

								<div class="form-group col-sm-12 col-md-6">
									<label for="s_city">{{trans('form.city')}}</label>
									<select id="s_city" class="form-control city" name="store_city" required>
										<OPTION value="{{$order->s_city}}">{{$order->s_city}}</OPTION>
										@foreach(@$cities as $city)
											<option value="{{@$city->name}}">{{@$city->name}}</option>
										@endforeach
									</select>
								</div>
								<script>
									$('#store').on('change',function(e){
										console.log(e);
										var store_id = e.target.value;
										$('#s_region').val('');

										if(store_id == 'other'){
											$('#other_store').removeClass('hidden');
											$('#s_name').removeAttr("disabled");
											$('#s_city').removeAttr("disabled");
											$('#s_region').removeAttr("disabled");
											$('#s_neighbor').removeAttr("disabled");
											$('#s_street').removeAttr("disabled");
											$('#s_phone').removeAttr("disabled");
										}
										else{
											$('#other_store').addClass('hidden');
											$('#s_name').attr("disabled","disabled");
											$('#s_city').attr("disabled","disabled");
											$('#s_region').attr("disabled","disabled");
											$('#s_neighbor').attr("disabled","disabled");
											$('#s_street').attr("disabled","disabled");
											$('#s_phone').attr("disabled","disabled");
										}
									});

									$('#s_city').on('change',function(e){
										console.log(e);
										var city = e.target.value;
										$.get('../../../ajax-get-neighbors?city='+city, function(data){
											$('#s_neighbor').empty();
											$('#s_neighbor').append('<option value="">--Select--</option>');
											$.each(data, function(index, neighborObj){
												$('#s_neighbor').append('<option value="'+neighborObj.id+'">'+neighborObj.name+'</option>');
											})
										});
									});
								</script>
								<div class="form-group col-sm-12 col-md-6">
									<label for="s_neighbor">Neighbourhood</label>
									<select id="s_neighbor" class="form-control s_region" name="store_neighbour" required>
										<OPTION value="{{$order->s_neighbor}}">{{$order->s_neighbors->name}}</OPTION>
									</select>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="s_street">Street</label>
									<input id="s_street" name="store_street" type="text" class="form-control"  value="{{$order->s_street}}" required>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="s_phone">Phone</label>
									<input id="s_phone" name="store_phone" type="text" class="form-control"  value="{{(@$order->s_phone)?$order->s_phone:Auth::user()->phone}}">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group col-sm-12 col-md-6">
									<label for="pick_date">Pick Date</label>
									<input id="pick_date" name="pick_date" type="date" value="{{@$order->pick_date}}"  class="form-control" min="{{Carbon\Carbon::today()->format('Y-m-d')}}" placeholder="mm/dd/YYYY">
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="pick_date">Pick Time</label>
									<select class="form-control" name="pick_time">
										<option value="{{@$order->pick_time}}">{{@$order->pick_time}}</option>
										<option value="9AM-11AM">9AM-11AM</option>
										<option value="11AM-01PM">11AM-01PM</option>
										<option value="01PM-03PM">01PM-03PM</option>
										<option value="03PM-05PM">03PM-05PM</option>
										<option value="05PM-07PM">05PM-07PM</option>
										<option value="07PM-09PM">07PM-09PM</option>
										<option value="09PM-11PM">09PM-11PM</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-section col-xs-12"><h3>{{trans('client.rcvr-info')}}</h3>
							<div class="form-group col-sm-12 col-md-6">
								<label for="r_name">{{trans('form.name')}}</label>
								<input id="r_name" name="receiver_name" type="text" value="{{@$order->r_name}}" class="form-control" placeholder="" required>
							</div>
							<div class="form-group col-sm-12 col-md-6">
								<label for="r_country">{{trans('form.country')}}</label>
								<select id="r_country" class="form-control country" name="receiver_country" required>
									<option value="SA">Saudi Arabia</option>
								</select>
							</div>
							<div class="form-group col-sm-12 col-md-6">
								<label for="r_city">{{trans('form.city')}}</label>
								<select  id="r_city" class="form-control city" name="receiver_city" required>
									<option value="{{@$order->r_city}}">{{@$order->r_city}}</option>
									@foreach(@$cities as $city)
										<option value="{{@$city->name}}">{{@$city->name}}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group col-sm-12 col-md-6">
								<label for="r_neighbor">Neighbourhood</label>
								<select id="r_neighbor" class="form-control r_neighbor" name="receiver_neighbour" required>
									<option  value="{{@$order->r_neighbor}}">{{@$order->r_neighbors->name}}</option>
								</select>
							</div>

							<script>
								$('#r_city').on('change',function(e){
									console.log(e);
									var city = e.target.value;
									$.get('../../../ajax-get-neighbors?city='+city, function(data){
										$('#r_neighbor').empty();
										$('#r_neighbor').append('<option value="">--Select--</option>');
										$.each(data, function(index, neighborObj){
											$('#r_neighbor').append('<option value="'+neighborObj.id+'">'+neighborObj.name+'</option>');
										})
									});
								});
							</script>

							<div class="form-group col-sm-12 col-md-6">
								<label for="r_street">Street</label>
								<input id="r_street" name="receiver_street" type="text"  value="{{@$order->r_street}}" class="form-control" placeholder="">
							</div>


							<div class="form-group col-sm-12 col-md-6">
								<label for="r_phone">{{trans('form.mobile')}}</label>
								<input id="r_phone" name="receiver_phone" type="number" class="form-control" value="{{@$order->r_phone}}" placeholder="Receiver Phone" required>
							</div>
						</div>
						<div class="form-section">
							<input type="submit" value="{{trans('general.next')}}" class="btn btn-primary">
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
@endsection

