@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <h3>{{trans('general.order-number')}} - #{{$order->ref_number}} - {{trans('general.status')}}: {{$order->status}}
                    <small>
                        <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary" style="margin: -10px 0 0 25px;">{{trans('general.change-status')}}</a>
                        @if($order->is_delivery == 1)
                            @if($order->s_city != 'Riyadh' or $order->r_city != 'Riyadh')
                                <a href="#" class="btn btn-sm btn-default" data-toggle="modal" data-target="#shippingNumberModal" style="margin: -10px 0 0 25px;">Enter Shipping Bill Number</a>
                            @endif
                            <a href="{{route('admin.edit-order',array($order->id,App::getLocale()))}}" class="btn btn-sm btn-success" style="margin: -10px 0 0 25px;">{{trans('general.edit')}}</a>
                        @else
                            <a href="{{route('admin.edit-other-order',array($order->id,App::getLocale()))}}" class="btn btn-sm btn-success" style="margin: -10px 0 0 25px;">{{trans('general.edit')}}</a>
                        @endif
                        <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#assignAgentsModal"  style="margin: -10px 0 0 25px;" >Assign Agents</a>
                        <a href="#" class="btn btn-sm btn-danger" style="margin: -10px 0 0 25px;" onclick="goBack()">{{trans('general.back')}}</a>
                    </small>
                </h3>
                <h4>Shipping Bill Number : <small><b>{{$order->shipping_number}}</b></small></h4>
            </div>
            @if($order->is_delivery == true)
            <div class="order-details">
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <h3>{{trans('general.store-details')}}</h3>
                        <ul class="list-unstyled">
                            <li><b>{{trans('general.store-name')}}: </b><span>{{@$order->store_name}}</span></li>
                            <li><b>{{trans('general.country')}}: </b><span>{{@$order->s_country}}</span></li>
                            <li><b>{{trans('general.city')}}: </b><span>{{@$order->s_city}}</span></li>
                            <li><b>{{trans('general.neighbour')}}: </b><span>{{@$order->s_neighbor}},{{$order->s_other_neighbor}}</span></li>
                            <li><b>{{trans('general.region')}}: </b><span>{{@$order->s_regions->name}}</span></li>
                            <li><b>{{trans('general.street')}}: </b><span>{{@$order->s_street}}</span></li>
                            <li><b>{{trans('general.pick-date')}}: </b><span>{{@$order->pick_date}}</span></li>
                            <li><b>{{trans('general.pick-time')}}: </b><span>{{@$order->pick_time}}</span></li>
                            <li><b>Picking Agent: </b><span>{{@$order->pick_agent}}</span></li>

                        </ul>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <h3>{{trans('client.rcvr-info')}}</h3>
                        <ul class="list-unstyled">
                            <li><b>{{trans('form.name')}}: </b><span>{{@$order->r_name}}</span></li>
                            <li><b>{{trans('general.country')}}: </b><span>{{@$order->r_country}}</span></li>
                            <li><b>{{trans('general.city')}}: </b><span>{{@$order->r_city}}</span></li>
                            <li><b>{{trans('general.neighbour')}}: </b><span>{{@$order->r_neighbor}},{{$order->r_other_neighbor}}</span></li>
                            <li><b>{{trans('general.region')}}: </b><span>{{@$order->r_regions->name}}</span></li>
                            <li><b>{{trans('general.street')}}: </b><span>{{@$order->r_street}}</span></li>
                            <li><b>Delivery Agent: </b><span>{{@$order->deliver_agent}}</span></li>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <h3>{{trans('general.shipment-details')}}</h3>
                        <ul class="list-unstyled">
                            <li><b>{{trans('general.shipment-details')}}: </b><span>{{@$order->contains}}</span></li>
                            <li><b>{{trans('client.number-it')}}: </b><span>{{@$order->quantity}}</span></li>
                            <li><b>{{trans('general.weight')}}: </b><span>{{@$order->weight}}</span></li>
                        </ul>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <h3>{{trans('general.other-services')}}</h3>
                        <ul class="list-unstyled">
                            <li><b>{{trans('general.packing')}}: </b><span>{!! (@$order->is_packing == 1 )?'Yes, Charges:<b> '.$order->packing_amount.'SAR</b>':'No'!!}</span></li>
                            <li><b>{{trans('general.insurance')}}: </b><span>{!! (@$order->is_insurance == 1 )?'Yes, Charges:<b> '.$order->insurance_amount.'SAR</b>':'No'!!}</span></li>
                            <li><b>{{trans('general.spl-req')}}: </b><span>{{(@$order->spl_req == 1)?$order->spl_req:'No'}}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h3>{{trans('general.price-details')}}</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>{{trans('general.dlv_type')}}</th>
                                    <th>{{trans('general.payment-mode')}}</th>
                                    <th>{{trans('general.dlv-chrgs')}}</th>
                                    <th>{{trans('general.packing-charges')}}</th>
                                    <th>{{trans('general.freight')}}</th>
                                    <th>{{trans('general.cod')}}</th>
                                    <th>{{trans('general.return')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{($order->dlv_type =='fed')?'Fast Express':'Fast Delivery'}}</td>
                                    <td>{{@$order->payment_mode->title}}</td>
                                    <td>{{$order->dlv_chrgs}}</td>
                                    <td>{{($order->is_packing == 1)?$order->packing_amount:0.00}}</td>
                                    <td>{{$order->total_freight}}</td>
                                    <td>{{($order->is_cod == true)?$order->cod_amount:'No'}}</td>
                                    <td>{{$order->return_amount}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @elseif($order->is_delivery == false)
                <div class="order-details">
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <h3>{{trans('general.store-details')}}</h3>
                            <ul class="list-unstyled">
                                <li><b>{{trans('general.store-name')}}: </b><span>{{@$order->store_name}}</span></li>
                                <li><b>{{trans('general.country')}}: </b><span>{{@$order->s_country}}</span></li>
                                <li><b>{{trans('general.city')}}: </b><span>{{@$order->s_city}}</span></li>
                                <li><b>{{trans('general.neighbour')}}: </b><span>{{@$order->s_neighbors->name}}</span></li>
                                <li><b>{{trans('general.region')}}: </b><span>{{@$order->s_regions->name}}</span></li>
                                <li><b>{{trans('general.street')}}: </b><span>{{@$order->s_street}}</span></li>
                                <li><b>{{trans('general.pick-date')}}: </b><span>{{@$order->pick_date}}</span></li>
                                <li><b>{{trans('general.pick-time')}}: </b><span>{{@$order->pick_time}}</span></li>
                            </ul>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <h3>{{trans('general.photo-details')}}</h3>
                            <ul class="list-unstyled">
                                <li><b>{{trans('general.photo-place')}}: </b><span>{{@$photoOrder->address}}</span></li>
                                <li><b>{{trans('general.quantity')}}: </b><span>{{@$photoOrder->quantity}}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h3>{{trans('general.price-details')}} <small><a href="#"  data-toggle="modal" data-target="#priceModal" class="btn btn-sm btn-success" style="margin: -10px 0 0 25px;">Add/Update Prices</a>
                                </small></h3>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>{{trans('general.photo-prices')}}</th>
                                        <th class="hidden">Storage Prices</th>
                                        <th>{{trans('general.total-prices')}}</th>
                                        <th>{{trans('general.payment-mode')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{(@$photoOrder->price == true)? $photoOrder->price:'Not Decided'}}</td>
                                            <td class="hidden">{{@$storageOrder->price}}</td>
                                            <td >{{@$photoOrder->price+@$storageOrder->price}}</td>
                                            <td>{{@$order->payment_mode->title}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{trans('general.update-status')}}</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('admin.change-status',array($order->id,App::getLocale()))}}">
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

            <div id="priceModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add/Update Price</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('admin.update-other-order-price',array($order->id,$order->ref_number,App::getLocale()))}}">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="number">{{trans('general.photo-prices')}}</label>
                                    <input id="photo_price" name="photo_price" type="text" class="form-control" placeholder="Price for Photography" {{($order->is_photo == true)?'':'disabled="disabled"'}}>
                                </div>
                                <div class="form-group">
                                    <label for="number">{{trans('general.storage-prices')}}</label>
                                    <input id="storage_price" name="storage_price" type="text" class="form-control" placeholder="Price for Storage" {{(@$order->is_storage == true)?'':'disabled="disabled"'}}>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="{{trans('general.submit')}}" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="shippingNumberModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Enter Shipping Number</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('admin.enter-shipping-number',array($order->id,App::getLocale()))}}">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="number">Shipping Number</label>
                                    <input id="shipping_number" name="shipping_number" type="text" class="form-control" placeholder="Shipping Number">
                                </div>

                                <div class="form-group">
                                    <input type="submit" value="{{trans('general.submit')}}" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <div id="assignAgentsModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Assign Agents</h4>
                        </div>
                        <div class="modal-body">
                            <p>
                            <form method="post" action="{{route('admin.assign-pick-agent',[$order->id, App::getLocale()])}}">
                                {{csrf_field()}}
                                <div class="form-group form-inline">
                                    <label for="number">Picking Agent</label>
                                    <select class="form-control" name="pick_agent">
                                        <option>--Select One--</option>
                                    @foreach(App\Agent::where('type','pick')->get() as $agent)
                                            <option value="{{$agent->username}}">{{$agent->name}},{{$agent->email}}</option>
                                        @endforeach
                                    </select>
                                    <input type="submit" value="{{trans('general.submit')}}" class="btn btn-primary btn-sm">
                                </div>
                            </form>
                            </p>

                            <p>
                            <form method="post" action="{{route('admin.assign-delivery-agent',[$order->id, App::getLocale()])}}">
                            {{csrf_field()}}
                                <div class="form-group form-inline">
                                    <label for="number">Delivery Agent</label>
                                    <select class="form-control" name="delivery_agent">
                                        <option value="">--Select One--</option>
                                    @foreach(App\Agent::where('type','delivery')->get() as $agent)
                                            <option value="{{$agent->username}}">{{$agent->name}},{{$agent->email}}</option>
                                        @endforeach
                                    </select>
                                    <input type="submit" value="{{trans('general.submit')}}" class="btn btn-primary btn-sm">
                                </div>
                            </form>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection