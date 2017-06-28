<?php

namespace App\Http\Controllers\Client;

use App\TicketReply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Auth;
use App\Order;
use App\Ticket;
use App\TicketCategory;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function myTickets($locale){
        App::setLocale($locale);
        $tickets = Ticket::orderBy('updated_at','desc')->where('user_id',Auth::user()->id)->paginate(20);
        return view('client.tickets.my-tickets',compact('tickets'));
    }

    public function ticketShow($locale, $id){
        App::getLocale($locale);
        $ticket = Ticket::where(['id'=>$id,'user_id'=>Auth::user()->id])->first();
        $replies = TicketReply::where(['ticket_id'=>$ticket->ticket_id,'user_id'=>Auth::user()->id])->get();
        if($ticket){
            return view('client.tickets.ticket-show',compact('ticket','replies'));
        }
        return abort(403,'No Ticket Found');
    }

    public function getNewTicket($locale){
        App::setLocale($locale);
        $categories = TicketCategory::all();
        return view('client.tickets.new-ticket',compact('categories'));

    }

    public function postNewTicket(Request $request,$locale){
        App::setLocale($locale);
        $this->validate($request, [
            'title'     => 'required',
            'category'  => 'required',
            'priority'  => 'required',
            'type'  => 'required',
            'message'   => 'required'
        ]);

        $ticket = new Ticket([
            'title'     => $request->input('title'),
            'ticket_id'   =>  strtoupper(str_random(10)),
            'user_id'   => Auth::user()->id,
            'category_id'  => $request->input('category'),
            'priority'  => $request->input('priority'),
            'service_type'  => $request->input('type'),
            'reference'  => $request->input('reference'),
            'message'   => $request->input('message'),
            'status'    => "Open",
            'stage'    => "new",
        ]);

        $ticket->save();

        return redirect()->back()->with("status", 'A ticket has been opened.');
    }

    public function getNewReply(){

    }

    public function postReplyTicket(Request $request, $locale){
        App::setLocale($locale);
        $this->validate($request, [
            'reply'     => 'required',
        ]);

        $ticket = Ticket::where('ticket_id',$request['ticket_id'])->first();

        $reply = new TicketReply([
            'reply'     => $request->input('reply'),
            'ticket_id'     => $request->input('ticket_id'),
            'user_id'     => Auth::user()->id,
            'from'     => Auth::user()->name,
            'type'     => 'customer-reply',
        ]);
        if($reply->save()){
            $ticket->stage = 'customer-reply';
            $ticket->update();
        }
        return redirect()->back()->with("status", 'A reply has been submitted.');
    }
}
