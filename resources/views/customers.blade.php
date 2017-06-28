@extends('layouts.master')
@section('meta-title')
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Fast Star Customers</title>
@endsection
@section('custom-css')
<style>
	@charset "utf-8";
	/* CSS Document */


	.customers{
		padding: 112px 0 67px;
		background: #f5f6f8;
	}
	.our-customer {
		padding-top: 120px;
	}

	.our-customer .team-member {
		margin-bottom: 45px;
	}

	/*team thumbnail overlay*/

	.customer-thumbnail {
		position: relative;
		padding: 4px;
		background: #f4f4f4;
	}

	.customer-thumbnail img {
		width: 100%;
	}

	.customer-thumbnail::before {
		content: "";
		background-color: rgba(101, 211, 227, 0.8);
		position: absolute;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		opacity: 0;
	}

	.customer-thumbnail:hover::before {
		opacity: 1;
	}

	.customer-link {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		line-height: 28px;
		text-align: center;
		background: transparent;
	}

	.customer-link i {
		display: block;
		margin-top: 20%;
		height: 50px;
		line-height: 50px;
		color: #fff;
	}

	.customer-link i:before {
		font-size: 0;
	}

	.customer-thumbnail:hover .customer-link i:before {
		opacity: 1;
		font-size: 50px;
	}

	.customer-thumbnail::before,
	.customer-link i:before {
		-webkit-transition: all 0.3s ease 0s;
		-moz-transition: all 0.3s ease 0s;
		-o-transition: all 0.3s ease 0s;
		transition: all 0.3s ease 0s;
	}


	/*member-info*/

	.customer-info {
		text-align: center;
		margin-top: 10px;
	}

	.customer-info h3 {
		line-height: 24px;
		text-transform: uppercase;
		font-family: Source Sans Pro;
		font-size: 16px;
		font-weight: 700;
		margin: 0;
	}

	.customer-info small {
		display: block;
		font-size: 14px;
		color: #7B8A97;
		font-weight: 500;
		text-transform: capitalize;
	}
</style>
@endsection
@section('content')
	<section class="page-title-section">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="page-header-wrap {{(App::getLocale() === 'ar') ? 'breadcrumb-right':''}}">
						<div class="page-header">
							<h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">{{trans('customers.page-title')}}</h1>
						</div>
						<ol class="breadcrumb">
							<li><a href="{{route('home',App::getLocale())}}">{{trans('menu.home')}}</a></li>
							<li class="active">{{trans('menu.customers')}}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- team-->
	<section class="customers">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 text-center">
					<h2 class="section-title">{{trans('customers.page-title')}}</h2>
					<span class="section-sub">{!! trans('customers.description')!!}</span>
				</div>
			</div>

			<div class="our-customer">
				@foreach($customers->chunk(6) as $items)
				<div class="row">
					@foreach($items as $cust)
					<div class="col-sm-2 col-xs-4">
						<figure class="customer">
							<div class="customer-thumbnail">
								<img src="{{url('img/customers/'.$cust->logo)}}" alt="Image">
								<a class="customer-link" href="{{$cust->link}}" title=""><i class="fa fa-link"></i></a>
							</div>
							<div class="customer-info">
								<h3>{{(App::getLocale() == 'ar')? $cust->name_ar:$cust->name}}</h3>
							</div>
						</figure>
					</div><!-- /.col-->
					@endforeach
				</div><!-- /.row-->
				@endforeach

			</div><!-- /.our-customer -->
			{{$customers->links()}}
		</div><!-- /.container-->
	</section>
	<!-- /.team-->


@endsection