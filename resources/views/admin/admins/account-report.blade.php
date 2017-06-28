@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <form action="{{route('admin.account-report',array($admin->id, $admin->email,App::getLocale()))}}" method="post">
                    {{csrf_field()}}
                    <div class="col-xs-12 col-md-4 form-group">
                        <input type="text" class="form-control" value="{{@$from?$from:date('Y-m-d')}}" name="from">
                    </div>
                    <div class="col-xs-12 col-md-4 form-group">
                        <input type="text" class="form-control"  value="{{@$to?$to:date('Y-m-d')}}" name="to">
                    </div>

                    <div class="col-xs-12 col-md-4 form-group">
                        <input type="submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
            @if(count($transactions) > 0)
            <div class="row" id="print">
                <h4>{{trans('general.transactions')}} {{trans('general.from')}} {{@$from?$from:date('Y-m-d')}} to {{@$to?$to:date('Y-m-d')}}</h4>
                </table><table class="table table-hover">
                    <tr>
                        <th><a href="#">#{{trans('general.trans-no')}}.</a></th>
                        <th><a href="#">{{trans('general.reference')}}</a></th>
                        <th><a href="#">{{trans('general.name')}}</a></th>
                        <th><a href="#">{{trans('general.type')}}</a></th>
                        <th><a href="#">{{trans('general.amount')}}</a></th>
                        <th><a href="#">{{trans('general.date')}}</a></th>
                    </tr>
                    @foreach($transactions as $trans)
                        <tr>
                            <td>{{$trans->id}}</td>
                            <td>{{$trans->reference}}</td>
                            <td>{{$trans->name}}</td>
                            <td>{{$trans->type}}</td>
                            <td>{{$trans->amount}}</td>
                            <td>{{$trans->created_at}}</td>
                        </tr>
                    @endforeach
                </table>
                <p class="text-center">
                    <b>{{trans('general.total-amount')}}: {{$admin->wallet_amount}} {{trans('general.sar')}}</b>
                </p>
            </div>
            @else
                No Record found
            @endif
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
@endsection