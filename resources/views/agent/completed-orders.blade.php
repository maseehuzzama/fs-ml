@extends('layouts.agent')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <h2>{{trans('general.completed-orders')}}</h2>
                </table><table class="table table-hover">
                    <tr>
                        <th><a href="#">{{trans('general.order-number')}}</a></th>
                        <th><a href="#">{{trans('general.neighbour')}}</a></th>
                        <th><a href="#">{{trans('general.street')}}</a></th>
                        <th><a href="#">{{trans('general.city')}}</a></th>
                        <th><a href="#">{{trans('general.pick-date')}}</a></th>
                        <th><a href="#">{{trans('general.status')}}</a></th>
                    </tr>
                    @foreach($completedOrders as $order)
                        <tr>
                            <td>
                                <a href="{{route('agent.order',array($order->ref_number, App::getLocale()))}}" title=""><b>{{$order->ref_number}}</b></a>
                            </td>
                            <td>{{$order->s_neighbor}}</td>
                            <td>{{$order->s_street}}</td>
                            <td>{{$order->s_city}}</td>
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