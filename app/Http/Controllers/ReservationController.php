<?php

namespace App\Http\Controllers;

use App\Models\Projection;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends FrontController
{
    private $reservationModel;
    private $projectionModel;

    public function __construct(){
        parent::__construct();
        $this->reservationModel = new Reservation();
        $this->projectionModel = new Projection();
    }

    public function continueReservation(Request $request){
        $movieId = $request->input("reservationMovieDdl");
        $projectionId = $request->input("reservationProjectionDdl");
        $date = $request->input("reservationDateDdl");
        $dayOfWeek = $this->getWeekday($date);
        $dayOfWeek = intval($dayOfWeek);
       // dd($dayOfWeek);
        $seats = $request->input("numSeats");
        $projectionInfo = $this->projectionModel->getProjection($projectionId);//$movieId,
//        dd($projectionInfo);
        $price = $this->reservationModel->calculetePriceReservation($dayOfWeek, $projectionInfo->idTechnology)->price;
        $pricePerTicket = $price;
        $price *= $seats;
        $this->data["pricePerTicket"] = $pricePerTicket;
        $this->data["projectionInfo"] = $projectionInfo;
        $this->data["price"] = $price;
        $this->data["seats"] = $seats;
        $this->data['hallRows'] = $this->reservationModel->getHallRows($projectionInfo->idHall,$projectionId);
        return view("pages.reservation", $this->data);
    }

    public function getWeekday($date = 0){
        date_default_timezone_set('Europe/Belgrade');
        if($date){
            $weekday = date('w', strtotime($date));
            if($weekday === '0'){//Sunday
                $weekday = '7';
            }
        }

        return $weekday;// - 1
    }

    public function makeReservation(Request $request){
       $seatsNum = $request->input("seatsNum");
       $seatIdArray = $request->input("seatIdArray");
       $projectionId =  $request->input("projectionId");
       $userId = $request->session()->get('user')->id;
       date_default_timezone_set('Europe/Belgrade');
       $todayDate = date("Y-m-d H:i:s");
       $code = $this->reservationModel->makeReservation($seatsNum, $projectionId,$userId, $todayDate, $seatIdArray);
       return response()->json("", $code);
    }

    public function continueProjectionReservation($projectionId){
        $projectionInfo = $this->projectionModel->getProjection($projectionId);
        $dayOfWeek = $this->getWeekday($projectionInfo->starts_at);
        $dayOfWeek = intval($dayOfWeek);
        $pricePerTicket = $this->reservationModel->calculetePriceReservation($dayOfWeek, $projectionInfo->idTechnology)->price;
        $price = $pricePerTicket * 1;//default seats num is 1
        $this->data["pricePerTicket"] = $pricePerTicket;
        $this->data["projectionInfo"] = $projectionInfo;
        $this->data["price"] = $price;
        $this->data["seats"] = 1;
        $this->data['hallRows'] = $this->reservationModel->getHallRows($projectionInfo->idHall,$projectionId);
        return view("pages.reservation", $this->data);
    }
}
