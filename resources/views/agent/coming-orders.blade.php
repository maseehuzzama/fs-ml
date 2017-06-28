@extends('layouts.agent')
@section('content')

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="row">
                <h2>{{trans('general.coming-orders')}}</h2>
                <table class="table table-hover">

                    <tr>
                        <th><a href="#">{{trans('general.order-numbers')}}</a></th>
                        <th><a href="#">{{trans('general.neighbour')}}</a></th>
                        <th><a href="#">{{trans('general.street')}}</a></th>
                        <th><a href="#">{{Auth::user()->type == 'pick'?trans('general.store-city'):trans('general.receiver-city')}}</a></th>
                        <th><a href="#">{{trans('general.pick-date')}}</a></th>
                        <th><a href="#">{{trans('general.status')}}</a></th>
                    </tr>
                    @foreach($comingOrders as $order)
                    <tr>
                        <td>
                            <a href="#" title=""><b>{{$order->ref_number}}</b></a>
                        </td>
                        <td>{{$order->r_neighbors->name}}</td>
                        <td>{{$order->r_street}}</td>
                        <td>{{Auth::user()->type == 'pick'?$order->s_city:$order->r_city}}</td>
                        <td>{{$order->pick_date}}</td>
                        <td>{{$order->status}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

@endsection