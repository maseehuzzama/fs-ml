@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Dashboard
                        <small>{{Auth()->user()->name}}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-file"></i> {{trans('menu.home')}}
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-envelope fa-5x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <div class="huge">26</div>
                                    <div>New Messages!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
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
                                    <div class="huge">{{count($newDeliveryOrders)+count($newOtherOrders)}}</div>
                                    <div>{{trans('general.new-orders')}}</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('admin.pending-orders',App::getLocale())}}">
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
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <div class="huge">{{count($packageRequests)}}</div>
                                    <div>{{trans('general.new-package-requests')}}</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('admin.package-requests',App::getLocale())}}">
                            <div class="panel-footer">
                                <span class="pull-left">{{trans('general.details')}}</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <div class="huge">{{count($tickets)}}</div>
                                    <div>{{trans('general.support-tickets')}}</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('admin.new-tickets',App::getLocale())}}">
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
                <ul  class="nav nav-pills">
                    <li class="active">
                        <a  href="#1a" data-toggle="tab">{{trans('general.new-delivery-order')}}</a>
                    </li>
                    <li><a href="#2a" data-toggle="tab">{{trans('general.new-other-order')}}</a>
                    </li>
                </ul>
                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="1a">
                        <h2>{{trans('general.new-delivery-order')}}</h2>
                        <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <tr>
                                <th><a href="#">#{{trans('general.reference')}}</a></th>
                                <th><a href="#">{{trans('general.shipment-details')}}</a></th>
                                <th><a href="#">{{trans('general.origin')}}</a></th>
                                <th><a href="#">{{trans('general.destination')}}</a></th>
                                <th><a href="#">{{trans('general.pick-date')}}</a>&nbsp;<i class='fa fa-sort-asc'></i></th>
                                <th><a href="#">{{trans('general.status')}}</a></th>
                                <th><a href="#">{{trans('general.pick-agent')}}</a></th>
                                <th><a href="#">{{trans('general.dlv-agent')}}</a></th>
                                <th class="actions">{{trans('general.actions')}}</th>
                            </tr>
                            @foreach($newDeliveryOrders as $order)
                            <tr>
                                <td>
                                    <a href="{{route('admin.order',array($order->id,App::getLocale()))}}" title=""><b>{{$order->ref_number}}</b></a>
                                </td>
                                <td>{{$order->contains}}&nbsp;</td>
                                <td>{{$order->s_city}}-{{$order->s_regions->name}}&nbsp;</td>
                                <td>{{$order->r_city}}-{{$order->r_regions->name}}</td>
                                <td>{{$order->pick_date}}&nbsp;</td>
                                <td>{{$order->status}}&nbsp;</td>
                                <td>{{$order->pick_agent}}&nbsp;</td>
                                <td>{{$order->deliver_agent}}&nbsp;</td>
                                <td class="actions">
                                    <a href="{{route('admin.order',array($order->id,App::getLocale()))}}" class="{{(App::getLocale() === 'ar') ? 'pull-right':''}}" title="Update Status"><span class="label label-success">Show</span></a>
                                </td>
                            </tr>
                            @endforeach
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane" id="2a">
                        <h2>{{trans('general.new-other-order')}}</h2>
                        <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <tr>
                                <th><a href="#">#Ref</a></th>
                                <th><a href="#">Shipment of</a></th>
                                <th><a href="#">Origin</a></th>
                                <th><a href="#">Services</a></th>
                                <th><a href="#">PickupDate</a>&nbsp;<i class='fa fa-sort-asc'></i></th>
                                <th><a href="#">Status</a></th>
                                <th><a href="#">Pick & Return Agent</a></th>
                                <th class="actions">Actions</th>
                            </tr>
                            @foreach($newOtherOrders as $order)
                            <tr>
                                <td>
                                    <a href="{{route('admin.order',array($order->id,App::getLocale()))}}" title=""><b>{{$order->ref_number}}</b></a>
                                </td>
                                <td>{{$order->contains}}&nbsp;</td>
                                <td>{{@$order->s_city}}-{{@$order->s_regions->name}}&nbsp;</td>
                                <td>{{$order->is_photo == true?'Photography':''}}{{$order->is_storage?'Storage,':''}}&nbsp;</td>
                                <td>{{@$order->pick_date}}&nbsp;</td>
                                <td>{{@$order->status}}&nbsp;</td>
                                <td>{{@$order->pick_agent}}&nbsp;</td>
                                <td class="actions">
                                    <a href="{{route('admin.order',array($order->id,App::getLocale()))}}" class="{{(App::getLocale() === 'ar') ? 'pull-right':''}}" title="Update Status"><span class="label label-success">Show</span></a>
                                </td>
                            </tr>
                            @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection