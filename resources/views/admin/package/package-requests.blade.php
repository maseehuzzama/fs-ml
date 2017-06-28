@extends('layouts.admin')
@section('content')

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="row">
                <ul  class="nav nav-pills">
                    <li class="active">
                        <a  href="#1a" data-toggle="tab">New Requests</a>
                    </li>
                    <li><a href="#2a" data-toggle="tab">Old Requests</a>
                    </li>
                </ul>
                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="1a">
                        <h2>New Requests</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <tr>
                                    <th><a href="#">#Ref</a></th>
                                    <th><a href="#">Request of</a></th>
                                    <th><a href="#">User ID</a></th>
                                    <th><a href="#">Package Code</a></th>
                                    <th><a href="#">Amount</a></th>
                                    <th><a href="#">Payment Mode</a></th>
                                    <th><a href="#">Paid</a></th>
                                    <th><a href="#">Active</a></th>
                                    <th class="actions">Actions</th>
                                </tr>
                                @foreach($newPackageRequests as $item)
                                    <tr>
                                        <td>{{$item->ref_number}}&nbsp;</td>
                                        <td>{{@$item->users->name}}&nbsp;</td>
                                        <td>{{$item->user_id}}</td>
                                        <td>{{$item->package_code}}&nbsp;</td>
                                        <td>{{$item->amount}}&nbsp;</td>
                                        <td>{{$item->payment_mode}}&nbsp;</td>
                                        <td>{{($item->paid == true)?'Yes':'No'}}&nbsp;</td>
                                        <td>{{($item->active == true)?'Yes':'No'}}&nbsp;</td>
                                        <td class="actions">
                                            <form action="{{route('admin.active-package-request',array($item->user_id,$item->id,$item->ref_number,App::getLocale()))}}" method="post">
                                            <input type="submit" class="{{(App::getLocale() === 'ar') ? 'pull-right':''}}" title="Update" value="Active">
                                            {{csrf_field()}}
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane" id="2a">
                        <h2>Old Requests</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <tr>
                                    <th><a href="#">#Ref</a></th>
                                    <th><a href="#">Request of</a></th>
                                    <th><a href="#">User ID</a></th>
                                    <th><a href="#">Package Code</a></th>
                                    <th><a href="#">Amount</a></th>
                                    <th><a href="#">Payment Mode</a></th>
                                    <th><a href="#">Paid</a></th>
                                    <th><a href="#">Active</a></th>
                                </tr>
                                @foreach($packageRequests as $item)
                                    <tr>
                                        <td>{{$item->ref_number}}&nbsp;</td>
                                        <td>{{@$item->users->name}}&nbsp;</td>
                                        <td>{{$item->user_id}}</td>
                                        <td>{{$item->package_code}}&nbsp;</td>
                                        <td>{{$item->amount}}&nbsp;</td>
                                        <td>{{$item->payment_mode}}&nbsp;</td>
                                        <td>{{($item->paid == true)?'Yes':'No'}}&nbsp;</td>
                                        <td>{{($item->active == true)?'Yes':'No'}}&nbsp;</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

@endsection