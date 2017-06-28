<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Agent | Fast Star</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet">

    @if(App::getLocale()==='ar')
        <link href="{{asset('assets/admin/css/bootstrap-rtl.min.css')}}" rel="stylesheet">
        @endif

                <!-- Custom CSS -->
        <link href="{{asset('assets/admin/css/sb-admin.css')}}" rel="stylesheet">

        @if(App::getLocale()==='ar')
            <link href="{{asset('assets/admin/css/sb-admin-rtl.css')}}" rel="stylesheet">
            @endif
                    <!-- Custom Fonts -->
            <link href="{{asset('assets/admin/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" style="color: #FFFFFF;"  href="{{url('agent/'.App::getLocale())}}">Fast Star</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Language<b class="caret"></b></a>
                <ul class="dropdown-menu alert-dropdown">
                    <li>
                        <a href="./ar">{{trans('menu.arabic')}}</a>
                        <a href="./en">English</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{Auth::user()->name}} <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('logout',App::getLocale()) }}"
                           onclick="event.preventDefault();
															 document.getElementById('logout-form').submit();">
                           <i class="fa fa-power-off"></i> Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout',App::getLocale()) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse main-nav navbar-collapse navbar-ex1-collapse ">
            <ul class="nav navbar-nav side-nav">
                <li>
                    <a href="{{url('agent/'.App::getLocale())}}"><i class="fa fa-fw fa-dashboard"></i> {{trans('general.dashboard')}}</a>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#dd-shipments"><i class="fa fa-fw fa-arrows-v"></i> {{trans('general.orders')}} <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="dd-shipments" class="collapse">
                        <li>
                            <a href="{{route('agent.pending-orders',App::getLocale())}}">{{trans('general.pending-orders')}}</a>
                        </li>
                        <li>
                            <a href="{{route('agent.completed-orders',App::getLocale())}}">{{trans('general.completed-orders')}}</a>
                        </li>
                        @if(Auth::user()->type == 'delivery')
                        <li>
                            <a href="{{route('agent.coming-orders',App::getLocale())}}">{{trans('general.coming-orders')}}</a>
                        </li>
                        @endif
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#dd-reports"><i class="fa fa-fw fa-arrows-v"></i> {{trans('general.report')}} <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="dd-reports" class="collapse">
                        @if(Auth::user()->type == 'delivery')
                            <li>
                                <a href="{{route('agent.delivery-report',App::getLocale())}}">{{trans('general.dlv-report')}}</a>
                            </li>
                        @elseif(Auth::user()->type == 'pick')
                            <li>
                                <a href="{{route('agent.pick-report',App::getLocale())}}">{{trans('general.pick-report')}}</a>
                            </li>
                        @endif
                    </ul>
                </li>
                <li>
                    <a href="{{route('agent.cash-list',App::getLocale())}}"><i class="fa fa-fw fa-users"></i>{{trans('general.cash-list')}}</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    @yield('content')
</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="{{asset('assets/admin/js/jquery.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>

</body>

</html>
