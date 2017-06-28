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
							<h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">{{trans('general.edit-account')}}</h1>
						</div>
						<ol class="breadcrumb">
							<li><a href="{{route('welcome',App::getLocale())}}">{{trans('menu.home')}}</a></li>
							<li><a href="{{route('client',App::getLocale())}}">{{trans('menu.client')}}</a></li>
							<li class="active">{{trans('general.edit-account')}}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section-padding">
		<div class="container">
			<div class="row">
				<h3 class="text-center text-white" style="background: #31708f; margin: 10px 50px 0px 50px;">{{trans('general.edit-account')}}</h3>

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
					<form method="post" action="{{route('client.edit-account',App::getLocale())}}"  class="row">
						{{csrf_field()}}
						<div class="form-section col-xs-12"><h3>Edit Your Account</h3>
							<div class="row">

								<div class="form-group col-sm-12 col-md-4">
									<label for="bank_name">{{trans('form.bank_name')}}</label>
									<input id="bank_name" name="bank_name" type="text" class="form-control" value="{{$account->bank_name or old('bank_name')}}">
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label for="fullname">{{trans('form.fullname')}}</label>
									<input type="text" id="fullname" name="fullname"  class="form-control" value="{{$account->fullname or old('fullname')}}" required>
								</div>
								<div class="form-group col-sm-12 col-md-4">
									<label><b>SA-</b></label>
									<input type="number" id="iban" name="iban" class="form-control" placeholder="only numbers" style="width: 80%">
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

