<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsertMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Activity;
use App\Models\Movie;
use App\Models\Technology;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    private $movieModel;
    private $technologyModel;
    private $activityModel;

    public function __construct()
    {
        $this->movieModel = new Movie();
        $this->technologyModel = new Technology();
        $this->activityModel = new Activity();
    }

//    public function pokusaj(Request $request){
//        $response = cloudinary()->upload($request->file('pokusaj')->getRealPath())->getSecurePath();
//
//        dd($response);
//    }

    public function deleteMovie($id){
        try{
            $this->movieModel->deleteMovie($id);
            $text = $_SERVER['REMOTE_ADDR'] . "\t" . session('user')->username . " deleted movie with id: ". $id . "\t";
            $userId = session()->get('user')->id;
            $this->activityModel->write($text, date("Y.m.d H:i:s"), $userId);
            return back();
        }catch (\PDOException $ex){
            return back()->with("errorDel","There was an error.");
        }
    }

    public function getMovieTechnologies($movieId){
        $technologies = $this->technologyModel->getMovieTechnologies($movieId);
        return response()->json(["technologies" => $technologies], 200);
    }

    public function insertMovie(InsertMovieRequest $request){
        //InsertMovieRequest
//        dd($request);
        $name = $request->input("nameMovIns");
        $running_time = $request->input("timeMovIns");
        $desc = $request->input("taShortDescIns");
        $detailed_desc = $request->input("taDetailedDescIns");
        $distributer = $request->input("distributerMovIns");
        $director = $request->input("directorMovIns");
        $technology = $request->input("technologiesMovIns");
        $technologyArray = [];
        if($technology == 3){
            $techns = $this->technologyModel->getTechnologies();
            foreach($techns as $t){
                $technologyArray[]  = $t->id;
            }

        }else{
            $technologyArray[] = $technology;
        }
        $country = $request->input("countryMovIns");
        $date = $request->input("dateMovIns");
        $actors = array_unique($request->input("actorInsertHidden"));
        $genres = array_unique($request->input("genreInsertHidden"));
        $age_limit = $request->input("ageMovIns");
        $cs = $request->input("csMovIns");
        $activeSlider = $request->input("activeSliderMovIns");

        $picIds = [];
        $imgName = "picMovIns";
//        dd($request->file("picMovIns")->getRealPath());
        $picId = 0;
        if (!empty($_FILES[$imgName]['name'])) {
            $picId = $this->proccessImg($request->file("picMovIns")->getRealPath(),$imgName);
            if($picId){
                $picIds["picture_id"] = $picId;
            }
        }
        $imgNameBg = "picMovBgIns";
        $picBgId = 0;
        if (!empty($_FILES[$imgNameBg]['name'])) {
            $picBgId = $this->proccessImg($request->input("picMovBgIns")->getRealPath(),$imgNameBg);
            if($picBgId){
                $picIds["about_movie_pic_id"] = $picBgId;
            }
        }
        $imgNameSlider = "picSliderMovUpd";
        $picSliderId = 0;
        if ($request->input("picSliderMovIns") != null) {
            $picSliderId = $this->proccessImg($request->input("picSliderMovIns")->getRealPath(),$imgNameSlider);//ova funkcija ne obradjuje sliku
            if($picSliderId){
                $picIds["slider_picture_id"] = $picSliderId;
            }
        }

        try{
           $movieId = $this->movieModel->insertMovie($name, $running_time, $desc, $detailed_desc, $distributer, $director,$country, $date, $actors, $genres, $age_limit, $cs);
           $this->movieModel->insertMovieImages($movieId, $picIds, $activeSlider);
//           dd($technologyArray);
           foreach($technologyArray as $t){
               $this->technologyModel->insertTechnologyMovie($t, $movieId);
           }
            $text = $_SERVER['REMOTE_ADDR'] . "\t" . session('user')->username . " inserted movie with id: ". $movieId . "\t";
            $userId = session()->get('user')->id;
            $this->activityModel->write($text, date("Y.m.d H:i:s"), $userId);
            return back()->with("successIns","New movie was inserted.");
        }catch(\PDOException $ex){
//            dd($ex->getMessage());
            return back()->with("errorIns","There was an error.");
        }
    }

    public function updateMovie(UpdateMovieRequest $request){
//        dd($request);
        $id = $request->input("movieIdHidden");
        $name = $request->input("nameMovUpd");
        $running_time = $request->input("timeMovUpd");
        $desc = $request->input("taShortDesc");
        $detailed_desc = $request->input("taDetailedDesc");
        $distributer = $request->input("distributerMovUpd");
        $director = $request->input("directorMovUpd");
        $technology = $request->input("technologiesMovUpd");
        $technologyArray = [];
        if($technology == 3){
            $techns = $this->technologyModel->getTechnologies();
            foreach($techns as $t){
                $technologyArray[]  = $t->id;
            }
        }else{
            $technologyArray[] = $technology;
        }
        $country = $request->input("countryMovUpd");
        $date = $request->input("dateMovUpd");
        $actors = array_unique($request->input("actorHidden"));
        $genres = array_unique($request->input("genreHidden"));
        $age_limit = $request->input("ageMovUpd");
        $cs = $request->input("csMovUpd");
        $activeSlider = $request->input("activeSliderMovUpd");

        $picIds = [];
        $imgName = "picMovUpd";
        $picId = 0;
        if ($request->input("picMovUpd") != null) {
            $picId = $this->proccessImg($request->input("picMovUpd"));
            if($picId){
                $picIds["picture_id"] = $picId;
            }
        }
        $imgNameBg = "picMovBgUpd";
        $picBgId = 0;
        if ($request->input("picMovBgUpd") != null) {
            $picBgId = $this->proccessImgMovieBg($request->input("picMovBgUpd"));
            if($picBgId){
                $picIds["about_movie_pic_id"] = $picBgId;
            }
        }
        $imgNameSlider = "picSliderMovUpd";
        $picSliderId = 0;
        if ($request->input("picSliderMovUpd") != null) {
            $picSliderId = $this->proccessImgMovieBg($request->input("picSliderMovUpd"));//ova funkcija ne obradjuje sliku
            if($picSliderId){
                $picIds["slider_picture_id"] = $picSliderId;
            }
        }
        try{
            $this->movieModel->updateMovie($id, $name, $running_time, $desc, $detailed_desc, $distributer, $director,$country, $date, $actors, $genres, $age_limit, $cs);
            $this->movieModel->updateMovieImages($id, $picIds, $activeSlider);
            $this->technologyModel->deleteTechnologyMovie($id);
            foreach($technologyArray as $t){
                $this->technologyModel->insertTechnologyMovie($t, $id);
            }
            $text = $_SERVER['REMOTE_ADDR'] . "\t" . session('user')->username . " updated movie with id: ". $id . "\t";
            $userId = session()->get('user')->id;
            $this->activityModel->write($text, date("Y.m.d H:i:s"), $userId);
            return back()->with("success","Changes were made successfully.");
        }catch(\PDOException $ex){
            return back()->with("error","There was an error");
        }

    }

    public function getMovieData(Request $request){
        $id = $request->input("id");
        $movie = $this->movieModel->getMovieData($id);
        return response()->json(["movie" => $movie], 200);
    }

    public function getMovies($offset, $searched){
        $movies = $this->movieModel->getMoviesAdmin($offset, $searched);
        //dd($movies);
        return response()->json(["movies"=>$movies], 200);
    }

    public function proccessImg($imgPath, $fileName){
        $picName = $_FILES[$fileName]['name'];


        $imgArray = explode("/", $imgPath);
//        $fileName = end($imgArray);
        $extension = strtolower(explode(".",$picName)[1]);
        $type = "";
        if($extension == 'jpg'){
            $type = "image/jpg";
        }else if($extension == 'png'){
            $type = "image/png";
        }else if($extension == 'jpeg'){
            $type = "image/jpeg";
        }
        $finalFileName = time() . "_" . $picName;
//        $folder = 'images/edited/';
        $alt = explode(".",$picName);
        $alt = $alt[0];

//        $new_image = $this->createImgInColor($imgPath, $type);

        $smallerFileName = 'edited_' . $finalFileName;
        array_pop($imgArray);
        $imgPathString = implode("/",$imgArray);
        $imgPathString .= "/";
//        $path = $folder . $finalFileName;
//        $smallerFilePath = $folder . $smallerFileName;

//        switch ($type) {
//            case 'image/jpeg':
//                imagejpeg($new_image, $smallerFilePath, 75);
//                break;
//            case 'image/png':
//                imagepng($new_image, $smallerFilePath);
//                break;
//            case 'image/jpg':
//                imagejpg($new_image, $smallerFilePath);
//                break;
//        }
//        dd(realpath("images/tenet4.jpg"));
//        $file = fopen ("images/edited/beauty.png", "rb");//$imgPath
//        if ($file) {
//        //SLIKA je vec uploadovana na server tako da je ovo nepotrebno
//            //echo "Slika je upload-ovana na server!";
//            $newf = fopen ($smallerFilePath, "a"); // to overwrite existing file
//
//            if ($newf){
//                while(!feof($file)) {
//                    fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
//
//                }
//            }else{
//                dd("ff");
//            }
//            if ($file) {
//                fclose($file);
//            }
//
//            if ($newf) {
//                fclose($newf);
//            }

            try{
//                $response = cloudinary()->upload($request->file('pokusaj')->getRealPath())->getSecurePath();
                $response = cloudinary()->upload( $_FILES[$fileName]['tmp_name'])->getSecurePath();
                dd($response);
                $picId = $this->movieModel->insertImage($smallerFileName, $alt, $type, $imgPathString);
                return $picId;
            }catch (\PDOException $ex){
                return back()->with("error","There was an error");
            }
//        }
    }

    public function createImgInColor($tmpName, $type){
//        if(extension_loaded('gd')){
//            echo("loaded extension");
//        }

        list($width, $height) = getimagesize($tmpName);

        if ($type == "image/jpeg") {
            $img = imagecreatefromjpeg($tmpName);
        } else if ($type == "image/jpg") {
            $img = imagecreatefromjpg($tmpName);
        } else if ($type == "image/png") {
            $img = imagecreatefrompng($tmpName);
        }
        //Kreiranje nove slike u koloru
        $newWidth = 250;
        $procentage = $newWidth / $width;
        $newHeight = $height * $procentage;
        $empty_image = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($empty_image, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        $new_image = $empty_image;
        return $new_image;
    }

    public function proccessImgMovieBg($imgPath){
//        $fileName = $_FILES[$imgName]['name'];
        $imgArray = explode("/", $imgPath);
        $fileName = end($imgArray);
        $extension = strtolower(explode(".",$fileName)[1]);
        $type = "";
        if($extension == 'jpg'){
            $type = "image/jpg";
        }else if($extension == 'png'){
            $type = "image/png";
        }else if($extension == 'jpeg'){
            $type = "image/jpeg";
        }
        $finalFileName = time() . "_" . $fileName;
//        $tmpName = $_FILES[$imgName]['tmp_name'];
        $folder = 'images/edited/';
//        $type = $_FILES[$imgName]['type'];
        $alt = explode(".",$fileName);
        $alt = $alt[0];
        $path =  $folder . $finalFileName;
//        "https://diplomski-movie-blackout.herokuapp.com/" .
        $file = fopen ($imgPath, "rb");
        if ($file) {
            //SLIKA je vec uploadovana na server tako da je ovo nepotrebno
            //echo "Slika je upload-ovana na server!";
            $newf = fopen ($path, "a"); // to overwrite existing file

            if ($newf){
                while(!feof($file)) {
                    fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );

                }
            }
            if ($file) {
                fclose($file);
            }

            if ($newf) {
                fclose($newf);
            }
            //echo "Slika je upload-ovana na server!";
            try{
                $picId = $this->movieModel->insertImage($finalFileName, $alt, $type, $folder);
                return $picId;
            }catch (\PDOException $ex){
                return back()->with("error","There was an error");
            }
        }
    }
}
