<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller {
   public static function sendEmail(String $view, $data, $emailReceive, $subject) {
        Mail::send($view, $data,
            function($message) use($emailReceive, $subject){
                $message->to($emailReceive, 'Receiver')->subject($subject);
                $message->from(env('MAIL_FROM_ADDRESS', 'trtheanh96@gmail.com'),env('MAIL_FROM_NAME', 'Travel App'));
            });
   }
}