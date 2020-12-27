<?php


namespace App\Models;


class Reservation
{
    public function makeReservation($seatsNum, $projectionId,$userId, $todayDate, $seatIdArray){
        $code = 200;
        try{
            $success = \DB::table("reservation")
                ->insertGetId([
                    "id" => NULL,
                    "user_id" => $userId,
                    "projection_id" => $projectionId,
                    "reserved_at" => $todayDate,
                    "tickets_number" => $seatsNum
                ]);
            if($success){
                foreach($seatIdArray as $s){
                    $success2 = \DB::table("reservation_seat")
                        ->insertGetId([
                            "id" => NULL,
                            "seat_id" => $s,
                            "reservation_id" => $success
                        ]);
                    if(!$success2){
                        $code = 409;
                        break;
                    }
                }

                $code = 201;
            }else{
                $code = 409;
            }

        }catch(\PDOException $ex){
            $code = 409;
            //dd($ex->getMessage());
        }
        return $code;
    }

    public function calculetePriceReservation($dayOfWeek, $idTechnology){
        return \DB::table("price_weekday_technology as pwt")
            ->select("price")
            ->where([
                ["pwt.weekday_id", $dayOfWeek],
                ["pwt.technology_id", $idTechnology]
            ])
            ->first();
    }

    public function getHallRows($idHall, $projectionId){
        $rows = \DB::table("row as r")
            ->where("r.hall_id",$idHall)
            ->orderBy("r.id","desc")
            ->get();
        foreach($rows as $r){
            $r->seats = $this->getRowSeats($r->id, $projectionId);
        }
        return $rows;
    }

    public function getRowSeats($rowId, $projectionId){
        $seats =  \DB::table("seat as s")
            ->where("s.row_id",$rowId)
            ->get();
        foreach($seats as $s){
            $s->is_available = $this->isSeatAvailable($projectionId,$s->id);
        }
        return $seats;
    }

    public function isSeatAvailable($projectionId, $seatId){
        $exists = \DB::table("reservation as r")
            ->join("reservation_seat as rs","r.id","rs.reservation_id")
            ->where([
                ["r.projection_id",$projectionId],
                ["rs.seat_id", $seatId]
            ])
            ->first();
        if($exists){
            return 0;
        }
        return 1;
    }
}
