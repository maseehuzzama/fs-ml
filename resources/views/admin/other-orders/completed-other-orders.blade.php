@extends('layouts.admin')
@section('content')

    <div id="page-wrapper">

    <div class="container-fluid">

        <div class="row">
            <div class="table-responsive">
            <h2>Completed orders</h2>
                <table class="table table-hover">
                    <tr>
                        <th><a href="#">#Ref</a></th>
                        <th><a href="#">Shipment of</a></th>
                        <th><a href="#">Origin</a></th>
                        <th><a href="#">Destination</a></th>
                        <th><a href="#">PickupDate</a>&nbsp;<i class='fa fa-sort-asc'></i></th>
                        <th><a href="#">Status</a></th>
                        <th><a href="#">Pick Agent</a></th>
                        <th><a href="#">Deliver Agent</a></th>
                        <th class="actions">Actions</th>
                    </tr>
                    @foreach($completedOrders as $order)
                        <tr>
                            <td>
                                <a href="{{route('admin.order',array($order->ref_number,App::getLocale()))}}" title=""><b>{{$order->ref_number}}</b></a>
                            </td>
                            <td>{{$order->contains}}&nbsp;</td>
                            <td>{{$order->s_city}}-{{$order->s_regions->name}}&nbsp;</td>
                            <td>{{$order->r_city}}-{{$order->r_regions->name}}</td>
                            <td>{{$order->pick_date}}&nbsp;</td>
                            <td>{{$order->status}}&nbsp;</td>
                            <td>{{$order->pick_agent}}&nbsp;</td>
                            <td>{{$order->deliver_agent}}&nbsp;</td>
                            <td class="actions">
                                <a href="{{route('admin.order',array($order->ref_number,App::getLocale()))}}" class="{{(App::getLocale() === 'ar') ? 'pull-right':''}}" title="Update Status"><span class="label label-success">Show</span></a>
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