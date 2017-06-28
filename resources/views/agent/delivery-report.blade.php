@extends('layouts.agent')
@section('content')
    <style>

        .report-print{
            display: none;
        }
        .left{
            left:10%;
        }
        .right{
            right: 10%;
        }

        @media print {
            .container {
                width:100%;
            }
            body * {
                visibility: hidden;
            }
            #print, #print * {
                visibility: visible;

            }
            #print{
                margin-top: -80px;
                border: 1px solid;
                padding: 10px;
            }
            a[href]:after {
                content: none !important;
            }
            #not-print{
                display: none;
            }
            .not-print{
                display: none;
            }
            .report-print{
                display: inherit;
            }
        }
    </style>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <ul  class="nav nav-pills" id="not-print">
                    <li class="active">
                        <a  href="#1a" data-toggle="tab">{{trans('general.all-orders')}}</a>
                    </li>
                    <li><a href="#2a" data-toggle="tab">{{trans('general.today-orders')}}</a>
                    </li>
                    <li class="pull-right"><a class="btn btn-success btn-sm" onclick="window.print();">Print</a></li>
                </ul>
                <div class="tab-content clearfix" id="print">
                    <div class="report-print" style="position: relative; height:80px; border: 1px solid;">
                        <h4 style="padding: 10px">{{date('d-m-Y')}}</h4>
                        <img src="{{url('img/logo.png')}}" style="height: 60px; position: absolute; top: 10px; right: 10%" class="{{App::getLocale() == 'ar'?'left':'right'}}">
                    </div>
                    <div class="tab-pane active" id="1a">
                        <div class="table-responsive">
                            <h5>Delivery Reoprt {{trans('general.by')}} {{Auth::user()->name}}</h5>
                            <table class="table table-bordered table-hover table-striped">
                                <tr>
                                    <th><a href="#">#{{trans('general.order-number')}}</a></th>
                                    <th><a href="#">{{trans('general.store-name')}}</a></th>
                                    <th><a href="#">{{trans('general.r_name')}}</a></th>
                                    <th><a href="#">{{trans('general.destination')}}</a></th>
                                    <th><a href="#">{{trans('general.phone')}}</a></th>
                                    <th class="not-print"><a href="#">{{trans('general.status')}}</a></th>
                                    <th class="actions not-print">{{trans('general.actions')}}</th>
                                </tr>
                                @foreach($allOrders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{route('admin.order',array($order->id,App::getLocale()))}}" title=""><b>{{$order->id}}</b></a>
                                        </td>
                                        <td>{{$order->store_name}}&nbsp;</td>
                                        <td>{{$order->r_name}}&nbsp;</td>
                                        <td>{{$order->r_city}}-{{$order->r_regions->name}}&nbsp;</td>
                                        <td>{{$order->r_phone}}&nbsp;</td>
                                        <td class="not-print">{{$order->status}}&nbsp;</td>
                                        <td class="actions not-print">
                                            <a href="{{route('agent.order',array($order->ref_number, App::getLocale()))}}" class="{{(App::getLocale() === 'ar') ? 'pull-right':''}}" title="Show"><span class="label label-success">Show</span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            {{$allOrders->links()}}
                        </div>
                    </div>
                    <div class="tab-pane" id="2a">
                        <div class="table-responsive">
                            <h5>Today Deliveries For {{Auth::user()->name}}</h5>
                            <table class="table table-bordered table-hover table-striped">
                                <tr>
                                    <th><a href="#">#{{trans('general.order-number')}}</a></th>
                                    <th><a href="#">{{trans('general.store-name')}}</a></th>
                                    <th><a href="#">{{trans('general.r_name')}}</a></th>
                                    <th><a href="#">{{trans('general.destination')}}</a></th>
                                    <th><a href="#">{{trans('general.phone')}}</a></th>
                                    <th><a href="#">{{trans('general.pick-date')}}</a>&nbsp;<i class='fa fa-sort-asc'></i></th>
                                    <th><a href="#">{{trans('general.status')}}</a></th>
                                    <th class="actions">{{trans('general.signatures')}}</th>
                                </tr>
                                @foreach($todayOrders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{route('agent.order',array($order->ref_number, App::getLocale()))}}" title=""><b>{{$order->ref_number}}</b></a>
                                        </td>
                                        <td>{{$order->store_name}}&nbsp;</td>
                                        <td>{{$order->r_name}}&nbsp;</td>
                                        <td>{{$order->r_city}}-{{$order->s_regions->name}}&nbsp;</td>
                                        <td>{{$order->r_phone}}&nbsp;</td>
                                        <td>{{$order->pick_date}}&nbsp;</td>
                                        <td>{{$order->status}}&nbsp;</td>
                                        <td class="actions">
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="report-print">
                        Report By: {{Auth::user()->name}}<br>
                        Confirmed By<br>
                        Name:<br>
                        Signature:<br>
                    </div>
                    <!--tab-end-->
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

@endsection