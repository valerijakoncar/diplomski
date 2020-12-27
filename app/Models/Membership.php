<?php


namespace App\Models;


use http\Client\Request;

class Membership
{
    public function becomeMember($memberName, $memberLastname, $memberEmail, $userId){
        $code = 200;
        $query = [
            "id" => NULL,
            "firstname" => $memberName,
            "lastname" => $memberLastname,
            "email" => $memberEmail,
            "user_id" => $userId
        ];
        if(!$userId){
            $query["user_id"] = NULL;
        }
        try{
            $id = \DB::table("member")
                ->insertGetId($query);
            if($id){
                $code = 201;
            }else{
                $code = 409;
            }
        }catch (\PDOException $ex){
            $ex->getMessage();
            $code = 409;
        }
        return $code;
    }

    public function getMember($memberEmail){
        return \DB::table("member")
            ->where("email", $memberEmail)
            ->first();
    }
}
