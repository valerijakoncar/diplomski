<?php

namespace App\Http\Controllers;

use App\Models\Projection;
use Illuminate\Http\Request;

class ProjectionController extends Controller
{
    private $projectionModel;

    public function __construct(){
        $this->projectionModel = new Projection();
    }

    public function getProjectionsDdl(Request $request){
        $date = $request->input("date");
        $dateArray = $this->getDate($date);//$date !!!
        $movieId =  $request->input("movieId");
        $projections = $this->projectionModel->getProjectionsDdl($dateArray, $movieId);
        return response()->json(['projections' => $projections], 200);
    }

    public function getDate($date = 0)
    {
        date_default_timezone_set('Europe/Belgrade');
//    $date = 0;
        if($date){
            $todayDate = $date;
            $plus1Day = date('Y-m-d', strtotime($todayDate. ' + 1 days'));
            $minus1Day = date('Y-m-d', strtotime($todayDate. ' - 1 days'));
            $todayDate =  date('Y-m-d', strtotime($todayDate));
        }else{
            $todayDate = date("Y-m-d",  strtotime("2020-12-26"));
            $plus1Day = date('Y-m-d', strtotime($todayDate . ' + 1 days'));
            $minus1Day = date('Y-m-d', strtotime($todayDate . ' - 1 days'));
        }
        $minus1Day = $minus1Day . " 23:59:59";
        $timeNow = " 15:00:00";
        $dateTimeNow = $todayDate . $timeNow;

        $dateArray = [ "plus1Day" => $plus1Day, "minus1Day" => $minus1Day, "todayDate" => $todayDate, "dateTimeNow" => $dateTimeNow];
        return $dateArray;
    }
}
