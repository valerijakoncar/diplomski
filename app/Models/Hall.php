<?php


namespace App\Models;


class Hall
{
    public function  getHalls(){
        return \DB::table("hall")
            ->get();
    }
}
