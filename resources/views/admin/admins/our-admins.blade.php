@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <h2>{{trans('general.admins-employees')}} {{trans('general.list')}}</h2>
                <div class="table-responsive">

                    <table class="table table-hover table-bordered">
                        <tr>
                            <th><a href="#">{{trans('general.s-no')}}</a></th>
                            <th><a href="#">{{trans('general.admin')}}-{{trans('general.id')}}</a></th>
                            <th><a href="#">{{trans('general.name')}}</a></th>
                            <th><a href="#">{{trans('general.phone')}}</a></th>
                            <th><a href="#">{{trans('form.email')}}</a></th>
                            <th><a href="#">{{trans('general.city')}}</a></th>
                            <th><a href="#">{{trans('general.balance')}}({{trans('general.sar')}})</a></th>
                            <th class="actions">{{trans('general.actions')}}</th>
                        </tr>
                        <?php $i = 1; ?>
                        @foreach($admins as $admin)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$admin->id}}</td>
                                <td>{{$admin->name}}</td>
                                <td>{{$admin->phone}}</td>
                                <td>{{$admin->email}}</td>
                                <td>{{$admin->city}}</td>
                                <td>{{$admin->wallet_amount}}</td>
                                <td class="actions">
                                    <a href="{{route('admin.admin',array($admin->id,$admin->email,App::getLocale()))}}" title="More"><span class="label label-success">More</span></a>
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