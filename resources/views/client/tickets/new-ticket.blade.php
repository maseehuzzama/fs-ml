@extends('layouts.master')
@section('meta-title')
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{trans('general.support')}} | {{trans('general.tagline')}} </title>
@endsection
@section('custom-js')
@endsection
@section('content')
    <section class="page-title-section">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-header-wrap {{(App::getLocale() === 'ar') ? 'breadcrumb-right':''}}">
                        <div class="page-header">
                            <h1 class="{{(App::getLocale() === 'ar') ? 'text-right':''}}">{{trans('general.support')}}</h1>
                        </div>
                        <ol class="breadcrumb">
                            <li><a href="{{route('welcome',App::getLocale())}}">{{trans('menu.home')}}</a></li>
                            <li><a href="{{route('client',App::getLocale())}}">{{trans('menu.client')}}</a></li>
                            <li class="active">{{trans('general.support')}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">{{trans('general.new-ticket')}}</div>

                        <div class="panel-body">
                            @include('partials.flash')

                            <form class="form-horizontal" role="form" method="POST" action="{{ route('client.new-ticket',App::getLocale()) }}">
                                {!! csrf_field() !!}

                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                    <label for="title" class="col-md-4 control-label">{{trans('general.title')}}</label>

                                    <div class="col-md-6">
                                        <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}">

                                        @if ($errors->has('title'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                    <label for="category" class="col-md-4 control-label">{{trans('general.category')}}</label>

                                    <div class="col-md-6">
                                        <select id="category" type="category" class="form-control" name="category" required>
                                            <option value="">{{trans('general.select-one')}}</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('category'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
                                    <label for="priority" class="col-md-4 control-label">{{trans('general.priority')}}</label>

                                    <div class="col-md-6">
                                        <select id="priority" type="" class="form-control" name="priority" required>
                                            <option value="">{{trans('general.select-one')}}</option>
                                            <option value="low">Low</option>
                                            <option value="medium">Medium</option>
                                            <option value="high">High</option>
                                        </select>

                                        @if ($errors->has('priority'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('priority') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                    <label for="type" class="col-md-4 control-label">{{trans('general.service')}}</label>

                                    <div class="col-md-6">
                                        <select id="type" type="" class="form-control" name="type" required>
                                            <option value="">{{trans('general.select-one')}}</option>
                                            <option value="delivery">Delivery</option>
                                            <option value="package">Package Request</option>
                                            <option value="other">Other Services</option>
                                        </select>

                                        @if ($errors->has('priority'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('priority') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('reference') ? ' has-error' : '' }}">
                                    <label for="reference" class="col-md-4 control-label">{{trans('general.reference')}}</label>

                                    <div class="col-md-6">
                                        <input id="reference" type="text" class="form-control" name="reference" value="{{ old('reference') }}">

                                        @if ($errors->has('reference'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                    <label for="message" class="col-md-4 control-label">{{trans('general.message')}}</label>

                                    <div class="col-md-6">
                                        <textarea rows="10" id="message" class="form-control" name="message"></textarea>

                                        @if ($errors->has('message'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-ticket"></i> Open Ticket
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

