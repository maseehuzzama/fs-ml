<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Auth;
use App\Ticket;
use App\TicketReply;
use App\TicketCategory;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function newTickets($locale){
        App::setLocale($locale);

        $newTickets = Ticket::where(['status'=>'Open','stage'=>'new'])->get();
        return view('admin.tickets.new-tickets',compact('newTickets'));
    }

    public function pendingTickets($locale){
        App::setLocale($locale);

        $pendingTickets = Ticket::where(['status'=>'Open'])->whereIn('stage',['customer-reply','customer-waiting'])->paginate(20);
        return view('admin.tickets.pending-tickets',compact('pendingTickets'));
    }

    public function closedTickets($locale){
        App::setLocale($locale);

        $closedTickets = Ticket::where(['status'=>'Closed'])->paginate(20);
        return view('admin.tickets.closed-tickets',compact('closedTickets'));
    }

    public function ticket($id,$ticket_id,$locale){
        App::setLocale($locale);
        $ticket = Ticket::where(['id'=>$id,'ticket_id'=>$ticket_id])->first();
        $replies = TicketReply::where('ticket_id',$ticket_id)->get();
        return view('admin.tickets.ticket',compact('ticket','replies'));
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
            'type'     => 'customer-waiting',
        ]);
        if($reply->save()){
            $ticket->stage = 'customer-waiting';
            $ticket->update();
        }
        return redirect()->back()->with("status", 'A reply has been submitted.');
    }
}
