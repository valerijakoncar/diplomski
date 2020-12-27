<?php


namespace App\Models;


class Distributer
{
    public function getDistributers(){
        return \DB::table("distributer")
            ->select("name","id")
            ->get();
    }
}
