<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    private $messageModel;

    public function __construct()
    {
       $this->messageModel = new Message();
    }

    public function contactAdmin(Request $request){
        $email = $request->input("emailAddress");
        $question = $request->input("body");
        try{
            $this->messageModel->contactAdmin($email,$question);
            return back()->with("success","Your message was sent.");
        }catch(\PDOException $ex){
            return back()->with("error","There was an error. Try again.");
        }
    }

    public function contactCinema(Request $request){
        $firstname = $request->input("firstnameContCin");
        $lastname = $request->input("lastnameContCin");
        $email = $request->input("emailAddressContCin");
        $question = $request->input("question");
       try{
           $this->messageModel->contactCinema($firstname,$lastname,$email,$question);
           return back()->with("success","Your message was sent.");
       }catch(\PDOException $ex){
           return back()->with("error","There was an error. Try again.");
       }
    }
}
