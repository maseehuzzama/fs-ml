@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <h2>ID -  {{$agent->id}}
                    <small>
                        <a href="#" data-toggle="modal" data-target="#transferModal" class="btn btn-primary">{{trans('general.take-amount')}}</a>
                        <a href="#" onclick="goBack()" class="btn btn-info"><i class="fa fa-arrow-left"></i>{{trans('general.back')}}</a>
                    </small>
                </h2>
                <div class="message col-xs-12">
                    @if (session('unsuccess'))
                        <h3 class="text-danger" style="padding:20px; background: #e3e3e3; border: orange 1px solid;">{{ session('unsuccess') }}</h3>
                    @endif
                    @if (session('success'))
                        <p class="text-success" style="padding:20px; background: #e3e3e3; border: green 1px solid;  ">{{ session('success') }}</p>
                    @endif
                </div>
                <div class="col-sm-12 col-md-6">
                    <h3>{{trans('general.details')}}</h3>
                   <ul class="list-unstyled">
                       <li><b>{{trans('general.name')}}:</b>&nbsp;<span>{{$agent->name}}</span></li>
                       <li><b>{{trans('general.username')}}:</b>&nbsp;<span>{{$agent->username}}</span></li>
                       <li><b>{{trans('form.email')}}:</b>&nbsp;<span>{{$agent->email}}</span></li>
                       <li><b>{{trans('general.phone')}}:</b>&nbsp;<span>{{$agent->phone}}</span></li>
                       <li><b>{{trans('general.city')}}:</b>&nbsp;<span>{{$agent->city}}</span></li>
                   </ul>
                </div>
                <div class="col-sm-12 col-md-6">
                    <h3>{{trans('general.account')}} {{trans('general.region')}} {{trans('general.details')}} </h3>
                    <ul class="list-unstyled">
                        <li><b>{{trans('general.region')}}:</b>&nbsp;<span>@foreach($agent->regions as $region){{$region->name}},@endforeach</span></li>
                        <li><b>{{trans('general.total-amount')}} :</b>&nbsp;<span>{{$agent->wallet_amount}}</span></li>
                    </ul>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

        <div id="transferModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Transfer Amount</h4>
                    </div>
                    <div class="modal-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{route('admin.take-agent-amount',array($agent->id,$agent->email,App::getLocale()))}}">
                            {{csrf_field()}}
                            <input type="hidden" name="current_amount" id="current_amount" value="{{$agent->wallet_amount}}">
                            <div class="form-group">
                                <label for="amount_type">Amount  Type[required]</label>
                                <select id="amount_type" name="amount_type" class="form-control" required>
                                    <option value="">--select amount--</option>
                                    <option value="current">Current Amount</option>
                                    <option value="other">Other Amount</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amount">{{trans('general.amount')}}</label>
                                <input type="text" id="amount" name="amount"  class="form-control" readonly="true" value="{{$agent->wallet_amount}}">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="{{trans('general.update')}}">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
    <script>
        $(function () {
            $("#amount_type").change(function () {
                var current_amount = $("#current_amount").val();
                if($(this).val() == 'current') {
                    $("#amount").val(current_amount);
                    $("#amount").attr("readonly","true");
                } else {
                    $("#amount").removeAttr("readonly");
                    $("#amount").val("");
                    $("#amount").focus();
                }
            });
        });
    </script>

@endsection