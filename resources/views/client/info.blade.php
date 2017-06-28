@extends('layouts.master')
@section('meta-title')
	<meta name="description" content="" xmlns="http://www.w3.org/1999/html">
	<meta name="author" content="">
	<title>Client Info | Fast Star for Delivery</title>
@endsection
@section('custom-css')
	<style>
		/* edit profile css*/

		.profile-head { width:100%;background-color: #31708f;float: left;padding: 15px 5px;}
		.profile-head img { height:150px; width:150px; margin:0 auto; border:5px solid #fff; border-radius:5px;}
		.profile-head h5 {width: 100%;padding:5px 5px 0px 5px;text-align:justify;font-weight: bold;color: #fff;font-size: 25px;text-transform:capitalize;
			margin-bottom: 0;}
		.profile-head p {width: 100%;text-align: justify;padding:0px 5px 5px 5px;color: #fff;font-size:17px;text-transform:capitalize;margin:0;}
		.profile-head a {width: 100%;text-align: center;padding: 10px 5px;color: #fff;font-size: 15px;text-transform: capitalize;}

		.profile-head ul { list-style:none;padding: 0;}
		.profile-head ul li { display:block; color:#ffffff;padding:5px;font-weight: 400;font-size: 15px;}
		.profile-head ul li:hover span { color:rgb(0, 4, 51);}
		.profile-head ul li span { color:#ffffff;padding-right: 10px;}
		.profile-head ul li a { color:#ffffff;}
		.profile-head h6 {width: 100%;text-align: center;font-weight: 100;color: #fff;font-size: 15px;text-transform: uppercase;margin-bottom: 0;}


		.nav-tabs {margin: 0;padding: 0;border: 0;}
		.nav-tabs > li > a {background: #DADADA;border-radius: 0;
			box-shadow: inset 0 -8px 7px -9px rgba(0,0,0,.4),-2px -2px 5px -2px rgba(0,0,0,.4);}
		.nav-tabs > li.active > a,
		.nav-tabs > li.active > a:hover {background: #F5F5F5;
			box-shadow: inset 0 0 0 0 rgba(0,0,0,.4),-2px -3px 5px -2px rgba(0,0,0,.4);}
		.tab-pane {background: #ffffff;box-shadow: 0 0 4px rgba(0,0,0,.4); width: 100%; border-radius: 0;text-align: center;}
		.tab-content>.active {margin-top:50px;/*width:100% !important;*/}

		.hve-pro {    background-color:#31708f;padding: 5px; width:96%; height:auto;}
		.hve-pro p {color:#fff;font-size: 15px;text-transform: capitalize;padding: 5px 20px;font-family: 'Noto Sans', sans-serif;}
		h2.register { padding:10px 25px; text-transform:capitalize;font-size: 25px;color: #31708f;}
		.fom-main { overflow:hidden;}

		legend {font-family: 'Bitter', serif;color:#31708f;border-bottom:0px solid;}
		label.control-label {font-family: 'Noto Sans', sans-serif;font-weight: 100; margin-bottom:5px !important;
			 !important; text-transform:uppercase; color:#798288; padding: 10px 10px 10px 10px;}
		.submit-button {color: #fff;background-color:#31708f;width:190px;border: 0px solid;border-radius: 0px; transition:all ease 0.3s;margin: 5px;
			float:left;}
		.submit-button:hover, .submit-button:focus {color: #fff;background-color:rgb(0, 4, 51);}
		.hint_icon {color:#31708f;}
		.form-control:focus {border-color: #31708f;}
		select.selectpicker { color:#99999c;}
		select.selectpicker option { color:#000 !important;}
		select.selectpicker option:first-child { color:#99999c;}
		.input-group { width:100%;}
		h4.pro-title { font-size:24px; color:rgba(0, 4, 51, 0.96); text-transform:capitalize; text-align:justify;padding: 10px 15px;font-family: 'Bitter', serif;}
		.bio-table { width:75%;border:0px solid;}
		.bio-table td {text-transform: capitalize;text-align: left;font-size: 15px;}
		.bio-table>tbody>tr>td { border:0px solid;text-transform: capitalize;color: rgb(0, 4, 51); font-size:15px;}
		.responsiv-table { border:0px solid;}
		.nav-menu li a {margin: 5px 5px 5px 5px;position: relative;display: block;padding: 10px 50px;border: 0px solid !important;box-shadow: none !important;
			background-color: rgb(0, 4, 51) !important;color: #fff !important;    white-space: nowrap;}
		.nav-menu li.active a {background-color: #31708f !important;}
		.stick{position:fixed !important;top:0;z-index:999 !important;width:100%;background:#ffffff !important;height:auto; transition:all ease 0.8s;
			-webkit-box-shadow: 0px 2px 7px 0px rgba(0,0,0,0.75);
			-moz-box-shadow: 0px 2px 7px 0px rgba(0,0,0,0.75);
			box-shadow: 0px 2px 7px 0px rgba(0,0,0,0.75);}
		.stick a { line-height:20px !important;}
		.stick img { margin:0 !important;}
	</style>
@endsection
@section('content')
	<?php $user = Auth::user(); ?>
	<section class="page-title-section">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="page-header-wrap {{(App::getLocale() === 'ar') ? 'breadcrumb-right':''}}">
						<div class="page-header">
							<h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">{{trans('client.info')}}</h1>
						</div>
						<ol class="breadcrumb">
							<li><a href="{{route('welcome',App::getLocale())}}">{{trans('menu.home')}}</a></li>
							<li><a href="{{route('client',App::getLocale())}}">{{trans('menu.client')}}</a></li>
							<li class="active">{{trans('menu.info')}}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="section-padding">
		<div class="container" style="margin-top: 30px; background: #31708f">
			<div class="profile-head">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<h5>{{(@$account->fullname)? $account->fullname:$user->name}}</h5>
					<ul><li><span>{{trans('general.phone')}}:</span><a href="#" title="call">{{@$user->phone}}</a></li>
						<li><span>{{trans('general.iban')}}:</span> <a href="#" title="call">{{@$account->iban}}</a></li>
					</ul>
				</div><!--col-md-4 col-sm-4 col-xs-12 close-->


				<div class="col-md-6 col-sm-6 col-xs-10">
					<h5>{{trans('info.account-details')}}</h5>
					<p>
						<span><b>{{trans('info.wallet-amount')}}: </b>{{@$account->wallet_amount}} {{trans('general.sar')}} </span>
					</p>
					@if(Auth::user()->accounts != null and (Auth::user()->accounts->package_inside != null or Auth::user()->accounts->package_outside != null ))
					<p>
						<?php $now = time();?>
						<span><b>{{trans('info.package-inside')}}: </b>{{@$account->package_inside_quantity}} {{trans('info.orders-left')}} - </span>{{@$account->inValid(@$account->package_inside_validity)}} {{trans('info.days-remaining')}}<br>
						<span><b>{{trans('info.package-outside')}}: </b>{{@$account->package_outside_quantity}} {{trans('info.orders-left')}} - </span>{{@$account->outValid(@$account->package_outside_validity)}}  {{trans('info.days-remaining')}}<br>
					</p>
					@endif
				</div><!--col-md-8 col-sm-8 col-xs-12 close-->
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <a href="{{(@$account->user_id == $user->id)?route('client.edit-account',App::getLocale()):route('client.create-account',App::getLocale())}}" class="btn btn-primary btn-sm" style="width:auto; margin-left: -50px; padding: 10px">
						{{(@$account->user_id == $user->id)?trans('form.edit-account'):trans('general.account-create-title')}}
					</a>
                </div>
			</div><!--profile-head close-->

		</div><!--container close-->


		<div id="sticky" class="container">

			<!-- Nav tabs -->
			<ul class="nav nav-tabs nav-menu" role="tablist">
				<li class="active">
					<a href="#stores" role="tab" data-toggle="tab">
						<i class="fa fa-home"></i> {{trans('info.my-stores')}}
					</a>
				</li>
				@if(Auth::user()->accounts)
				<li><a href="#new-store" role="tab" data-toggle="tab">
						<i class="fa fa-key"></i> {{trans('info.new-store')}}
					</a>
				</li>
				<li><a href="#transactions" role="tab" data-toggle="tab">
						<i class="fa fa-money"></i> {{trans('info.my-transactions')}}
					</a>
				</li>
				@endif
			</ul><!--nav-tabs close-->

			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane fade active in" id="stores">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive" style="width: 97%; margin-left:0; padding-top:10px;">
									<table class="table">
										<tbody>
										<tr style="background: #133d55">
											<th class="text-center">{{trans('general.s-no')}}</th>
											<th class="text-center">{{trans('general.store-name')}}</th>
											<th class="text-center">{{trans('general.street')}}</th>
											<th  class="text-center">{{trans('general.neighbour')}}</th>
											<th  class="text-center">{{trans('general.city')}}</th>
											<th class="text-center">{{trans('form.edit')}}</th>
											<th class="text-center">{{trans('form.remove')}}</th>
										</tr>
										<?php $i =1; ?>
										@foreach(@$stores as $store)
										<tr class="info">
											<td>{{@$i++}}</td>
											<td>{{@$store->name}}</td>
											<td>{{@$store->street}}</td>
											<td>{{@$store->neighbors->name}}</td>
											<td>{{@$store->city}}</td>
											<td><a href="{{route('client.edit-store',array(App::getLocale(),$store->id))}}"  class="btn btn-sm btn-info">{{trans('form.update')}}</a></td>
											<td><a href="{{route('client.delete-store',array(App::getLocale(),$store->id))}}" onclick="return confirm('Are you sure?')"  class="btn btn-sm btn-danger">{{trans('form.delete')}}</a></td>
										</tr>
										@endforeach
										</tbody>
									</table>
								</div><!--table-responsive close-->
							</div><!--col-md-12close-->

						</div><!--row close-->
					</div><!--container close-->
				</div><!--tab-pane close-->


				<div class="tab-pane fade" id="new-store">
					<div class="form-main" style="padding: 30px">
						<div class="row">
							<div class="col-sm-12">
								<h2 class="register">{{trans('info.new-store')}}</h2>
							</div><!--col-sm-12 close-->

						</div><!--row close-->
						<br />
						<div class="row text-left">
							<form  method="post" action="{{route('client.create-store',App::getLocale())}}">
								{{csrf_field()}}
								<div class="form-section col-xs-12">
									<div class="row">
										<input type="hidden" name="country" value="SA">
										<div class="form-group col-sm-11 col-md-6">
											<label for="name" class="{{App::getLocale() == 'ar'?'pull-right':''}}">{{trans('form.store-name')}}</label>
											<input type="text" id="name" name="name"  class="form-control" placeholder="Enter Store/Shop Name" required>
										</div>

										<div class="form-group col-sm-11 col-md-6">
											<label for="activity" class="{{App::getLocale() == 'ar'?'pull-right':''}}">{{trans('form.activity')}}</label>
											<input type="text" id="activity" name="activity" class="form-control">
										</div>
									</div>
									<div class="row">
										<div class="form-group col-sm-11 col-md-6">
											<label for="city" class="{{App::getLocale() == 'ar'?'pull-right':''}}">{{trans('form.city')}}</label>
											<select class="form-control" id="s_city" name="city" required>
												<option value="">--Select City--</option>
												@foreach($cities as $city)
													<option value="{{$city->name}}">{{$city->name}}</option>
												@endforeach
											</select>
										</div>
										<script>
											$('#s_city').on('change',function(e){
												console.log(e);
												var city = e.target.value;
												$.get('../ajax-get-neighbors?city=' +city, function(data){
													$('#s_neighbor').empty();
													$.each(data, function(index, obj){
														$('#s_neighbor').append('<option value="'+obj.id+'">'+obj.name+'</option>');
													})
												});
											});
										</script>
										<div class="form-group col-sm-11 col-md-6">
											<label for="region" class="{{App::getLocale() == 'ar'?'pull-right':''}}">{{trans('form.neighbour')}}</label>
											<select class="form-control" id="s_neighbor" name="neighbourhood" required>
												<option value="">--Select--</option>
											</select>
										</div>

										<div class="form-group col-sm-12 col-md-6">
											<label for="street" class="{{App::getLocale() == 'ar'?'pull-right':''}}">{{trans('form.street')}}</label>
											<input id="street" name="street" type="text" class="form-control" placeholder="Enter Street">
										</div>

										<div class="form-group col-sm-12 col-md-6">
											<label for="phone" class="{{App::getLocale() == 'ar'?'pull-right':''}}">{{trans('form.mobile')}}</label>
											<input id="phone" name="phone" type="text" class="form-control" placeholder="Enter Mobile or Phone Number">
										</div>
									</div>
									<div class="row">
										<input type="submit" value="{{trans('general.submit')}}" class="btn btn-primary">
									</div>
								</div>
							</form>
						</div><!--row close-->
					</div><!--container close -->
				</div><!--tab-pane close-->

				<div class="tab-pane fade" id="transactions">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive" style="width: 97%; margin-left:0; padding-top:10px;">
									<table class="table">
										<tbody>
										<tr style="background: #133d55">
											<th class="text-center">{{trans('general.s-no')}}</th>
											<th class="text-center">{{trans('general.transaction-name')}}</th>
											<th class="text-center">{{trans('general.reference')}}</th>
											<th  class="text-center">{{trans('general.before')}}</th>
											<th  class="text-center">{{trans('general.type')}}</th>
											<th  class="text-center">{{trans('general.amount')}}</th>
											<th  class="text-center">{{trans('general.balance')}}</th>
											<th  class="text-center">{{trans('general.attachment')}}</th>
										</tr>
										<?php $i =1; ?>
										@foreach(@$transactions as $item)
											<tr class="info">
												<td>{{@$i++}}</td>
												<td>{{@$item->name}}</td>
												<td>{{@$item->reference}}</td>
												<td>{{@$item->balance_before}}</td>
												<td>{{@$item->type}}</td>
												<td>{{@$item->amount}}</td>
												<td>{{@$item->balance}}</td>
												<td>
													@if($item->file == true)
													<a class="text-success" href="{{url('files/transactions/'.$item->file)}}" download="{{'Fast-Star-Transaction-'.$item->reference}}">Attchment Download</a>
													@endif
												</td>
											</tr>
										@endforeach
										</tbody>
									</table>
								</div><!--table-responsive close-->
							</div><!--col-md-12close-->

						</div><!--row close-->
					</div><!--container close-->
				</div><!--tab-pane close-->

			</div><!--tab-content close-->
		</div><!--container close-->
	</section><!--section close-->
@endsection