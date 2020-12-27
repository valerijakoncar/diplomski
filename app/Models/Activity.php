<?php


namespace App\Models;


class Activity
{
    public function write($write, $date, $userId){
        return \DB::table("activity")
            ->insertGetId([
                "id" => NULL,
                "text" => $write,
                "activity_time" => $date,
                "user_id" => $userId
            ]);
    }

    public function print(){
        return \DB::table("activity")
            ->orderBy("activity_time", "DESC")
            ->get();

    }

    public function sortActivity($sort){
        return \DB::table("activity")
            ->orderBy("activity_time", $sort)
            ->get();
    }

}
