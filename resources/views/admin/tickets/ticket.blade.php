@extends('layouts.admin')
<style>
    .bold{
        font-weight: 700;
    }
</style>
@section('content')

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="row">
                <ul  class="nav nav-pills">
                </ul>
                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="1a">
                        <h2>{{trans('general.ticket')}}</h2>
                        <div class="item">
                            <div class="ticket-header">
                                <h3>{{trans('general.title')}}: {{$ticket->title}}</h3>
                                <p>
                                    <span class="label label-warning"><b>{{trans('general.category')}}:</b> {{$ticket->category->name}}</span>
                                    <span class="label label-info"><b>{{trans('general.type')}}: </b>{{$ticket->service_type}}</span>
                                    <span class="label label-success"><b>{{trans('general.status')}}:</b> {{$ticket->status}}</span>
                                </p>
                                <p>
                                    <span><b>{{trans('general.username')}}:</b> {{$ticket->user->name}}</span>
                                    <span><b>{{trans('general.reference')}}:</b> {{$ticket->reference}}</span>
                                </p>
                                <p>
                                    <a href="#" class="btn btn-default"  data-toggle="modal" data-target="#replyModal"><i class="fa fa-reply"></i> Reply</a>
                                </p>
                            </div>
                            <div class="ticket-body">
                               
                                <div class="main-msg" style="box-shadow: 0 0 5px 0 #cccccc; padding: 10px">
                                    <h4><b>{{trans('general.by')}}:</b>{{trans('general.client')}}</h4>
                                    {{$ticket->message}}
                                </div><br>
                                @foreach($replies as $reply)
                                    <div class="reply" style="box-shadow: 0 0 5px 0 #cccccc; padding: 10px">
                                        <h4><b>{{trans('general.by')}}:</b>{{$reply->from}}<small>-{{$reply->type}}</small></h4>
                                        {{$reply->reply}}
                                    </div><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

        <div class="modal fade order-modal" id="replyModal" style="top: 100px;">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content {{(App::getLocale()==='ar')?'text-right':''}}">
                    <div class="modal-header">
                        <button type="button" class="close {{(App::getLocale()==='ar')?'pull-left':''}}" data-dismiss="modal">x</button>
                        <h3>Reply</h3>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('admin.reply-ticket',App::getLocale())}}" method="post">
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

    </div>
    <!-- /#page-wrapper -->

@endsection