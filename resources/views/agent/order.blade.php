@extends('layouts.agent')
@section('content')

    <div id="page-wrapper">

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        {{trans('general.dashboard')}}
                        <small>{{trans('general.agent')}}
                        </small>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i>  <a href="#">{{trans('general.dashboard')}}
                            </a>
                        </li>
                        <li class="active">
                            <i class="fa fa-file"></i>{{trans('general.details')}}
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="order-wrapper row" style="box-shadow: 0 0 10px 0 #cccccc; padding: 30px">
                        <h4>Order Nmber: {{$order->ref_number}}</h4>
                        <div class="col-sm-12 col-md-6 {{(Auth::user()->type == 'pick')?'':'hidden'}}">
                            <h3>{{trans('general.store-details')}}</h3>
                            <ul class="list-unstyled">
                                <li><b>{{trans('general.shipment-details')}}: </b><span>{{@$order->contains}}-Quantity: {{$order->quantity}}</span></li>
                                <li><b>{{trans('general.store-name')}}: </b><span>{{@$order->store_name}}</span></li>
                                <li><b>{{trans('general.phone')}}: </b><span>{{$order->s_phone}}</span></li>
                                <li><b>{{trans('general.neighbour')}}: </b><span>{{@$order->s_neighbor}}</span></li>
                                <li><b>{{trans('general.street')}}: </b><span>{{@$order->s_street}}</span></li>
                                <li><b>{{trans('general.city')}}: </b><span>{{@$order->s_city}}</span></li>
                                <li><b>{{trans('general.pick-date')}}: </b><span>{{@$order->pick_date}}</span></li>
                                <li><b>{{trans('general.pick-time')}}: </b><span>{{@$order->pick_time}}</span></li>
                                <li><b>{{trans('general.dlv_type')}}: </b><span>{{($order->dlv_type =='fed')?'Fast Express':'Fast Delivery'}}</span></li>
                                <li><b>{{trans('general.cfs')}}: </b><span>{!! ($order->payment_id == 2)?'Yes, Amount <b>SAR'.$order->total_freight.'</b>':'No'!!}</span></li>
                            </ul>
                        </div>

                        <div class="col-sm-12 col-md-6 {{(Auth::user()->type == 'delivery' or $order->dlv_type == 'fed')?'':'hidden'}}">
                            <h4>{{trans('general.details')}}</h4>
                            <ul class="list-unstyled">
                                <li><b>{{trans('general.shipment-details')}}: </b><span>{{@$order->contains}}-Quantity: {{$order->quantity}}</span></li>
                                <li><b>{{trans('general.r_name')}}: </b><span>{{@$order->r_name}}</span></li>
                                <li><b>{{trans('general.phone')}}: </b><span>{{$order->r_phone}}</span></li>
                                <li><b>{{trans('general.neighbour')}}: </b><span>{{@$order->r_neighbor}}</span></li>
                                <li><b>{{trans('general.street')}}: </b><span>{{@$order->r_street}}</span></li>
                                <li><b>{{trans('general.city')}}: </b><span>{{@$order->r_city}}</span></li>
                                <li><b>{{trans('general.cod')}}: </b><span>{!! ($order->is_cod)?'Yes, Amount <b>SAR'.$order->cod_amount.'</b>':'No'!!}</span></li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <ul class="list-unstyled">
                                <li><h4>{{trans('general.status')}}: <small> {{$order->status}} - {{(App::getLocale()== 'ar' and $order->statuses->description_ar == true)? $order->statuses->description_ar:$order->statuses->description}}</small></h4></li>
                                <li><a href="#"  data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm">
                                        {{trans('general.update-status')}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!--end-row-->
        </div>
        <!-- /.container-fluid -->
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Status</h4>
                    </div>
                    <div class="modal-body">
                       <form method="post" action="{{route('agent.change-status',array($order->ref_number,App::getLocale()))}}">
                           {{csrf_field()}}
                           <div class="form-group">
                               <select class="form-control" name="status">
                                       <option value="">--Select Status--</option>
                                   @foreach($statuses as $status)
                                       <option value="{{$status->name}}">{{$status->name}} - {{(App::getLocale()== 'ar' and $status->description_ar == true)? $status->description_ar:$status->description}}</option>
                                   @endforeach
                               </select>
                           </div>
                           <div class="form-group">
                               <input type="submit" class="btn btn-primary" value="Update">
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
    <!-- /#page-wrapper -->

@endsection