<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin | Fast Star</title>

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
            <!-- jQuery -->
            <script src="{{asset('assets/admin/js/jquery.js')}}"></script>

            <!-- Bootstrap Core JavaScript -->
            <script src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>

            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>

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
            <a class="navbar-brand text-white" style="color: #FFFFFF;" href="{{route('admin',App::getLocale())}}">Fast Star</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search"></i> <b class="caret"></b></a>
                <ul class="dropdown-menu alert-dropdown">
                    <li>
                        <a href="#" data-toggle="modal" data-target="#orderSearchModal">Search Order</a>
                        <a href="#" data-toggle="modal" data-target="#customerSearchModal">Search Customer</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{Auth::user()->name}} <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{route('admin.account-report',array(Auth::user()->id,Auth::user()->email,App::getLocale()))}}">My Account</a>
                    </li>
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
                    <a href="{{route('admin',App::getLocale())}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#dd-shipments"><i class="fa fa-fw fa-arrows-v"></i>Delivery Orders <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="dd-shipments" class="collapse">
                        <li>
                            <a href="{{route('admin.pending-orders',App::getLocale())}}">List Pending Orders</a>
                        </li>
                        <li>
                            <a href="{{route('admin.completed-orders',App::getLocale())}}">List Completed Orders</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#dd-other-shipments"><i class="fa fa-fw fa-arrows-v"></i>Other Services Orders <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="dd-other-shipments" class="collapse">
                        <li>
                            <a href="{{route('admin.pending-other-orders',App::getLocale())}}">List Pending Orders</a>
                        </li>
                        <li>
                            <a href="{{route('admin.completed-other-orders',App::getLocale())}}">List Completed Orders</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{route('admin.all-orders',App::getLocale())}}">All Orders</a>
                </li>
                <li>
                    <a href="{{route('admin.customers',App::getLocale())}}"><i class="fa fa-fw fa-users"></i> Customers List</a>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#dd-reports">Reports<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="dd-reports" class="collapse">
                        <li>
                            <a href="{{route('admin.reports.orders-by-date',array(App::getLocale()))}}">Orders By Date</a>

                        </li>

                        <li>
                            <a href="{{route('admin.reports.orders-by-status',array(App::getLocale()))}}">Orders By Status</a>

                        </li>

                        <li>
                            <a href="{{route('admin.reports.orders-by-agent',array(App::getLocale()))}}">Orders By Agent</a>

                        </li>

                        <li>
                            <a href="{{route('admin.reports.orders-by-client',array(App::getLocale()))}}">Orders By Client</a>

                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#dd-tickets"><i class="fa fa-support"></i> Tickets<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="dd-tickets" class="collapse">
                        <li>
                            <a href="{{route('admin.new-tickets',array(App::getLocale()))}}">New Tickets</a>

                        </li>

                        <li>
                            <a href="{{route('admin.pending-tickets',array(App::getLocale()))}}">Pending Tickets</a>

                        </li>
                        <li>
                            <a href="{{route('admin.closed-tickets',array(App::getLocale()))}}">Closed Tickets</a>

                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#dd-agents">Agents<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="dd-agents" class="collapse">
                        <li>
                            <a href="{{route('admin.new-agent',App::getLocale())}}">New Agent</a>
                        </li>
                        <li>
                            <a href="{{route('admin.agents',App::getLocale())}}">All Agents</a>
                        </li>
                    </ul>
                </li>
                @if(Auth::user()->hasRole('superadmin'))
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#dd-admins">Admins & Employees<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="dd-admins" class="collapse">
                        <li>
                            <a href="{{route('admin.new-admin',App::getLocale())}}">New</a>
                        </li>
                        <li>
                            <a href="{{route('admin.admins',App::getLocale())}}">All</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#dd-master">Master<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="dd-master" class="collapse">
                        <li>
                            <a href="{{route('admin.cms.prices',App::getLocale())}}">Prices</a>
                        </li>
                        <li>
                            <a href="{{route('admin.cms.packings',App::getLocale())}}">Packing</a>
                        </li>
                        <li>
                            <a href="{{route('admin.cms.neighbors',App::getLocale())}}">Neighbours</a>
                        </li>
                        <li>
                            <a href="{{route('admin.cms.regions',App::getLocale())}}">Regions</a>
                        </li>

                        <li>
                            <a href="{{route('admin.cms.status',App::getLocale())}}">Status</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#dd-theme">Theme<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="dd-theme" class="collapse">
                        <li>
                            <a href="{{route('admin.theme.slider',App::getLocale())}}">Slider</a>
                        </li>

                        <li>
                            <a href="{{route('admin.theme.services',App::getLocale())}}">Services</a>
                        </li>

                        <li>
                            <a href="{{route('admin.theme.general-settings',App::getLocale())}}">Settings</a>
                        </li>
                        <li>
                            <a href="{{route('admin.cms.customers',App::getLocale())}}">Customers</a>
                        </li>
                    </ul>
                </li>
                @elseif(Auth::user()->hasRole('admin'))
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#dd-admins">Supervisors<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="dd-admins" class="collapse">
                            <li>
                                <a href="{{route('admin.new-admin',App::getLocale())}}">New</a>
                            </li>
                            <li>
                                <a href="{{route('admin.admins',App::getLocale())}}">All Supervisors</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    @yield('content')

    <div id="orderSearchModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Search Order</h4>
                </div>
                <div class="modal-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{route('admin.search-orders',App::getLocale())}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="amount">Order Id/Order Ref/Agent Username/Status</label>
                            <input type="text" id="search" name="search"  class="form-control" required="required" placeholder="Type Any Above">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="customerSearchModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Search Customer/Client</h4>
                </div>
                <div class="modal-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{route('admin.search-customers',App::getLocale())}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="amount">User ID/Email/Username/Phone/City</label>
                            <input type="text" id="search" name="search"  class="form-control" required="required" placeholder="Type Any Above">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /#wrapper -->
</body>

</html>
