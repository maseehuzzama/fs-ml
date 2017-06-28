@extends('layouts.admin')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <h2>{{trans('general.admin')}} {{trans('general.id')}} -  {{$admin->id}}
                    <small>
                        @if($admin->hasRole('subadmin'))
                            <a href="#" data-toggle="modal" data-target="#transferSupervisorModal" class="btn btn-primary">{{trans('general.take-amount')}}</a>
                        @else
                            <a href="#" data-toggle="modal" data-target="#transferAccountantModal" class="btn btn-primary">{{trans('general.take-amount')}}</a>

                        @endif
                        <a href="{{route('admin.edit-admin',[$admin->id,App::getLocale()])}}" class="btn btn-success">{{trans('general.edit')}}</a>
                        <a href="#" data-toggle="modal" data-target="#cityModal" class="btn btn-success">{{trans('general.assign-city')}}</a>
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
                    <h3>{{trans('general.admin')}} {{trans('general.details')}}</h3>
                   <ul class="list-unstyled">
                       <li><b>{{trans('general.name')}}:</b>&nbsp;<span>{{$admin->name}}</span></li>
                       <li><b>{{trans('general.username')}}:</b>&nbsp;<span>{{$admin->username}}</span></li>
                       <li><b>{{trans('form.email')}}:</b>&nbsp;<span>{{$admin->email}}</span></li>
                       <li><b>{{trans('general.phone')}}:</b>&nbsp;<span>{{$admin->phone}}</span></li>
                       <li><b>{{trans('general.city')}}:</b>&nbsp;<span>{{$admin->city}}</span></li>
                   </ul>
                </div>
                <div class="col-sm-12 col-md-6">
                    <h3>{{trans('general.account-cities')}} {{trans('general.details')}} </h3>
                    <ul class="list-unstyled">
                        <li><b>{{trans('general.work-cities')}}:</b>&nbsp;<span>@foreach($admin->cities as $city){{$city->name}},@endforeach</span></li>
                        <li><b>{{trans('general.wallet-amount')}} :</b>&nbsp;<span>{{$admin->wallet_amount}}</span></li>
                    </ul>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

        <div id="transferSupervisorModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('general.take-amount')}}</h4>
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
                        <form method="post" action="{{route('admin.take-supervisor-amount',array($admin->id,$admin->email,App::getLocale()))}}">
                            {{csrf_field()}}
                            <input type="hidden" name="current_amount" id="current_amount" value="{{$admin->wallet_amount}}">
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
                                <input type="text" id="amount" name="amount"  class="form-control" required="required" readonly="true" value="{{$admin->wallet_amount}}">
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

        <div id="transferAccountantModal" class="modal fade" role="dialog">
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
                        <form method="post" action="{{route('admin.take-accountant-amount',array($admin->id,$admin->email,App::getLocale()))}}">
                            {{csrf_field()}}
                            <input type="hidden" name="current_amount" id="current_amount" value="{{$admin->wallet_amount}}">
                            <div class="form-group">
                                <label for="amount_type">Amount  Type[required]</label>
                                <select id="amount_type" name="amount_type" class="form-control" required>
                                    <option value="">--select amount--</option>
                                    <option value="current">Current Amount</option>
                                    <option value="other">Other Amount</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount [required]</label>
                                <input type="text" id="amount" name="amount"  class="form-control" required="required" readonly="true" value="{{$admin->wallet_amount}}">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Update">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="cityModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Assign Work City</h4>
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
                        <form method="post" action="{{route('admin.admins.assign-work-city',array($admin->id,$admin->email,App::getLocale()))}}">
                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="city">City [required]</label>
                                <select id="city" name="city" class="form-control">
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Update">
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