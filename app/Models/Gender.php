<?php


namespace App\Models;


class Gender
{
        public function  getGenders(){
            return \DB::table("user_genre")
                ->get();
        }
}
