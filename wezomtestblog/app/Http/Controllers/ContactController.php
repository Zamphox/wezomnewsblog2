<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Validator;
use Session;
use Mail;

class ContactController extends Controller
{
    //
    public function show(Request $request){
    	return view('default.contact');
    }

    public function mail(Request $request){

    		$validate = Validator::make($request->all(),[
    			'name'=>'required|min:4|regex:/^[\p{L}\p{N}\s]+$/u',
    			'email'=>'required|email',
    			'message'=>'required|regex:/^[\p{L}\p{N}\s]+$/u',
				'phone'=>'required|min:10|max:13|regex:/^[\p{N}+]+$/u'

    		],[
                'phone.regex'=>'Только цифры и "+"',
            ]);

    	if($validate->fails()){
			return redirect()->back()->withErrors($validate)->withInput();
    	}

		if(empty($request['g-recaptcha-response'])){
			return redirect('contact')->with('failed','reCAPTCHA не пройдена')->withErrors($validate)->withInput();
		}

		mail('zamphox@gmail.com',$request->email, $request->message . '
		' . $request->name . ' ' . $request->phone);

        return redirect('contact')->with('success','Сообщение отправлено');

    }

}