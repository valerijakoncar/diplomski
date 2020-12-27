<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends FrontController
{
    private $movieModel;

    public function __construct(){
        parent::__construct();
        $this->movieModel = new Movie();
    }

    public function getSliderData(){
        $sliderData = $this->movieModel->getSliderData();
        return response()->json(['movies' => $sliderData], 200);
    }

    public function getMovies($offset){
        $dateArray = $this->getDate();
        $movies = $this->movieModel->getMovies($dateArray,$offset);
        return response()->json(['movies' => $movies], 200);
    }

    public function filterMovies(Request $request){
        $date = $request->input('date');
        $dateArray = $this->getDate($date);
        $technology = $request->input('technology');
        $sort = $request->input("sort");
        $searched = $request->input("searched");
        $genre = $request->input("genre");
        $movies = $this->movieModel->filterMovies($dateArray, $technology, $sort, $searched, $genre);
        return response()->json(['movies' => $movies], 200);
    }

    public function getMovie($id){
//        $dateArray = $this->getDate();
        $movie = $this->movieModel->getMovie($id);
        $this->data['movie'] = $movie;
        return view("pages.movie_details", $this->data);
    }

    public function getMoviesDdl(Request $request){
        $date = $request->input("date");
        $dateArray = $this->getDate($date);
        $movies = $this->movieModel->getMoviesDdl($dateArray);
        return response()->json(['movies' => $movies], 200);
    }

    public function getDate($date = 0){
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

    public function rateMovie(Request $request){
        $idMovie = $request->input("idMovie");
        $grade = $request->input("grade");
        $idUser = $request->session()->get('user')->id;
        $userMovieGradeObj = $this->movieModel->getUserMovieGradeObj($idMovie, $idUser);
//        dd($userMovieGradeObj);
        if($userMovieGradeObj){
            $code = $this->movieModel->rateMovieUpdate($grade, $idMovie, $idUser);
        }else{
            $code = $this->movieModel->rateMovie($grade, $idMovie, $idUser);
        }
        return response()->json("", $code);
    }

    public function comingSoon(){
        $cs = $this->movieModel->comingSoon();
        $this->data['coming_soon'] = $cs;
        return view("pages.coming_soon", $this->data);
    }

}
