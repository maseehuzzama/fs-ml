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
                        <div class="panel-heading">{{trans('general.ticket-id')}} #{{$ticket->ticket_id}}</div>
                        <div class="panel-body">
                            @include('partials.flash')
                            <div class="ticket-header">
                                <h3>{{trans('general.title')}}: {{$ticket->title}}</h3>
                                <p>
                                    <span class="label label-warning"><b>{{trans('general.category')}}:</b> {{$ticket->category->name}}</span>
                                    <span class="label label-info"><b>{{trans('general.service')}}: </b>{{$ticket->service_type}}</span>
                                    <span class="label label-success"><b>{{trans('general.status')}}:</b> {{$ticket->status}}</span>
                                </p>
                                <p>
                                    <a href="#" class="btn btn-default"  data-toggle="modal" data-target="#replyModal"><i class="fa fa-reply"></i> Reply</a>
                                </p>
                            </div>
                           <div class="ticket-body">

                               <div class="main-msg" style="box-shadow: 0 0 5px 0 #cccccc; padding: 10px">
                                   <h4><b>{{trans('general.by')}}:</b>Client</h4>
                                   {{$ticket->message}}
                               </div><br>
                               @foreach($replies as $reply)
                                   <div class="reply" style="box-shadow: 0 0 5px 0 #cccccc; padding: 10px">
                                       <h4><b>{{trans('general.by')}}:</b>{{$reply->from}}<small>[{{$reply->type}}]</small></h4>
                                       {{$reply->reply}}
                                   </div><br>
                               @endforeach
                           </div>
                            <div class="ticket-reply row">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade order-modal" id="replyModal" style="top: 100px;">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content {{(App::getLocale()==='ar')?'text-right':''}}">
                <div class="modal-header">
                    <button type="button" class="close {{(App::getLocale()==='ar')?'pull-left':''}}" data-dismiss="modal">x</button>
                    <h3>{{trans('general.reply')}}</h3>
                </div>
                <div class="modal-body">
                    <form action="{{route('client.reply-ticket',App::getLocale())}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="ticket_id" value="{{$ticket->ticket_id}}">
                        <div class="form-group">
                            <textarea type="text" class="form-control" rows="10" id="reply" name="reply" required placeholder="Your Reply"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Submit" class="btn btn-primary" placeholder="Choose Screenshot">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#"></a>
                </div>
            </div>
        </div>
    </div>
@endsection

