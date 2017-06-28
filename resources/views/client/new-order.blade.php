@extends('layouts.master')
@section('meta-title')
	<meta name="description" content="">
	<meta name="author" content="">
	<title>{{trans('menu.new-order')}} | {{trans('general.tagline')}}</title>
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
	<script type="text/javascript">
		$(function () {
			$("#is_packing").change(function () {
				if($(this).is(":checked")) {
					$("#packing").removeAttr("disabled");
					$("#packing").focus();
					$("#packing_color").removeAttr("disabled");
				} else  {
					$("#packing").attr("disabled","disabled");
					$("#packing_color").attr("disabled","disabled");
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
							<h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">{{trans('client.new-order')}}</h1>
						</div>
						<ol class="breadcrumb">
							<li><a href="{{route('welcome',App::getLocale())}}">{{trans('menu.home')}}</a></li>
							<li><a href="{{route('client',App::getLocale())}}">{{trans('menu.client')}}</a></li>
							<li class="active">{{trans('menu.new-order')}}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section-padding">
		<div class="container">
			<div class="row">
				<h3 class="text-center text-white" style="background: #31708f; margin: 10px 50px 0px 50px;">{{trans('client.new-order-form-title')}} -{{trans('form.step1')}}</h3>
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
					<form method="post" action="{{route('client.new-order',App::getLocale())}}"  class="row" name="order_form">
						{{csrf_field()}}

						<div class="form-section">
							<div class="col-sm-12">
								<h3>{{trans('general.shipment-place')}}</h3>
								<!--store-selection-->
								@if(count($stores) > 0)
									<div class="form-group store-sec col-sm-6">
										<select id="store" name="store" class="form-control" required>
											<option value="">--{{trans('form.select-store')}}--</option>
											@foreach(@$stores as $store)
												<option value="{{@$store->id}}">{{@$store->name}}-{{@$store->street}}-{{@$store->city}}</option>
											@endforeach
											<option value="other">{{trans('general.other-place')}}</option>
										</select>
									</div>

									<div class="form-group store-address col-sm-6">
										<select id="store-address" name="store_address" class="form-control" required>
											<option value="">--Select Shipment Address--</option>
											<option value="same">{{trans('general.same-store')}}</option>
											<option value="other">{{trans('general.other-place')}}</option>
										</select>
									</div>
								@endif

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
										@foreach($neighbors as $neighbor)
											<OPTION value="{{$neighbor->id}}">{{$neighbor->name}}</OPTION>
										@endforeach
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
						<div class="form-section col-xs-12"><h3>{{trans('client.rcvr-info')}}</h3>
							<div class="form-group col-sm-12 col-md-6">
								<label for="r_type">{{trans('general.type')}}</label>
								<select name="r_type" id="r_type" class="form-control" required>
									<option value="">--Select Receiver Type--</option>
									@if(count($r_list) > 0)
									<option value="e">Existing Receiver</option>
									@endif
									<option value="n">New Receiver</option>
								</select>
							</div>
							<div class="form-group col-sm-11 col-md-5">
								<label for="r_search">Select Receiver</label>
								<select id="r_search" class="form-control" name="r_search" disabled="disabled" required>
									<OPTION value="">Receiver List</OPTION>
									@foreach($r_list as $r)
										<option value="{{$r->id}}">{{$r->name}}-{{$r->phone}}-{{$r->neighbor}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-sm-1 col-md-1" style="padding-top: 40px">
								<a data-toggle="modal" data-target="#srchRcvrModal" id="search_label" class="hidden"><i class="fa fa-search"></i> </a>
							</div>

							<div id="r_details" class="hidden">
								<div class="form-group col-sm-12 col-md-6">
									<label for="r_name">{{trans('form.name')}}</label>
									<input id="r_name" name="receiver_name" type="text" class="form-control" placeholder="" disabled="disabled" required>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="r_country">{{trans('form.country')}}</label>
									<select id="r_country" class="form-control country" name="receiver_country" disabled="disabled" required>

										<OPTION value="SA">Saudi Arabia</OPTION>
									</select>
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label for="r_city">{{trans('form.city')}}</label>
									<select  id="r_city" class="form-control city" name="receiver_city" disabled="disabled" required>
										<option value="">--Select City--</option>
										@foreach($r_cities as $city)
											<option value="{{$city->name}}">{{$city->name}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label for="r_neighbor">{{trans('general.neighbour')}}</label>
									<select id="r_neighbor" class="form-control r_region" name="receiver_neighbour" disabled="disabled" required>
										<OPTION value="">-Select Neighbor--</OPTION>
									</select>
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label for="r_other_neighbor">Other Neighbor</label>
									<input id="r_other_neighbor" name="r_other_neighbor" type="text" class="form-control"  placeholder="" disabled="disabled">
								</div>

								<div class="form-group col-sm-12 col-md-6">
									<label for="r_street">Street</label>
									<input id="r_street" name="receiver_street" type="text" class="form-control"  placeholder="">
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="r_phone">{{trans('form.mobile')}}</label>
									<div class="form-inline">
										<select class="form-control"><option value="00966">+966</option></select><input id="r_phone" name="receiver_phone" type="text" min="9" max="9" class="form-control" value="{{old('receiver_phone')}}" placeholder="591234567" required>
									</div>
								</div>
							</div>
						</div>

						<div class="form-section col-xs-12"><h3>{{trans('client.shipment-details')}}</h3>
							<div class="row">
								<div class="form-group col-sm-12 col-md-12">
									<label for="contains">{{trans('client.shipment-contains')}}</label>
									<textarea id="contains" name="contains"  class="form-control" style="max-width: 100%" placeholder="Enter What Shipment Contains"  required>{{old('contains')}}</textarea>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-xs-12 col-sm-6 col-md-6">
									<label for="number">{{trans('client.number-it')}}</label>
									<input id="quantity" name="quantity" type="number" class="form-control" placeholder="Total Number of Items" value="{{old('quantity')}}" required>
								</div>
								<div class="form-group col-sm-12 col-sm-6 col-md-6">
									<label for="weight">{{trans('client.est-weight')}}</label>
									<select class="form-control" id="weight" name="weight" required>
										<option value="">--Select Weight--</option>
										<optgroup label="Less Than 16Kg">
											<option value="1-to-15">0-to-15Kg</option>
										</optgroup>
										<optgroup label="More Than 15Kg">
											@for($i=16;$i <= 100; $i++)
												<option value="{{$i}}">{{$i}} Kg</option>
											@endfor
										</optgroup>
									</select>
								</div>
								<div class="form-group col-sm-12 col-md-4 form-inline hidden">
									<!--<label for="shipment_amount">Shipment Price</label><br>
									<input id="shipment_amount" name="shipment_amount" class="form-control" type="text" placeholder="Shipment Amount">
									<input id="insurance_amount"  name="insurance_amount" class="form-control" type="hidden" placeholder="Insurance Amount" value="" readonly>
									-->
									<label><input id="is_insurance" type="checkbox" hidden="true" name="insurance" value="1">&nbsp;Insurance</label>
								</div>

							</div>
							<h3>{{trans('general.other-services')}}</h3>
							<div class="row">
								<div class="form-group col-xs-12 col-sm-3  form-inline">
									<label><input id="is_packing" type="checkbox" name="is_packing" value="1">&nbsp;{{trans('general.packing')}}</label>
								</div>
								<div class="form-group col-xs-12 col-sm-5">
									<label for="packing">{{trans('general.packing')}}</label>
									<select class="form-control" id="packing" name="packing" disabled>
										<option value="">none</option>
										@foreach($packings as $packing)
											<option value="{{$packing->id}}">{{$packing->packing_type}}-{{$packing->packing_size}}-{{$packing->packing_lwh}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group col-xs-12 col-sm-4">
									<label for="packing_color">{{trans('general.packing-color')}}</label>
									<select class="form-control" id="packing_color" name="packing_color" disabled>
										<option value="">None</option>
										<option value="black">Black</option>
									</select>
								</div>
							</div>

							<div class="row">
								<div class="form-group col-xs-12">
									<label for="spl_req">{{trans('general.spl-req')}}</label>
									<textarea name="spl_req" id="spl_req" class="form-control" style="max-width: 100%" placeholder="Any Special Requirement? Please write here."></textarea>
								</div>
							</div>
						</div>


						<div class="form-section">
							<input id="submit" disabled="disabled" type="submit" value="{{trans('general.next')}}" class="btn btn-primary" onclick="return formSubmit(); return false">
						</div>

						<!-- Modal -->
						<div class="modal fade" id="srchRcvrModal" role="dialog">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Search Receiver</h4>
									</div>
									<div class="modal-body">
										<div class="form-group">
											<input type="text" id="search_box" name="search_box" class="form-control" placeholder="Type Receiver Name or Mobile">
										</div>
										<div class="form-group">
											<input type="submit" id="btn_search"  class="btn btn-primary">
										</div>
									</div>
									<div class="modal-footer">
										<a href="#" data-dismiss="modal">x</a>
									</div>
								</div>

							</div>
						</div>
						<script>
							$(function(){
								var url = "{{ url('/ajax-search-receiver/receiver') }}";
								$("#btn_search").click(function (e) {

									e.preventDefault();

										var search = $('#search_box').val();
									$.get(url+'?search='+search, function (data) {
										//success data
										console.log(data);

										$('#srchRcvrModal').toggle();
										$('body').removeClass('modal-open');
										$('#r_search').empty();
										$('#r_search').focus();
										$('#r_search').append('<option value="">--Select--</option>');
										$.each(data, function(index, obj){
											$('#r_search').append('<option value="'+obj.id+'">'+obj.name+','+obj.neighbor+','+obj.city+','+obj.phone+'</option>');
										});
									})

								});



							});

							$(function(){
								$("#r_type").change(function(){
									var r_type = $(this) ;
									if(r_type.val() == 'e') {
										$('#search_label').removeClass("hidden");
										$('#r_search').removeAttr("disabled");
										$('#r_name').attr("disabled","disabled");
										$('#r_country').attr("disabled","disabled");
										$('#r_city').attr("disabled","disabled");
										$('#r_neighbor').attr("disabled","disabled");
										$('#r_other_neighbor').attr("disabled","disabled");
										$('#r_street').attr("disabled","disabled");
										$('#r_phone').attr("disabled","disabled");
										$('#r_phone').attr("disabled","disabled");
										$('#r_details').addClass("hidden");
									}
									else{
										$('#search_label').addClass("hidden");
										$('#r_search').attr("disabled","disabled");
										$('#r_details').removeClass("hidden");
										$('#r_name').removeAttr("disabled");
										$('#r_country').removeAttr("disabled");
										$('#r_city').removeAttr("disabled");
										$('#r_neighbor').removeAttr("disabled");
										$('#r_other_neighbor').removeAttr("disabled");
										$('#r_street').removeAttr("disabled");
										$('#r_phone').removeAttr("disabled");
										$('#r_phone').removeAttr("disabled");
									}
								});


							});

							/*$(function(){
								$("#r_search").change(function(){
									var r = $(this) ;
									if(r.val() == '' || r.val() == 'Other') {
										$('#r_name').removeAttr("disabled");
										$('#r_country').removeAttr("disabled");
										$('#r_city').removeAttr("disabled");
										$('#r_neighbor').removeAttr("disabled");
										$('#r_other_neighbor').removeAttr("disabled");
										$('#r_street').removeAttr("disabled");
										$('#r_phone').removeAttr("disabled");
										$('#r_phone').removeAttr("disabled");
										$('#r_details').removeClass("hidden");
									}
									else{
										$('#r_name').attr("disabled","disabled");
										$('#r_country').attr("disabled","disabled");
										$('#r_city').attr("disabled","disabled");
										$('#r_neighbor').attr("disabled","disabled");
										$('#r_other_neighbor').attr("disabled","disabled");
										$('#r_street').attr("disabled","disabled");
										$('#r_phone').attr("disabled","disabled");
										$('#r_phone').attr("disabled","disabled");
										$('#r_details').addClass("hidden");
									}
								});
							});*/

							$(function(){
								$("#r_type").change(function(){
									if($(this).val() == 'e'){
										$("#submit").removeAttr("disabled");
									}
									else{
										$("#submit").attr("disabled","disabled");
										$("#r_phone").change(function() {
											if($(this).val().length == 9) {
												$("#submit").removeAttr("disabled");
											} else {
												alert("Receiver phone digit length must be equal to 9");
												$(this).focus();
												$("#submit").attr("disabled","disabled");
											}
										});
									}

								});
							});
							$(function(){
								$(".city").change(function(){
									var el = $(this) ;
									if(el.val() !== 'Riyadh') {
										$("#cod_pay").attr("disabled","disabled");
									}
									else{
										$("#cod_pay").removeAttr("disabled");
									}
								});
							});


							$('#shipment_amount').on('change',function(e){
								console.log(e);
								var shipment_amount = e.target.value;
								if(shipment_amount > 500){
									$.get('../../../insurance-calc?shipment_amount=' + shipment_amount, function(data){
										$('#insurance_amount').removeAttr('type','hidden');
										$('#insurance_amount').empty();
										$("#insurance_amount").val(data);
										$('#insurance_label').removeAttr('hidden');
									});
								}
								else{
									$('#insurance_amount').attr('type','hidden');
									$('#insurance_amount').empty();
									$("#insurance_amount").val(0);
									$('#insurance_label').attr('hidden','true');
									$('#insurance_apply').removeClass('show');
								}
							});

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
								$.get('../../ajax-get-neighbors?city=' +city, function(data){
									$('#s_neighbor').empty();
									$('#s_neighbor').append('<option value="">--Select--</option>');
									$.each(data, function(index, neighborObj){
										$('#s_neighbor').append('<option value="'+neighborObj.id+'">'+neighborObj.name+'</option>');
									});
									$('#s_neighbor').append('<option value="0">Other</option>');


								});
							});




							$('#r_city').on('change',function(e){
								console.log(e);
								var city = e.target.value;
								$.get('../../ajax-get-neighbors?city=' +city, function(data){
									$('#r_neighbor').empty();
									$('#r_neighbor').append('<option value="">--Select--</option>');

									$.each(data, function(index, neighborObj){
										$('#r_neighbor').append('<option value="'+neighborObj.id+'">'+neighborObj.name+'</option>');
									});
									$('#r_neighbor').append('<option value="0">Other</option>');


								});
							});

							$('#s_neighbor').on('change',function(e){
								console.log(e);
								var nr = e.target.value;
								if(nr == 0){
									$("#s_other_neighbor").removeAttr("disabled");
									$("#s_other_neighbor").focus();

								}
								else{
									$("#s_other_neighbor").attr("disabled","disabled");
									$("#s_other_neighbor").val("");
								}

							});

							$('#r_neighbor').on('change',function(e){
								console.log(e);
								var nr = e.target.value;
								if(nr == 0){
									$("#r_other_neighbor").removeAttr("disabled");
									$("#r_other_neighbor").focus();

								}
								else{
									$("#r_other_neighbor").attr("disabled","disabled");
									$("#r_other_neighbor").val("");
								}

							});


							$('#packing').on('change',function(e){
								console.log(e);
								var packing_id = e.target.value;

								$.get('../../ajax-packing-color?packing_id=' + packing_id, function(data){
									$('#packing_color').empty();
									$.each(data, function(index, obj){
										$('#packing_color').append('<option value="'+obj.color+'">'+obj.color+'</option>');
									})
								});
							});
						</script>
					</form>
				</div>
			</div>
		</div>
	</section>
@endsection