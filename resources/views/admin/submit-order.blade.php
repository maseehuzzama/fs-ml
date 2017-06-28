@extends('layouts.admin')

@section('content')
    <div id="page-wrapper">
        <!--js-->
        <script type="text/javascript">
            $(function () {
                $("#cod_pay").change(function () {
                    if($(this).is(":checked")) {
                        $("#cod_amount").removeAttr("disabled");
                        $("#cod_amount").focus();
                    } else {
                        $("#cod_amount").attr("disabled", "disabled");
                        $("#cod_amount").val('');
                    }
                });
            });

            $(function () {
                $("#is_cod").change(function () {
                    if($(this).is(":checked")) {
                        $("#cod_amount").removeAttr("disabled");
                        $("#cod_amount").focus();
                    } else {
                        $("#cod_amount").attr("disabled", "disabled");
                        $("#cod_amount").val('');
                    }
                });
            });

        </script>

        <div class="container-fluid">
            <div class="row">
                <h3>Order - #{{$order->id}} - Status: {{$order->status}}
                    <small>
                        <a href="#" class="btn btn-sm btn-danger" style="margin: -10px 0 0 25px;" onclick="goBack()">Back</a>
                    </small>
                </h3>
            </div>

            <div class="row">
                <h3 class="text-center text-white" style="background: #31708f; margin: 10px 50px 0px 50px;">{{trans('general.submit-order')}} - {{trans('form.step2')}}</h3>
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
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <h3>{{trans('general.store-details')}}</h3>
                            <ul class="list-unstyled">
                                <li><b>{{trans('general.store-name')}}: </b><span>{{@$order->store_name}}</span></li>
                                <li><b>{{trans('general.city')}}: </b><span>{{@$order->s_city}}</span></li>
                                <li><b>{{trans('general.neighbour')}}: </b><span>{{@$order->s_neighbor}}</span></li>
                                <li><b>{{trans('general.street')}}: </b><span>{{@$order->s_street}}</span></li>
                                <li><b>{{trans('general.pick-date')}}: </b><span>{{@$order->pick_date}}</span></li>
                                <li><b>{{trans('general.pick-time')}}: </b><span>{{@$order->pick_time}}</span></li>
                            </ul>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <h3>{{trans('client.rcvr-info')}}</h3>
                            <ul class="list-unstyled">
                                <li><b>{{trans('general.name')}}: </b><span>{{@$order->r_name}}</span></li>
                                <li><b>{{trans('general.city')}}: </b><span>{{@$order->r_city}}</span></li>
                                <li><b>{{trans('general.neighbour')}}: </b><span>{{@$order->r_neighbor}}</span></li>
                                <li><b>{{trans('general.street')}}: </b><span>{{@$order->r_street}}</span></li>
                                <li><b>{{trans('general.phone')}}: </b><span>{{@$order->r_phone}}</span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <h3>{{trans('general.shipment-details')}}</h3>
                            <ul class="list-unstyled">
                                <li><b>{{trans('client.shipment-contains')}}: </b><span>{{@$order->contains}}</span></li>
                                <li><b>{{trans('general.number-it')}}: </b><span>{{@$order->quantity}}</span></li>
                                <li><b>{{trans('general.weight')}}: </b><span>{{@$order->weight}}</span></li>
                            </ul>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <h3>{{trans('general.other-services')}}</h3>
                            <ul class="list-unstyled">
                                <li><b>{{trans('general.packing')}} :  </b><span>{{(@$order->is_packing == 1 )?trans('general.packing-yes').'&nbsp;'.$order->packing_amount:trans('general.no')}}</span></li>
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
                                        <th>{{trans('general.dlv-chrgs')}}</th>
                                        <th>{{trans('general.insurance-price')}}</th>
                                        <th>{{trans('general.packing-charges')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$order->dlv_chrgs}} SAR</td>
                                        <td>{{($order->is_insurance == 1)?$order->insurance_amount:0}} SAR</td>
                                        <td>{{($order->is_packing == 1)?$order->packing_amount:0}} SAR</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <form method="post" action="{{route('admin.submit-order',array($order->id,App::getLocale()))}}"  class="row">
                        {{csrf_field()}}
                        <div class="form-section col-xs-12"><h3>{{trans('form.payment-method')}}</h3>
                            <div class="form-group form-inline">
                                @if(($order->total_freight == 0))
                                    <div class="col-xs-12 col-sm-6">
                                        <input type="radio" name="payment_mode" value="4" checked>&nbsp;From Package <br>
                                    </div>
                                    <div class="col-sx-12 col-sm-6">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <input type="checkbox" name="is_cod" id="is_cod"><label>&nbsp;&nbsp; Cash on Delivery?</label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input id="cod_amount" name="cod_amount" class="form-control col-xs-8" type="text" placeholder="Enter Amount" disabled="disabled">
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div>
                                        <div>
                                            <label class="radio-inline"></label>
                                            <input type="radio" name="payment_mode" value="2">&nbsp;{{trans('form.cash-store')}}<br>
                                        </div>
                                        @if($account == true)
                                            <div class="{{($order->s_city == 'Riyadh' && $order->r_city == 'Riyadh')?'':'hidden'}}">
                                                <label class="radio-inline"></label>
                                                <input id="cod_pay" type="radio" name="payment_mode" value="3" {{($order->s_city == 'Riyadh' && $order->r_city == 'Riyadh')?'':'disabled="disabled"'}}>&nbsp;{{trans('form.cash-on-dlv')}}
                                                <input id="cod_amount" name="cod_amount" class="form-control" type="text" placeholder="Enter Amount" disabled="disabled">
                                            </div>
                                            <div class="{{((($account->wallet_amount+@$trans->amount) < $order->total_freight))?'hidden':''}}">
                                                <label class="radio-inline"></label>
                                                <input id="p_wallet_in" type="radio" name="payment_mode" value="1" {{((($account->wallet_amount+@$trans->amount) < $order->total_freight))?'disabled="disabled"':''}}>&nbsp;{{trans('form.from-wallet')}}
                                                @if(!$trans)
                                                    ({{trans('general.balance')}}:{{$account->wallet_amount}})
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" value="{{trans('general.submit-order')}}">
                        <a href="{{route('client.edit-order',array(App::getLocale(),$order->id))}}" class="btn btn-default">{{trans('general.back')}}</a>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection