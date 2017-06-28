<!DOCTYPE html>
<html lang="{{App::getLocale()}}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('meta-title')

	<!-- Web Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900,200italic,300italic,400italic,600italic,700italic,900italic' rel='stylesheet' type='text/css'>
	<!-- Bootstrap Core CSS -->
	<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
	@if(App::getLocale()=== 'ar')
	<link href="{{asset('assets/css/bootstrap-rtl.min.css')}}" rel="stylesheet">
	@endif
	<!-- Flaticon CSS -->
	<link href="{{asset('assets/fonts/flaticon/flaticon.css')}}" rel="stylesheet">
	<!-- font-awesome CSS -->
	<link href="{{asset('assets/css/font-awesome.min.css')}}" rel="stylesheet">
	<!-- Offcanvas CSS -->
	<link href="{{asset('assets/css/hippo-off-canvas.css')}}" rel="stylesheet">
	<!-- animate CSS -->
	<link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">
	<!-- language CSS -->
	<link href="{{asset('assets/css/language-select.css')}}" rel="stylesheet">
	<!-- owl.carousel CSS -->
	<link href="{{asset('assets/owl.carousel/assets/owl.carousel.css')}}" rel="stylesheet">
	<!-- magnific-popup -->
	<link href="{{asset('assets/css/magnific-popup.css')}}" rel="stylesheet">
	<!-- Main menu -->
	<link href="{{asset('assets/css/menu.css')}}" rel="stylesheet">
	<!-- Template Common Styles -->
	<link href="{{asset('assets/css/template.css')}}" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
	<!-- Responsive CSS -->
	<link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet">

	<script src="{{asset('assets/js/vendor/modernizr-2.8.1.min.js')}}"></script>
	<!-- HTML5 Shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="{{asset('assets/js/vendor/html5shim.js')}}"></script>
	<script src="{{asset('assets/js/vendor/respond.min.js')}}"></script>
	<![endif]-->


    <!-- jQuery -->
    <script src="{{asset('assets/js/jquery.js')}}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <!-- owl.carousel -->
    <script src="{{asset('assets/owl.carousel/owl.carousel.min.js')}}"></script>
    <!-- Magnific-popup -->
    <script src="{{asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
    <!-- Offcanvas Menu -->
    <script src="{{asset('assets/js/hippo-offcanvas.js')}}"></script>
    <!-- inview -->
    <script src="{{asset('assets/js/jquery.inview.min.js')}}"></script>
    <!-- stellar -->
    <script src="{{asset('assets/js/jquery.stellar.js')}}"></script>
    <!-- countTo -->
    <script src="{{asset('assets/js/jquery.countTo.js')}}"></script>
    <!-- classie -->
    <script src="{{asset('assets/js/classie.js')}}"></script>
    <!-- selectFx -->
    <script src="{{asset('assets/js/selectFx.js')}}"></script>
    <!-- sticky kit -->
    <script src="{{asset('assets/js/jquery.sticky-kit.min.js')}}"></script>
    <!-- GOGLE MAP -->
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <!--TWITTER FETCHER-->
    <script src="{{asset('assets/js/twitterFetcher_min.js')}}"></script>
    <!-- Custom Script -->
    <script src="{{asset('assets/js/scripts.js')}}"></script>
	@if(Auth::user())
		<script>
		$(document).ready(function(){
				$.ajax({
					type:'GET',
					url:'{{url('update-package-orders')}}',
				});
		});
		</script>
	@endif
    @yield('custom-js')
</head>
<body id="page-top">
<!--custom_css-->
@if(App::getLocale()==='ar')
	<style>
		@media (max-width: 767px){
			.navbar-toggle{
				position: absolute;
				left:10px;
			}
			.navbar-toggle i{
				font-size: 18px;
			}
		}
	</style>
@endif
@yield('custom-css')
<div id="st-container" class="st-container">
	<div class="st-pusher">
		<div class="st-content">
			<header class="header">
				<nav class="top-bar">
					<div class="overlay-bg">
						<div class="container">
							<div class="row">

								<div class="col-sm-6 col-xs-12 hidden-xs">
									<div class="call-to-action">
										<ul class="list-inline">
											<li><a href="#"><i class="fa fa-phone"></i> {{$phone}}</a></li>
											<li><a href="#"><i class="fa fa-envelope"></i> {{$email}}</a></li>
										</ul>
									</div><!-- /.call-to-action -->
								</div><!-- /.col-sm-6 -->

								<div class="col-sm-6 ">

									<div class="{{(App::getLocale()==='ar')?'':'topbar-right'}}">
										<ul class="social-links list-inline {{(App::getLocale()==='ar')?'pull-left':'pull-right'}}">
											@if(Auth::guest())
											<li><a href="{{url(App::getLocale().'/login')}}" ><i class="fa fa-lock"></i> {{trans('general.login')}}</a></li>
											<li><a class="btn btn-sm btn-success" href="{{url(App::getLocale().'/register')}}"><i class="fa fa-user"></i> {{trans('general.register')}}</a></li>
											@else
												<li class="dropdown">
													<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
														{{ Auth::user()->name }} <span class="caret"></span>
													</a>
													<div class="submenu-wrapper row">
														<div class="submenu-inner">
															<ul class="dropdown-menu" role="menu">
																<li>
																	<a href="{{ route('logout',App::getLocale()) }}"
																	   onclick="event.preventDefault();
															 document.getElementById('logout-form').submit();">
																		Logout
																	</a>

																	<form id="logout-form" action="{{ route('logout',App::getLocale()) }}" method="POST" style="display: none;">
																		{{ csrf_field() }}
																	</form>
																</li>
															</ul>
														</div>
													</div>
												</li>

											@endif
											@include('partials.language')
										</ul>

									</div><!-- /.social-links -->
                                </div><!-- /.col-sm-6 -->
							</div><!-- /.row -->
						</div><!-- /.container -->
					</div><!-- /.overlay-bg -->
				</nav><!-- /.top-bar -->

				<div id="search">
					<button type="button" class="close">X</button>
					<form>
						<input type="search" value="" placeholder="type keyword(s) here" />
						<button type="submit" class="btn btn-primary">Search</button>
					</form>
				</div>

				<nav class="navbar navbar-default" role="navigation" style="height: auto; padding-top: 20px">

					<div class="container-fluid" style="width: 95%">
						<div class="navbar-header {{(App::getLocale() === 'ar')? 'pull-right':''}}">
							<h1 class="logo">
								<a class="navbar-brand" href="{{route('welcome',App::getLocale())}}" style="height: 80px;{{(App::getLocale()==='ar')?'margin-right:50px':''}}">
									<img src="{{url('img/'.$logo)}}" alt="" style="margin-top: -30px; height: 90px;">
								</a>
							</h1>
                            <!-- offcanvas-trigger -->
                            <button type="button" class="navbar-toggle collapsed hidden-lg hidden-md hidden-sm">
                                <span class="sr-only">Toggle navigation</span>
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse navbar-collapse">
							<ul class="nav navbar-nav  {{(App::getLocale() === 'ar')? 'arabic-nav navbar-left':'navbar-right'}}" style="margin-top: 10px;">
								<!-- Pages -->
								<li><a href="{{route('welcome',App::getLocale())}}"><i class="fa fa-home"></i></a></li>
								<li><a href="{{route('about',App::getLocale())}}">{{trans('menu.about')}}</a></li>
								<li><a href="{{route('why',App::getLocale())}}">{{trans('menu.why')}}</a></li>
								<li><a href="{{route('services',App::getLocale())}}">{{trans('menu.services')}}</a></li>
								<li><a href="{{route('prices',App::getLocale())}}">{{trans('menu.prices')}}</a></li>
								<li><a href="{{route('customers',App::getLocale())}}">{{trans('menu.customers')}}</a></li>
								<li><a href="{{route('contact',App::getLocale())}}">{{trans('menu.contact')}}</a></li>
								<!-- /Pages -->
								<!-- User -->
								@if (Auth::user())
									<li class="dropdown"><a href="#"><i class="fa fa-support"></i>{{trans('menu.support')}}<span class="fa fa-angle-down"></span></a>
										<!-- submenu-wrapper -->
										<div class="submenu-wrapper row">
											<div class="submenu-inner">
												<ul class="dropdown-menu"  style="height: 100px">
													<li><a href="{{route('client.new-ticket',App::getLocale())}}">{{trans('menu.new-ticket')}}</a></li>
													<li><a href="{{route('client.my-tickets',App::getLocale())}}">{{trans('menu.my-tickets')}}</a></li>
												</ul>
											</div>
										</div>
										<!-- /submenu-wrapper -->
									</li>
									<li class="dropdown"><a style="background: #1f648b; color: #FFFFFF" href="#"><i class="fa fa-user"></i>{{trans('menu.client')}}<span class="fa fa-angle-down"></span></a>
										<!-- submenu-wrapper -->
										<div class="submenu-wrapper row">
											<div class="submenu-inner">
												<ul class="dropdown-menu"  style="height: 200px">
													<li><a href="#" data-toggle="modal" data-target="#orderModal">{{trans('menu.new-order')}}</a></li>
													<li><a href="{{route('client.orders',App::getLocale())}}">{{trans('menu.my-orders')}}</a></li>
													<li><a href="{{route('client.package',App::getLocale())}}">{{trans('menu.package-request')}}</a></li>
													<li><a href="{{route('client',App::getLocale())}}">{{trans('menu.info')}}</a></li>
													<li><a href="#" data-toggle="modal" data-target="#reportModal">{{trans('general.report')}}</a></li>
												</ul>
											</div>
										</div>
										<!-- /submenu-wrapper -->
									</li>
								@endif
							</ul>
						</div><!-- /.navbar-collapse -->
					</div><!-- /.container -->
				</nav>
			</header>

			<div class="modal fade order-modal" id="orderModal" style="top: 150px;">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content {{(App::getLocale()==='ar')?'text-right':''}}">
						<div class="modal-header">
							<button type="button" class="close {{(App::getLocale()==='ar')?'pull-left':''}}" data-dismiss="modal">x</button>
							<h3>{{trans('general.select-order-type')}}</h3>
						</div>
						<div class="modal-body">
							<div class="btns">
							<a style="width: 100%;" class="btn btn-primary text-center" href="{{route('client.new-order',App::getLocale())}}">{{trans('general.new-delivery-order')}}</a><br>
							<a style="width: 100%; margin-top: 40px;" class="btn btn-warning text-center" href="{{route('client.other-new-order',App::getLocale())}}">{{trans('general.new-other-order')}}</a>
							</div>
						</div>
						<div class="modal-footer">
							<a href="#"></a>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade report-modal" id="reportModal" style="top: 150px;">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content {{(App::getLocale()==='ar')?'text-right':''}}">
						<div class="modal-header">
							<button type="button" class="close {{(App::getLocale()==='ar')?'pull-left':''}}" data-dismiss="modal">x</button>
							<h3>{{trans('general.report')}} {{trans('general.type')}}</h3>
						</div>
						<div class="modal-body">
							<div class="btns">
							<a style="width: 100%;" class="btn btn-info text-center" href="{{route('client.reports.orders-by-date',App::getLocale())}}">Orders By Date</a><br>
							<a style="width: 100%; margin-top: 40px;" class="btn btn-warning text-center" href="{{route('client.reports.orders-by-status',App::getLocale())}}">Orders By Status</a>
							</div>
						</div>
						<div class="modal-footer">
							<a href="#"></a>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade order-modal" id="trackModal" style="top: 150px;">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content {{(App::getLocale()==='ar')?'text-right':''}}">
						<div class="modal-header">
							<button type="button" class="close {{(App::getLocale()==='ar')?'pull-left':''}}" data-dismiss="modal">x</button>
							<h3>{{trans('general.track-order')}}</h3>
						</div>
						<div class="modal-body">
							<form method="post" action="{{route('search-order',App::getLocale())}}">
								{{csrf_field()}}
								<div class="form-group">
									<input type="text" class="form-control" name="search" placeholder="OrderID/Reference Number" id="order-search">
								</div>
								<div class="form-group">
									<input type="submit" class="btn btn-primary" cla value="{{trans('general.submit')}}">
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<a href="#"></a>
						</div>
					</div>
				</div>
			</div>


			<div class="modal fade login-modal" id="loginModal">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content {{(App::getLocale()==='ar')?'text-right':''}}">
                            <div class="modal-header">
                                <button type="button" class="close {{(App::getLocale()==='ar')?'pull-left':''}}" data-dismiss="modal">x</button>
                                <h3>{{trans('general.login-title')}}</h3>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{url('/login')}}" name="login_form">
									<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
										<label for="email" class="control-label">E-Mail Address</label>
										<input id="email" type="email" class="form-control" name="email" value="{{ @$email }} {{  old('email') }}">
										@if ($errors->has('email'))
											<span class="help-block">
												<strong>{{ $errors->first('email') }}</strong>
											</span>
										@endif
									</div>

									<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
										<label for="password" class="control-label">Password</label>
										<input id="password" type="password" class="form-control" name="password">

										@if ($errors->has('password'))
											<span class="help-block">
												<strong>{{ $errors->first('password') }}</strong>
											</span>
										@endif
									</div>

									<div class="form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="remember"> Remember Me
											</label>
										</div>
									</div>

									<div class="form-group">
											<button type="submit" class="btn btn-primary">
												<i class="fa fa-btn fa-sign-in"></i> Login
											</button>
											<br>
											<a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
											<a class="btn btn-link" href="{{ url('/register/send-verification-mail') }}">Verification Mail Not Received?</a>
									</div>
									{{csrf_field()}}
                                </form>
                            </div>
                            <div class="modal-footer">
                                {{trans('general.new-user')}}
                                <a href="#" class="btn btn-success">{{trans('general.register')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
@yield('content')


		<!-- cta start -->
			<section class="cta-section hidden">
				<div class="container text-center">
					<a  href="#" data-toggle="modal" data-target="#orderModal" class="btn btn-default quote-btn">{{trans('general.book-order')}}</a>
				</div><!-- /.container -->
			</section><!-- /.cta-section -->
			<!-- cta end -->

			<!-- footer-widget-section start -->
			<section class="footer-widget-section section-padding">
				<div class="container">
					<div class="row text-center">
						<div class="col-md-3 col-md-offset-1 col-sm-4">
							<div class="footer-widget">
								<h3>{{trans('general.footer1-title')}}</h3>

								<address>
                                    {!! trans('contact.address-info') !!}<br>
                                    Phone : +966 55 524 6993<br>
                                    Email : info@faststardlv.com<br>
								</address>


								<!-- Modal -->
								<div class="modal fade" id="cssMapModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title" id="myModalLabel">{{trans('contact.loc-title')}}</h4>
											</div>
											<div class="modal-body">

												<div id="googleMap"></div>

											</div>
										</div><!-- /.modal-content -->
									</div><!-- /.modal-dialog -->
								</div><!-- End Modal -->
							</div><!-- /.footer-widget -->
						</div><!-- /.col-md-4 -->

						<div class="col-md-3 col-sm-4">
							<div class="footer-widget text-center">
								<h3>{{trans('general.footer2-title')}}</h3>

								<ul>
                                    <li><a href="{{route('home',App::getLocale())}}">{{trans('menu.home')}}</a></li>
                                    <li><a href="{{route('about',App::getLocale())}}">{{trans('menu.about')}}</a></li>
                                    <li><a href="{{route('services',App::getLocale())}}">{{trans('menu.services')}}</a></li>
                                    <li><a href="{{route('contact',App::getLocale())}}">{{trans('menu.contact')}}</a></li>
                                </ul>
							</div><!-- /.footer-widget -->
						</div><!-- /.col-md-4 -->

						<div class="col-md-4 col-sm-4">
							<div class="footer-widget text-center">
								<h3>{{trans('general.footer3-title')}}</h3>
								<p>Enter your email address to receive news &amp; offers from us</p>

								<form class="newsletter-form">
									<div class="form-group">
										<label class="sr-only" for="InputEmail1">Email address</label>
										<input type="email" class="form-control" id="InputEmail1" placeholder="Your email address">
									</div>
									<div class="form-group">
										<button type="submit" class="">Send &nbsp;<i class="fa fa-angle-right"></i></button>
									</div>
								</form>
							</div><!-- /.footer-widget -->
						</div><!-- /.col-md-4 -->
					</div><!-- /.row -->
				</div><!-- /.container -->
			</section><!-- /.cta-section -->
			<!-- footer-widget-section end -->


<!-- copyright-section start -->
			<footer class="copyright-section">
				<div class="container text-center">
					<div class="footer-menu">
						<ul>
							<li><a href="#">Privacy &amp; Cookies</a></li>
							<li><a href="#">Terms &amp; Conditions</a></li>
							<li><a href="#">Accessibility</a></li>
						</ul>
					</div>

					<div class="copyright-info">
						<span>Copyright &copy; 2017 Fast Star. All Rights Reserved. Developed by <a href="#">Mohammad Maseeh Uzzama</a></span>
					</div>
				</div><!-- /.container -->
			</footer>
			<!-- copyright-section end -->
		</div> <!-- .st-content -->
	</div> <!-- .st-pusher -->

	<!-- OFF CANVAS MENU -->
	<div class="offcanvas-menu offcanvas-effect">
		<div class="offcanvas-wrap">
			<div class="off-canvas-header">
				<button type="button" class="close" aria-hidden="true" data-toggle="offcanvas" id="off-canvas-close-btn">&times;</button>
			</div>
			<ul id ="offcanvasMenu" class="list-unstyled visible-xs visible-sm">
				<!-- Pages -->
				<li><a href="{{route('welcome',App::getLocale())}}"><i class="fa fa-home"></i></a></li>
				<li><a href="{{route('about',App::getLocale())}}">{{trans('menu.about')}}</a></li>
				<li><a href="{{route('why',App::getLocale())}}">{{trans('menu.why')}}</a></li>
				<li><a href="{{route('services',App::getLocale())}}">{{trans('menu.services')}}</a></li>
				<li><a href="{{route('prices',App::getLocale())}}">{{trans('menu.prices')}}</a></li>
				<li><a href="{{route('customers',App::getLocale())}}">{{trans('menu.customers')}}</a></li>
				<li><a href="{{route('contact',App::getLocale())}}">{{trans('menu.contact')}}</a></li>
				<!-- /Pages -->
				<!-- User -->
				<li><a href="#" >&nbsp;&nbsp;&nbsp;&nbsp;{{trans('menu.client')}}</a>
					<ul class="dropdown-menu" style="padding-right: 20px">
						<li><a href="#" data-toggle="modal" data-target="#orderModal">{{trans('menu.new-order')}}</a></li>
						<li><a href="{{route('client.orders',App::getLocale())}}">{{trans('menu.my-orders')}}</a></li>
						<li><a href="{{route('client.package',App::getLocale())}}">{{trans('menu.package-request')}}</a></li>
						<li><a href="{{route('client',App::getLocale())}}">{{trans('menu.info')}}</a></li>
						<li><a href="#" data-toggle="modal" data-target="#reportModal">{{trans('general.report')}}</a></li>
					</ul>
					<!-- /submenu-wrapper -->
				</li>
			</ul>
		</div>
	</div><!-- .offcanvas-menu -->
</div><!-- /st-container -->

</body>
</html>
