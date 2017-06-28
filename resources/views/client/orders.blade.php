@extends('layouts.master')
@section('meta-title')
	<meta name="description" content="">
	<meta name="author" content="">
	<title>{{trans('general.orders')}} | {{trans('general.tagline')}} </title>

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
							<h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">Orders</h1>
						</div>
						<ol class="breadcrumb">
							<li><a href="{{route('welcome',App::getLocale())}}">{{trans('menu.home')}}</a></li>
							<li><a href="{{route('client',App::getLocale())}}">{{trans('menu.client')}}</a></li>
							<li class="active">{{trans('menu.orders')}}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section-padding">
		<div class="container">
			<div class="row text-center">
				<h2>{{trans('client.my-orders-title')}}</h2>
				<div class="col-md-12">
					<div class="css-tab" role="tabpanel">
						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active"><a href="#pending-orders" aria-controls="pending-orders" role="tab" data-toggle="tab"><i class="flaticon-logistics15"></i>{{trans('general.pending-orders')}}</a></li>
							<li role="presentation"><a href="#delivered-orders" aria-controls="delivered-orders" role="tab" data-toggle="tab"><i class="flaticon-logistics18"></i> {{trans('general.completed-orders')}}</a></li>
							<li role="presentation"><a href="#other-orders" aria-controls="other-orders" role="tab" data-toggle="tab"><i class="flaticon-logistics18"></i>{{trans('general.photo-orders')}}</a></li>
						</ul>
						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active fade in" id="pending-orders">
								<div class="panel panel-default filterable {{(App::getLocale()==='ar')?'text-right':'text-left'}}">
									<div class="panel-heading">
										<h3 class="panel-title">{{trans('general.pending-orders')}}</h3>
									</div>
									<input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev-table" placeholder="Search By any column of table" />
									<div class="table-responsive">
										<table class="table" id="dev-table">
											<thead>
											<tr>
												<th>#{{trans('general.order-number')}}.</th>
												<th>{{trans('general.details')}}</th>
												<th>{{trans('general.date')}}</th>
												<th>{{trans('general.r_name')}}</th>
												<th>{{trans('general.status')}}</th>
												<th>{{trans('general.update')}}</th>
											</tr>
											</thead>
											<tbody>
											@foreach($pendingOrders as $order)
												<tr>
													<td>{{$order->ref_number}}</td>
													<td>{{$order->contains}}</td>
													<td>{{$order->created_at->format('d-m-Y')}}</td>
													<td>{{$order->r_name}}</td>
													<td>{{$order->status}} - {{(App::getLocale()== 'ar' and $order->statuses->description_ar == true)? $order->statuses->description_ar:$order->statuses->description}}</td>
													<td><a class="text-success" href="{{route('client.edit-order',array(App::getLocale(),$order->id))}}">Edit</a></td>
												</tr>
											@endforeach
											</tbody>
										</table>
										<script>
											(function(){
												'use strict';
												var $ = jQuery;
												$.fn.extend({
													filterTable: function(){
														return this.each(function(){
															$(this).on('keyup', function(e){
																$('.filterTable_no_results').remove();
																var $this = $(this),
																		search = $this.val().toLowerCase(),
																		target = $this.attr('data-filters'),
																		$target = $(target),
																		$rows = $target.find('tbody tr');

																if(search == '') {
																	$rows.show();
																} else {
																	$rows.each(function(){
																		var $this = $(this);
																		$this.text().toLowerCase().indexOf(search) === -1 ? $this.hide() : $this.show();
																	})
																	if($target.find('tbody tr:visible').size() === 0) {
																		var col_count = $target.find('tr').first().find('td').size();
																		var no_results = $('<tr class="filterTable_no_results"><td colspan="'+col_count+'">No results found</td></tr>')
																		$target.find('tbody').append(no_results);
																	}
																}
															});
														});
													}
												});
												$('[data-action="filter"]').filterTable();
											})(jQuery);
										</script>
									</div>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="delivered-orders">
								<div class="panel panel-default filterable {{(App::getLocale()==='ar')?'text-right':'text-left'}}">
									<div class="panel-heading">
										<h3 class="panel-title">{{trans('general.completed-orders')}}</h3>
									</div>
									<input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev2-table" placeholder="Filter By any column of table" />
									<div class="table-responsive">
										<table class="table" id="dev2-table">
											<thead>
											<tr>
												<th>#Order No.</th>
												<th>Details</th>
												<th>Order Date</th>
												<th>Receiver Name</th>
												<th>Status</th>
											</tr>
											</thead>
											<tbody>
											@foreach($deliveredOrders as $order)
												<tr>
													<td>{{$order->ref_number}}</td>
													<td>{{$order->contains}}</td>
													<td>{{$order->created_at->format('d-m-Y')}}</td>
													<td>{{$order->r_name}}</td>
													<td>{{$order->status}}</td>
												</tr>
											@endforeach
											</tbody>
											<script>
												(function(){
													'use strict';
													var $ = jQuery;
													$.fn.extend({
														filterTable: function(){
															return this.each(function(){
																$(this).on('keyup', function(e){
																	$('.filterTable_no_results').remove();
																	var $this = $(this),
																			search = $this.val().toLowerCase(),
																			target = $this.attr('data-filters'),
																			$target = $(target),
																			$rows = $target.find('tbody tr');

																	if(search == '') {
																		$rows.show();
																	} else {
																		$rows.each(function(){
																			var $this = $(this);
																			$this.text().toLowerCase().indexOf(search) === -1 ? $this.hide() : $this.show();
																		})
																		if($target.find('tbody tr:visible').size() === 0) {
																			var col_count = $target.find('tr').first().find('td').size();
																			var no_results = $('<tr class="filterTable_no_results"><td colspan="'+col_count+'">No results found</td></tr>')
																			$target.find('tbody').append(no_results);
																		}
																	}
																});
															});
														}
													});
													$('[data-action="filter"]').filterTable();
												})(jQuery);
											</script>
										</table>
									</div>
								</div>
							</div>

							<div role="tabpanel" class="tab-pane fade" id="other-orders">
								<div class="panel panel-default filterable {{(App::getLocale()==='ar')?'text-right':'text-left'}}">
									<div class="panel-heading">
										<h3 class="panel-title">{{trans('general.photo-orders')}}</h3>
									</div>
									<input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev2-table" placeholder="Filter By any column of table" />
									<div class="table-responsive">
										<table class="table" id="dev2-table">
											<thead>
											<tr>
												<th>#Order No.</th>
												<th>Order Contains</th>
												<th>Photo Description</th>
												<th>Photo Quantity</th>
												<td>Date</td>
												<th>Status</th>
												<th>Actions</th>
											</tr>
											</thead>
											<tbody>
											@foreach($photoOrders as $order)
												<tr>
													<td>{{$order->ref_number}}</td>
													<td>{{$order->contains}}</td>
													<td>{{@$order->photo_order->description}}</td>
													<td>{{@$order->photo_order->quantity}}</td>
													<td>{{$order->created_at->format('d-m-Y')}}</td>
													<td>{{$order->status}}</td>
													<td><a href="{{route('client.other-edit-order',array(App::getLocale(),$order->id))}}">Edit</a></td>
												</tr>
											@endforeach
											</tbody>
											<script>
												(function(){
													'use strict';
													var $ = jQuery;
													$.fn.extend({
														filterTable: function(){
															return this.each(function(){
																$(this).on('keyup', function(e){
																	$('.filterTable_no_results').remove();
																	var $this = $(this),
																			search = $this.val().toLowerCase(),
																			target = $this.attr('data-filters'),
																			$target = $(target),
																			$rows = $target.find('tbody tr');

																	if(search == '') {
																		$rows.show();
																	} else {
																		$rows.each(function(){
																			var $this = $(this);
																			$this.text().toLowerCase().indexOf(search) === -1 ? $this.hide() : $this.show();
																		})
																		if($target.find('tbody tr:visible').size() === 0) {
																			var col_count = $target.find('tr').first().find('td').size();
																			var no_results = $('<tr class="filterTable_no_results"><td colspan="'+col_count+'">No results found</td></tr>')
																			$target.find('tbody').append(no_results);
																		}
																	}
																});
															});
														}
													});
													$('[data-action="filter"]').filterTable();
												})(jQuery);
											</script>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div><!-- /.css-tab -->
				</div><!-- /.col-md-12 -->
			</div>
		</div>
	</section>
@endsection