@extends('layouts.master')
@section('meta-title')
	<meta name="description" content="">
	<meta name="author" content="">
	<title>{{trans('general.new-other-order')}} | {{trans('general.new-other-order')}}</title>
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

<script>
	$(function () {
		$("#photo").change(function () {
			if($(this).is(":checked")) {
				$("#photo_quantity").removeAttr("disabled");
				$("#photo_quantity").focus();
				$("#photo_description").removeAttr("disabled");
				$("#p_address").removeAttr("disabled");
			} else {
				$("#photo_quantity").attr("disabled","disabled");
				$("#photo_description").attr("disabled","disabled");
				$("#p_address").attr("disabled","disabled");
				$("#photo_address").attr("disabled","disabled");
				$("#photo_quantity").val('');
				$("#photo_description").val('');
				$("#p_address").val('');
			}
		});

		$("#p_address").change(function () {
			if($(this).val() == 'same'){
				$("#photo_address").attr("disabled","disabled");
				$("#photo_address").val('');
			}
			else if ($(this).val() == 'other'){
				$("#photo_address").removeAttr("disabled");
			}
		});
	});
</script>

@endsection
@section('content')
	<section class="page-title-section">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="page-header-wrap {{(App::getLocale() === 'ar') ? 'breadcrumb-right':''}}">
						<div class="page-header">
							<h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">{{trans('general.new-other-order')}}</h1>
						</div>
						<ol class="breadcrumb">
							<li><a href="{{route('welcome',App::getLocale())}}">{{trans('menu.home')}}</a></li>
							<li><a href="{{route('client',App::getLocale())}}">{{trans('menu.client')}}</a></li>
							<li class="active">{{trans('genral.new-other-order')}}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section-padding">
		<div class="container">
			<div class="row">
				<h3 class="text-center text-white" style="background: #31708f; margin: 10px 50px 0px 50px;">{{trans('client.new-order-form-title')}}</h3>
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
					<form method="post" action="{{route('client.other-new-order',App::getLocale())}}"  class="row">
						{{csrf_field()}}
						<div class="form-section">
							<div class="col-sm-12">
								<h3>{{trans('general.shipment-place')}}</h3>
								<!--store-selection-->
								@if(count(@$stores)>=1)
									<div class="form-group store-sec col-sm-6">
										<select id="store" name="store" class="form-control" required>
											<option value="">--{{trans('form.select-store')}}--</option>
											@foreach(@$stores as $store)
												<option value="{{@$store->id}}">{{@$store->name}}-{{@$store->street}}-{{@$store->city}}</option>
											@endforeach
											<option value="other">{{trans('general.other-place')}}</option>
										</select>
									</div>
								@endif
								<div class="form-group store-address col-sm-6">
									<select id="store-address" name="store_address" class="form-control" required>
										<option value="">--Select Shipment Address--</option>
										<option value="same">{{trans('general.same-store')}}</option>
										<option value="other">{{trans('general.other-place')}}</option>
									</select>
								</div>
							</div>
							<!--actual-form-start-->
							<div id="other_store" class="col-sm-12 {{(count(@$stores)<=0)?'':'hidden'}}">
								<div id="hd" class="">
									<div class="form-group col-sm-12 col-md-6">
										<label for="s_name">{{trans('general.store-name')}}</label>
										<input type="text" id="s_name" name="store_name" class="form-control" required>
									</div>
									<div class="form-group col-sm-12 col-md-6">
										<label for="s_country">{{trans('form.country')}}</label>
										<select id="s_country" class="form-control country" name="store_country" required>
											<OPTION value="SA">Saudi Arabia</OPTION>
										</select>
									</div>
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label for="s_city">{{trans('form.city')}}</label>
									<select id="s_city" class="form-control city" name="store_city" required>
										<OPTION value="">--Select-City--</OPTION>
										@foreach($cities as $city)
											<option value="{{@$city->name}}">{{@$city->name}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label for="s_neighbor">{{trans('general.neighbour')}}</label>
									<select id="s_neighbor" class="form-control s_region" name="store_neighbour" required>
										<OPTION value="">-Select Neighbour--</OPTION>
									</select>
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label for="s_other_neighbor">Other Neighbourhood</label>
									<input id="s_other_neighbor" name="s_other_neighbor" type="text" class="form-control" placeholder="" disabled="disabled">
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="s_street">{{trans('general.street')}}</label>
									<input id="s_street" name="store_street"  type="text" class="form-control"  value="{{old('s_street')}}" required>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="s_phone">{{trans('general.phone')}}</label>
									<input id="s_phone" name="store_phone" type="text" class="form-control"  value="{{Auth::user()->phone}}">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group col-sm-12 col-md-6">
									<label for="pick_date">{{trans('general.pick-date')}}</label>
									<input id="pick_date" name="pick_date" type="date"  class="form-control" min="{{Carbon\Carbon::today()->format('Y-m-d')}}" placeholder="">
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="pick_date">{{trans('general.pick-time')}}</label>
									<select class="form-control" name="pick_time">
										<option value="">--Select Time--</option>
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
						<div class="form-section">
							<div class="col-sm-12">
								<h3>{{trans('general.services')}}</h3>
								<div class="form-group col-xs-12 col-sm-3  form-inline">
									<label><input id="photo" type="checkbox" name="photo" value="1">&nbsp;{{trans('general.photography')}}</label>
								</div>
								<div class="form-group col-xs-12 col-sm-4">
									<label for="photo_quantity">{{trans('general.photo-quantity')}}</label>
									<input type="text" id="photo_quantity" name="photo_quantity" class="form-control" required disabled="disabled">
								</div>
								<div class="form-group col-xs-12 col-sm-5">
									<label for="photo_description">{{trans('general.photo-desc')}}</label>
									<input id="photo_description" type="text" name="photo_description" class="form-control" placeholder="PhotoGraphy Description" disabled="disabled">
								</div>
								<div class="form-group col-xs-12 col-sm-4">
									<label for="p_address">{{trans('general.photo-address')}}</label>
									<select class="form-control" name="PhotoAddress" id="p_address" disabled="disabled">
										<option value="same">{{trans('general.same-store')}}</option>
										<option value="other">{{trans('general.other-place')}}</option>
									</select>
								</div>
								<div class="form-group col-xs-12 col-sm-8">
									<label for="photo_address">{{trans('general.photo-place')}}</label>
									<input id="photo_address" type="text" name="photo_address" class="form-control" placeholder="Photography Address" disabled="disabled">
								</div>
							</div>
							<div class="col-sm-12">
								<h3>{{trans('general.details')}}</h3>

								<div class="form-group col-sm-12 col-md-4">
									<label for="contains">{{trans('client.shipment-contains')}}</label>
									<textarea id="contains" name="contains"  class="form-control" style="max-width: 100%" placeholder="Enter What Shipment Contains" required></textarea>
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label for="number">{{trans('client.number-it')}}</label>
									<input id="quantity" name="quantity" type="number" class="form-control" placeholder="Total Number of Items" required>
								</div>
								<div class="form-group col-xs-12 col-md-4">
									<label for="weight">{{trans('client.est-weight')}}</label>
									<select class="form-control" id="weight" name="weight" required>
										<option value="">--Select Weight--</option>
										<optgroup label="Less Than 16Kg">
											<option value="1-to-5">0-to-15Kg</option>
										</optgroup>
										<optgroup label="More Than 15Kg">
											@for($i=16;$i <= 100; $i++)
												<option value="{{$i}}">{{$i}} Kg</option>
											@endfor
										</optgroup>
									</select>
								</div>
							</div>
						</div>
						<div class="form-section">
							<input type="submit" value="{{trans('general.submit')}}" class="btn btn-primary">
						</div>
					</form>
					<script>
						$('#store').on('change',function(e){
							console.log(e);
							var store_id = e.target.value;

							if(store_id == 'other'){
								$('#other_store').removeClass('hidden');
								$('#hd').removeClass('hidden');
								$('#s_name').removeAttr("disabled");
								$('#s_country').removeAttr("disabled");
								$('#s_city').removeAttr("disabled");
								$('#s_region').removeAttr("disabled");
								$('#s_neighbor').removeAttr("disabled");
								$('#s_street').removeAttr("disabled");
								$('#s_phone').removeAttr("disabled");
								$('#store-address').attr("disabled","disabled");
							}
							else{
								$('#other_store').addClass('hidden');
								$('#s_name').attr("disabled","disabled");
								$('#s_city').attr("disabled","disabled");
								$('#s_region').attr("disabled","disabled");
								$('#s_neighbor').attr("disabled","disabled");
								$('#s_street').attr("disabled","disabled");
								$('#s_phone').attr("disabled","disabled");
								$('#store-address').removeAttr("disabled");
							}
						});

						$('#store-address').on('change',function(e){
							console.log(e);
							var store_id = e.target.value;
							$('#s_region').val('');

							if(store_id == 'other'){
								$('#other_store').removeClass('hidden');
								$('#hd').addClass('hidden');
								$('#s_name').attr("disabled","disabled");
								$('#s_city').removeAttr("disabled");
								$('#s_region').removeAttr("disabled");
								$('#s_neighbor').removeAttr("disabled");
								$('#s_street').removeAttr("disabled");
								$('#s_phone').removeAttr("disabled");

							}
							else{
								$('#other_store').addClass('hidden');
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
							$.get('../../../ajax-get-neighbors?city=' +city, function(data){
								$('#s_neighbor').empty();
								$('#s_neighbor').append('<option value="">--Select--</option>');
								$.each(data, function(index, neighborObj){
									$('#s_neighbor').append('<option value="'+neighborObj.id+'">'+neighborObj.name+'</option>');
								});
								$('#s_neighbor').append('<option value="0">Other</option>');


							});
						});


						$('#s_neighbor').on('change',function(e){
							console.log(e);
							var nr = e.target.value;
							if(nr == 0){
								$("#s_other_neighbor").removeAttr("disabled");
								$("#s_other_neighbor").focus();

							}

						});

					</script>
				</div>
			</div>
		</div>
	</section>
@endsection

