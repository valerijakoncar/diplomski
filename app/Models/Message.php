<?php


namespace App\Models;


class Message
{
    public  function contactAdmin($email,$question){
        return \DB::table("message")
            ->insertGetId([
                "id" => NULL,
                "email" => $email,
                "text" => $question,
                "firstname" => NULL,
                "lastname" => NULL,
                "is_read" => 0
            ]);
    }

    public  function contactCinema($firstname,$lastname,$email,$question){
        return \DB::table("message")
            ->insertGetId([
                "id" => NULL,
                "email" => $email,
                "text" => $question,
                "firstname" => $firstname,
                "lastname" => $lastname,
                "is_read" => 0
            ]);
    }
}
