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
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">{{trans('general.my-tickets')}}</div>
                        <div class="panel-body"  style="padding:0;">
                            @include('partials.flash')
                            <div class="table-responsive">
                                <table class="table table-hover">
                                   <tbody>
                                    <tr>
                                        <th>{{trans('general.ticket-id')}}</th>
                                        <th>{{trans('general.category')}}</th>
                                        <th>{{trans('general.service')}}</th>
                                        <th>{{trans('general.title')}}</th>
                                        <th>{{trans('general.status')}}</th>
                                        <th>{{trans('general.updated_at')}}</th>
                                    </tr>
                                    @foreach($tickets as $ticket)
                                        <tr>
                                            <td>{{$ticket->ticket_id}}</td>
                                            <td>{{$ticket->category->name}}</td>
                                            <td>{{$ticket->service_type}}</td>
                                            <td><a href="{{route('client.ticket-show',[App::getLocale(),$ticket->id])}}">{{str_limit($ticket->title,50)}}</a></td>
                                            <td>{{$ticket->status}}</td>
                                            <td>{{$ticket->updated_at}}</td>
                                        </tr>
                                    @endforeach
                                   </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

