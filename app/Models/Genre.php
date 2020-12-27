<?php


namespace App\Models;


class Genre
{
    public function getGenres(){
        return \DB::table("genre")
            ->get();
    }

}
