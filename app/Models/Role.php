<?php


namespace App\Models;


class Role
{
    public function getRoles(){
        return \DB::table("role")
            ->get();
    }
}
