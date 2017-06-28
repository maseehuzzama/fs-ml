@extends('layouts.agent')
@section('content')

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="row">
                <h2>{{trans('general.cash-list')}}</h2>
                </table><table class="table table-hover">
                    <tr>
                        <th><a href="#">{{trans('general.trans-no')}}</a></th>
                        <th><a href="#">{{trans('general.reference')}}</a></th>
                        <th><a href="#">{{trans('form.name')}}</a></th>
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
                    <b>Total Amount in wallet: {{Auth::user()->wallet_amount}} SAR</b>
                </p>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
@endsection