<?php


namespace App\Models;


class Price
{
        public function getPrices(){
            return \DB::table("price_weekday_technology as pwt")
                ->join("headline as h","pwt.headline_id", "h.id")
                ->select("h.text","pwt.price")
                ->groupBy("h.text","pwt.price")
                ->get();
        }
}
