@extends('layouts.admin')
@section('content')

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="row">
                <ul  class="nav nav-pills">
                </ul>
                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="1a">
                        <h2>New Tickets</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <tr>
                                    <th><a href="#">#{{trans('general.ticket')}} {{trans('general.number')}}</a></th>
                                    <th><a href="#">{{trans('general.username')}}</a></th>
                                    <th><a href="#">{{trans('general.user')}} {{trans('general.id')}}</a></th>
                                    <th><a href="#">{{trans('general.type')}}</a></th>
                                    <th><a href="#">{{trans('general.title')}}</a></th>
                                    <th><a href="#">{{trans('general.status')}}</a></th>
                                    <th><a href="#">{{trans('general.actions')}}</a></th>
                                </tr>
                                @foreach($newTickets as $item)
                                    <tr>
                                        <td>{{$item->ticket_id}}&nbsp;</td>
                                        <td>{{@$item->user->name}}&nbsp;</td>
                                        <td>{{$item->user_id}}</td>
                                        <td>{{$item->service_type}}&nbsp;</td>
                                        <td>{{$item->title}}&nbsp;</td>
                                        <td>{{$item->status}}&nbsp;</td>
                                        <td><a href="{{route('admin.ticket',[$item->id,$item->ticket_id,App::getLocale()])}}" class="label label-info">More</a></td>
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