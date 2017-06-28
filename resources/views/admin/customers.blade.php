@extends('layouts.admin')
@section('content')

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="row">
                <h2>Customers</h2>
                <div class="table-responsive">

                    <table class="table table-hover">
                        <tr>
                            <th><a href="#">Serial</a></th>
                            <th><a href="#">C-Id</a></th>
                            <th><a href="#">Created</a></th>
                            <th><a href="#">Name</a></th>
                            <th><a href="#">Phone</a></th>
                            <th><a href="#">Email</a></th>
                            <th><a href="#">Location</a></th>
                            <th><a href="#">Balance(SR)</a></th>
                            <th><a href="#">Status</a></th>
                            <th class="actions">Actions</th>
                        </tr>
                        <?php $i = 1; ?>
                        @foreach($customers as $customer)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$customer->id}}</td>
                            <td>{{$customer->created_at->format('Y-m-d')}}</td>
                            <td>{{$customer->name}}</td>
                            <td>{{$customer->phone}}</td>
                            <td>{{$customer->email}}</td>
                            <td>{{$customer->city}}</td>
                            <td>{{@$customer->accounts->wallet_amount?$customer->accounts->wallet_amount:'0.00'}}</td>
                            <td>{{($customer->active)?'Active':'Not Active'}}</td>
                            <td class="actions">
                                <a href="{{route('admin.customer',array($customer->id,$customer->email,App::getLocale()))}}" title="More"><span class="label label-danger">More</span></a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    {{$customers->links()}}
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

@endsection