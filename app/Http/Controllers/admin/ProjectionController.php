<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsertProjectionsRequest;
use App\Http\Requests\UpdateProjectionRequest;
use App\Models\Activity;
use App\Models\Projection;
use App\Models\Technology;
use Illuminate\Http\Request;

class ProjectionController extends Controller
{
    private $projectionModel;
    private $technologyModel;
    private $activityModel;

    public function __construct()
    {
        $this->projectionModel = new Projection();
        $this->technologyModel = new Technology();
        $this->activityModel = new Activity();
    }

    public function deleteProjection($id){
        $this->projectionModel->deleteProjection($id);
        $text = $_SERVER['REMOTE_ADDR'] . "\t" . session('user')->username . " deleted projection with id: ". $id . "\t";
        $userId = session()->get('user')->id;
        $this->activityModel->write($text, date("Y.m.d H:i:s"), $userId);
        return back();
    }

    public function updateProjection(UpdateProjectionRequest $request){
        $idProjection = $request->input("idProjHidden");
//        dd($idProjection);
        $movie = $request->input("movieProjectionUpdate");
        $date = $request->input("dateProjectionUpdate");
        $time = $request->input("timeProjectionUpdate");
        $technology = $request->input("technProjectionUpdate");
        $reservation = $request->input("resProjectionUpdate");
        $hall = $request->input("hallProjectionUpdate");
        $dateTimeProj = $date . " " . $time . ":00";
        $dateArray = $this->getDate($dateTimeProj);

        $projections = $this->projectionModel->projectionAvailable($hall, $dateArray, $idProjection);
//        dd($projections);
        $available = 1;
        foreach($projections as $p){
            if($p->starts_at == $dateTimeProj){
                $available = 0;
                break;
            }else if($p->starts_at > $dateTimeProj) {
                $whenWouldOurProjEnd = $this->whenWouldOurProjEnd($dateTimeProj, $p->running_time);
//                dd($whenWouldOurProjEnd);
                if ($p->starts_at <= $whenWouldOurProjEnd) {
                    $available = 0;
                    break;
                }
            }else if($p->hallFreeAt >= $dateTimeProj){//za projekcije koje pocinju pre izbranog vremena za novu projekciju
//               dd("ggg");
                $available = 0;
                break;
            }
        }
        if($available){
            try{
                $id = $this->projectionModel->updateProjection($idProjection, $movie, $dateTimeProj, $hall, $technology, $reservation);
                $text = $_SERVER['REMOTE_ADDR'] . "\t" . session('user')->username . " updated projection with id: ". $idProjection . "\t";
                $userId = session()->get('user')->id;
                $this->activityModel->write($text, date("Y.m.d H:i:s"), $userId);
                return back()->with("successUpdProj", "Projection was updated successfully.");
            }catch(\PDOException $ex){
//                dd($ex->getMessage());
                return back()->with("errorUpdProj", "There was an error.");
            }
        }else{
            return back()->with("errorUpdProj", "Choosen hall is not available.");
        }
    }

    public function whenWouldOurProjEnd($date, $running_time){
        $timeToAdd = $running_time + 30;
        $addedMinutes = strtotime("+" . $timeToAdd ." minutes", strtotime($date));
        return date('Y-m-d H:i:s', $addedMinutes);
    }

    public function getProjections(Request $request){
        $searched = $request->input("searched");
        $projections = $this->projectionModel->getProjections($searched);
        return response(["projections" => $projections], 200);
    }

    public function getProjectionData($id){
        $projection = $this->projectionModel->getProjection($id);
        $movieTechn = $this->technologyModel->getMovieTechnologiesProjection($id);
        return response(["projection" => $projection, "technologies" => $movieTechn], 200);
    }

    public function insertProjections(InsertProjectionsRequest $request){
//        dd($request);
        $projectionMovies = $request->input("projectionMovie");
        $projectionDates = $request->input("projectionDate");
        $projectionTimes = $request->input("projectionTime");
        $projectionTechnologies = $request->input("projectionTechnology");
        $projectionHalls = $request->input("projectionHall");
        $projectionsResAvailable = $request->input("projectionResAvailable");
        $dateTimeProjs = [];
        for($i = 0; $i < count($projectionMovies); $i++){
            $dateTimeProj = $projectionDates[$i] . " " . $projectionTimes[$i] . ":00";
            $dateTimeProjs[] = $dateTimeProj;
            $dateArray = $this->getDate($dateTimeProj);
            $projections = $this->projectionModel->projectionAvailable($projectionHalls[$i], $dateArray);
            $available = 1;
            foreach($projections as $p){
                if($p->starts_at == $dateTimeProj){
                    $available = 0;
                    break;
                }else if($p->starts_at > $dateTimeProj) {
                    $whenWouldOurProjEnd = $this->whenWouldOurProjEnd($dateTimeProj, $p->running_time);
//                dd($whenWouldOurProjEnd);
                    if ($p->starts_at <= $whenWouldOurProjEnd) {
                        $available = 0;
                        break;
                    }
                }else if($p->hallFreeAt >= $dateTimeProj){//za projekcije koje pocinju pre izbranog vremena za novu projekciju
                    $available = 0;
                    break;
                }
            }
            if(!$available) {
                break;
            }
        }
        if($available){
           try{
               $userId = session()->get('user')->id;
               for($i = 0; $i < count($projectionMovies); $i++) {
                   $id = $this->projectionModel->insertProjections($projectionMovies[$i], $dateTimeProjs[$i], $projectionHalls[$i], $projectionTechnologies[$i], $projectionsResAvailable[$i]);
                   $text = $_SERVER['REMOTE_ADDR'] . "\t" . session('user')->username . " inserted projection with id: ". $id . "\t";
                   $this->activityModel->write($text, date("Y.m.d H:i:s"), $userId);
               }
               return back()->with("successProjectionInsert", "Projections were inserted successfully.");
           }catch(\PDOException $ex){
               dd($ex->getMessage());
               return back()->with("errorProjectionInsert", "There was an error.");
           }
        }else{
            return back()->with("errorProjectionInsert", "Choosen hall is not available.");
        }
    }

    public function getDate($date = 0){
        date_default_timezone_set('Europe/Belgrade');
//        $date = 0;//obrisati
        if($date){
            $todayDate = $date;
            $plus1Day = date('Y-m-d', strtotime($todayDate. ' + 1 days'));
            $minus1Day = date('Y-m-d', strtotime($todayDate. ' - 1 days'));
            $todayDate =  date('Y-m-d', strtotime($todayDate));
        }else{
            $todayDate = date("Y-m-d",  strtotime("2020-12-26"));
            $plus1Day = date('Y-m-d', strtotime($todayDate . ' + 1 days'));
            $minus1Day = date('Y-m-d', strtotime($todayDate. ' - 1 days'));
        }
        $minus1Day = $minus1Day . " 23:59:59";
        $timeNow = " 15:00:00";
        $dateTimeNow = $todayDate . $timeNow;

        $dateArray = [ "plus1Day" => $plus1Day, "minus1Day" => $minus1Day, "todayDate" => $todayDate, "dateTimeNow" => $dateTimeNow];
        return $dateArray;
    }

}
