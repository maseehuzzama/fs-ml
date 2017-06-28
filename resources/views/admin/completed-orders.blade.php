@extends('layouts.admin')
@section('content')

    <div id="page-wrapper">

    <div class="container-fluid">

        <div class="row">
            <div class="table-responsive">
            <h2>{{trans('general.completed-orders')}}</h2>
                <table class="table table-hover">
                    <tr>
                        <th><a href="#">#{{trans('general.order-number')}}</a></th>
                        <th><a href="#">{{trans('general.shipment-details')}}</a></th>
                        <th><a href="#">{{trans('general.origin')}}</a></th>
                        <th><a href="#">{{trans('general.destination')}}</a></th>
                        <th><a href="#">{{trans('general.pick-date')}}</a>&nbsp;<i class='fa fa-sort-asc'></i></th>
                        <th><a href="#">{{trans('general.status')}}</a></th>
                        <th><a href="#">{{trans('general.pick-agent')}}</a></th>
                        <th><a href="#">{{trans('general.delivery-agent')}}</a></th>
                        <th class="actions">{{trans('general.actions')}}</th>
                    </tr>
                    @foreach($completedOrders as $order)
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

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
@endsection