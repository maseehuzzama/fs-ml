<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\FastStarContact;
use Mail;
use Session;
use App\Order;
use Illuminate\Support\Facades\App;
class AppController extends Controller
{
    public function postContact(Request $request){
        $this->Validate($request,array(
            'name'=>'required',
            'email'=>'required|email',
            'subject'=>'required',
            'message'=>'required'
        ));

        $content = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        $receiverAddress = 'info@faststardlv.com';

        Mail::to($receiverAddress)->send(new FastStarContact($content));

        return redirect()->back()->with('success', 'Your Message has been submitted. Thank You');
    }

    public function searchOrder(Request $request,$locale){
        App::setLocale($locale);
        $this->validate($request,[
            'search'=>'required',
        ]);
        $order = Order::where('ref_number',$request['search'])->first();
        return view('client.order-show',compact('order'));
    }

}
