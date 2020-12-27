<?php


namespace App\Models;


class Author
{
    public function getAuthorInfo(){
        return \DB::table("author")
            ->first();
    }
}
