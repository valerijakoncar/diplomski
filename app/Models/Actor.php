<?php


namespace App\Models;


class Actor
{
    public function getActors(){
        return \DB::table("actor")
            ->select("name", "id")
            ->get();
    }
}
