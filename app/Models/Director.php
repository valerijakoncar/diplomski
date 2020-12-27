<?php


namespace App\Models;


class Director
{
    public function getDirectors(){
        return \DB::table("director")
            ->select("name","id")
            ->get();
    }
}
