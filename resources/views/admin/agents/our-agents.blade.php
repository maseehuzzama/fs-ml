@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <h2>{{trans('general.agent')}} {{trans('general.list')}}</h2>
                <div class="table-responsive">

                    <table class="table table-hover table-bordered">
                        <tr>
                            <th><a href="#">{{trans('general.s-no')}}</a></th>
                            <th><a href="#">{{trans('general.id')}}</a></th>
                            <th><a href="#">{{trans('general.name')}}</a></th>
                            <th><a href="#">{{trans('general.phone')}}</a></th>
                            <th><a href="#">{{trans('form.email')}}</a></th>
                            <th><a href="#">{{trans('general.city')}}</a></th>
                            <th><a href="#">{{trans('general.balance')}}({{trans('general.sar')}})</a></th>
                            <th class="actions">{{trans('general.actions')}}</th>
                        </tr>
                        <?php $i = 1; ?>
                        @foreach($agents as $agent)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$agent->id}}</td>
                                <td>{{$agent->name}}</td>
                                <td>{{$agent->phone}}</td>
                                <td>{{$agent->email}}</td>
                                <td>{{$agent->city}}</td>
                                <td>{{$agent->wallet_amount}}</td>
                                <td class="actions">
                                    <a href="{{route('admin.agent',array($agent->id,App::getLocale()))}}" title="More"><span class="label label-success">More</span></a>
                                    <a href="{{route('admin.edit-agent',array($agent->id,App::getLocale()))}}" title="Edit"><span class="label label-info">Edit</span></a>
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