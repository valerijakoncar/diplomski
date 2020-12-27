<?php


namespace App\Models;


class Country
{
    public function getCountries(){
        return \DB::table("country")
            ->select("name","id")
            ->get();
    }
}
