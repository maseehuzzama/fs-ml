@extends('layouts.master')
@section('meta-title')
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Contact | Fast Star for Delivery</title>
@endsection
@section('content')
	<section class="page-title-section">
		<div class="container">
			<div class="page-header-wrap {{(App::getLocale() === 'ar') ? 'breadcrumb-right':''}}">
				<div class="page-header">
					<h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">{{trans('contact.page-title')}}</h1>
				</div>
				<ol class="breadcrumb">
					<li><a href="{{route('home',App::getLocale())}}">{{trans('menu.home')}}</a></li>
					<li class="active">{{trans('menu.contact')}}</li>
				</ol>
			</div>
		</div>
	</section>

	<section class="contact-info-section">
		<div class="container">
			<div class="text-center">
				<h2 class="section-title">{{trans('contact.title')}}</h2>
				<span class="section-sub">{!! trans('contact.info') !!}</span>
			</div>

			<div class="row content-row">

				<div class="col-md-7">
					<div class="contact-map">
						<h3>{{trans('contact.form-title')}}</h3>
						@include('partials.flash')
						<form id="mainContact" action="{{route('send-email',App::getLocale())}}" method="POST">
							{{csrf_field()}}
							<div class="form-group">
								<label for="name">{{trans('form.name')}}</label>
								<input name="name" type="text" class="form-control"  required="" placeholder="">
							</div>
							<div class="form-group">
								<label for="email">{{trans('form.email')}}</label>
								<input name="email" type="email" class="form-control" required="" placeholder="">
							</div>

							<div class="form-group">
								<label for="subject">{{trans('form.subject')}}</label>
								<input name="subject" type="text" class="form-control" required="" placeholder="">
							</div>


							<div class="row">

								<div class="col-md-6">
									<div class="form-group">
										<label for="phone">{{trans('form.phone')}}</label>
										<input name="phone" type="text" class="form-control" placeholder="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="company">{{trans('form.company')}}</label>
										<input name="company" type="text" class="form-control" placeholder="">
									</div>
								</div>
							</div>
							<div class="form-group text-area">
								<label for="message">{{trans('form.message')}}</label>
								<textarea name="message" class="form-control" rows="6" required="" placeholder=""></textarea>
							</div>

							<button type="submit" class="btn btn-primary">{{trans('form.send-message')}}</button>
						</form>
					</div>
				</div>

				<div class="col-md-5">
					<div class="contact-info">
						<h3>{{trans('contact.address-title')}}</h3>

						<address>
							{!! trans('contact.address-info') !!}<br>
							{{trans('form.phone')}} : 966555246993<br>
							{{trans('form.email')}} : info@faststardlv.com<br>
						</address>
					</div><!-- /.contact-info -->

					<div class="contact-map">
						<h3>{{trans('contact.loc-title')}}</h3>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3625.314613996956!2d46.72606951417474!3d24.681709358478756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e2f04734c136da7%3A0xc835e4bc4c42fe3c!2sAl+Mutanabbi%2C+Riyadh+Saudi+Arabia!5e0!3m2!1sen!2sin!4v1492862209743"
                                style="width: 100%; height: 350px;" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div><!-- /.contact-info -->

				</div>
			</div>
		</div>
	</section>

@endsection