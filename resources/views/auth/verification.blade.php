@extends('layouts.master')
<meta name="description" content="FastStar Email Verification Page" />
<meta name="keywords" content="FastStar Email Verification , FastStar Account Activation" />
<title>FastStar | Email Verification</title>
@section('content')
    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Email Verification</div>
                    <div class="panel-body">
                        @if (session('success'))
                            <h3 class="text-success">{{ session('success') }}</h3>
                        @endif
                        @if (session('unsuccess'))
                            <h3 class="text-danger">{{ session('unsuccess') }}</h3>
                        @endif
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('register/send-verification-mail') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-enevelope"></i> Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
