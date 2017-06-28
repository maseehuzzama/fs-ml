@extends('layouts.admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- /.row -->
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        @if(Auth::user()->hasRole('superadmin'))
                        <div class="panel-heading">{{trans('general.new')}} {{trans('general.admin')}}</div>
                        @elseif(Auth::user()->hasRole('admin'))
                        <div class="panel-heading">{{trans('general.new')}} {{trans('general.supervisor')}}</div>
                        @endif
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.new-admin',App::getLocale())}}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                    <label for="username" class="col-md-4 control-label">{{trans('general.username')}}</label>

                                    <div class="col-md-6">
                                        <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
                                        @if ($errors->has('username'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">{{trans('general.password')}}</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" required>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">{{trans('form.fullname')}}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">{{trans('form.email')}}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <label for="phone" class="col-md-4 control-label">{{trans('general.phone')}}</label>
                                    <div class="col-md-6">
                                        <input id="phone" type="number" class="form-control" name="phone" value="{{ old('phone') }}" required autofocus>

                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                    <label for="country" class="col-md-4 control-label">{{trans('general.country')}}</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="country" required>
                                            <option value="SA">Saudi Arabia</option>
                                        </select>
                                        @if ($errors->has('country'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                    <label for="city" class="col-md-4 control-label">{{trans('general.city')}}</label>
                                    <div class="col-md-6">
                                        <select id="city" class="form-control" name="city" required>
                                            <option value="">--Select City--</option>
                                            @foreach($cities as $city)
                                                <option value="{{$city->name}}">{{$city->name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('city'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                    <label for="type" class="col-md-4 control-label">{{trans('general.type')}}</label>
                                    <div class="col-md-6">
                                        <select id="type" class="form-control" name="type" required>
                                            <option value="">--Select Type--</option>
                                           @foreach($roles as $role)
                                               <option value="{{$role->name}}">{{$role->name}}</option>
                                           @endforeach
                                        </select>
                                        @if ($errors->has('type'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{trans('general.submit')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection