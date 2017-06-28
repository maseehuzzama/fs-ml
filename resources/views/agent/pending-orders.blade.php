@extends('layouts.agent')
@section('content')

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="row">
                <h2>{{trans('general.pending-orders')}}</h2>
                <table class="table table-hover">
                    <tr>
                        <th><a href="#">{{trans('general.order-number')}}</a></th>
                        <th><a href="#">{{trans('general.store-name')}}</a></th>
                        <th><a href="#">{{trans('general.neighbour')}}</a></th>
                        <th><a href="#">{{trans('general.street')}}</a></th>
                        <th><a href="#">{{Auth::user()->type == 'pick'?trans('general.store-city'):trans('general.receiver-city')}}</a></th>
                        <th><a href="#">{{trans('general.pick-date')}}</a></th>
                        @if(Auth::user()->type == 'delivery')
                        <th><a href="#">{{trans('general.cod')}}</a></th>
                        @elseif(Auth::user()->type == 'pick')
                        <th><a href="#">{{trans('general.cfs')}}</a></th>
                        @endif
                        <th><a href="#">{{trans('general.status')}}</a></th>
                        <th class="actions">{{trans('general.actions')}}</th>
                    </tr>
                    @foreach($pendingOrders as $order)
                    <tr>
                        <td>
                            <a href="{{route('agent.order',array($order->ref_number, App::getLocale()))}}" title=""><b>{{$order->ref_number}}</b></a>
                        </td>
                        <td>{{$order->store_name}}</td>
                        <td>{{$order->s_neighbor}}</td>
                        <td>{{$order->s_street}}</td>
                        <td>{{Auth::user()->type == 'pick'?$order->s_city:$order->r_city}}</td>
                        <td>{{$order->pick_date}}</td>
                        @if(Auth::user()->type == 'delivery')
                        <td>{{$order->cod_amount}}</td>
                        @elseif(Auth::user()->type == 'pick' and $order->payment_id == 2)
                        <td>{{$order->cod_amount}}</td>
                        @endif
                        <td>{{$order->status}}</td>
                        <td class="actions">
                            <a href="{{route('agent.order',array($order->ref_number, App::getLocale()))}}" title="Update Status"><span class="label label-primary">{{trans('general.update-status')}}</span></a>
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