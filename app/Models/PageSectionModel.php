<?php


namespace App\Models;


class PageSectionModel
{
    public function getPageSection($table){
        return \DB::table($table)
            ->get();
    }
}
