@extends('layouts.master')

@section('meta-title')
    <title>FastStar | Login</title>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{trans('general.login')}}</div>
                <div class="panel-body">
                    @include('partials.flash')
                    <form class="form-horizontal" role="form" method="POST" action="{{ url(App::getLocale().'/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">{{trans('form.email')}}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{  old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">{{trans('general.password')}}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        @if(App::getLocale() == 'ar')
                                            <span>{{trans('form.remember-me')}}</span><input type="checkbox" name="remember" >

                                        @else
                                            <input type="checkbox" name="remember" ><span>{{trans('form.remember-me')}}</span>

                                        @endif
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    {{trans('general.login')}}
                                </button>
                                <br>
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">{{trans('form.forgot-password')}}</a><br>
                                <a class="btn btn-link" href="{{ url('/register/send-verification-mail') }}">{{trans('form.resend-activation')}}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
