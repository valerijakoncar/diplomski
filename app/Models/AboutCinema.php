<?php


namespace App\Models;


class AboutCinema
{
    public function getAboutCinemaText(){
        return \DB::table("about_cinema")
            ->first();
    }
}
