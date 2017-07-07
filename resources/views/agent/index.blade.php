@extends('layouts.agent')
@section('content')
    <meta http-equiv="refresh" content="15" >
    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        {{trans('general.dashboard')}}
                        <small>{{trans('general.agent')}}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i>  <a href="#"> {{trans('general.dashboard')}}
                            </a>
                        </li>
                        <li class="active">
                            <i class="fa fa-file"></i>{{trans('menu.home')}}

                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <div class="huge" id="load">{{count($newOrders)}}</div>
                                    <div>{{trans('general.new-orders')}}</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('agent',App::getLocale())}}">
                            <div class="panel-footer">
                                <span class="pull-left">{{trans('general.details')}}</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <div class="huge">{{count($pendingOrders)}}</div>
                                    <div>{{trans('general.pending-orders')}}</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('agent.pending-orders',App::getLocale())}}">
                            <div class="panel-footer">
                                <span class="pull-left">{{trans('general.details')}}</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <div class="huge">{{count($deliveredOrders)}}</div>
                                    <div>{{trans('general.completed-orders')}}</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('agent.completed-orders',App::getLocale())}}">
                            <div class="panel-footer">
                                <span class="pull-left">{{trans('general.details')}}</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <div class="huge">{{Auth::user()->type =='delivery' ?count($comingOrders):'0'}}</div>
                                    <div>{{trans('general.coming-orders')}}</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{(Auth::user()->type == 'delivery')?route('agent.coming-orders',App::getLocale()):'#'}}">
                            <div class="panel-footer">
                                <span class="pull-left">{{trans('general.details')}}</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <h2>{{trans('general.new-orders')}}  {{(Auth::user()->type == 'pick')?trans('general.to-pick'):trans('general.to-dlvr')}}</h2>
                <table class="table table-bordered table-hover table-striped">
                    <tr>
                        <th><a href="#">{{trans('general.s-no')}}</a></th>
                        <th><a href="#">{{trans('general.ref')}}</a></th>
                        <th><a href="#">{{(Auth::user()->type == 'pick')?trans('general.shipment-place'):trans('dlv-place')}}</a></th>
                        <th><a href="#">{{trans('general.street')}}</a></th>
                        <th><a href="#">{{trans('general.pick-date')}}</a></th>
                        <th><a href="#">{{trans('general.status')}}</a></th>
                        <th class="actions">{{trans('general.actions')}}</th>
                    </tr>
                    <?php $i = 1; ?>
                    @foreach($newOrders as $order)
                    <tr>
                        <td>{{ $i++  }}</td>
                        <td>
                            <a href="{{route('agent.order',array($order->ref_number, App::getLocale()))}}" title=""><b>{{$order->ref_number}}</b></a>
                        </td>
                        <td>{{(Auth::user()->type == 'pick')?$order->s_neighbor.'-'.$order->s_other_neighbor.'-'.$order->s_city:$order->r_neighbor.','.$order->r_other_neighbor.','.$order->r_city}}&nbsp;</td>
                        <td>{{(Auth::user()->type == 'pick')?$order->s_street:$order->r_street}}</td>
                        <td>{{@$order->pick_date}}&nbsp;</td>
                        <td>{{$order->status}}&nbsp;</td>
                        <td class="actions">
                            <a href="{{route('agent.get-order',array($order->ref_number, App::getLocale()))}}" class="{{(App::getLocale() === 'ar') ? 'pull-right':''}}" title="Update Status"><span class="label label-success">GET</span></a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection