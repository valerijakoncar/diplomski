<?php


namespace App\Models;


use DateInterval;
use DateTime;

class Movie
{
    private $limit = 4;
    private $limitComments = 5;
    private $adminLimit = 5;

    public function rateMovie($grade, $idMovie, $idUser){
        $code= 200;
       try{
           $id = \DB::table("user_movie_grade")
               ->insertGetId([
                   "id" => NULL,
                   "user_id" => $idUser,
                   "movie_id" => $idMovie,
                   "grade" => $grade
               ]);
           if($id){
               $code= 201;
           }else{
               $code = 409;
           }
       }catch(\PDOException $ex){
           $ex->getMessage();
           $code = 409;
       }
       return $code;
    }

    public function rateMovieUpdate($grade, $idMovie, $idUser){
        $code = 200;
        try{
            \DB::table("user_movie_grade")
                ->where([
                    ["movie_id", $idMovie],
                    ["user_id", $idUser]
                ])
                ->update([
                    "grade" => $grade
                ]);
           $code = 204;
        }catch(\PDOException $ex){
            $ex->getMessage();
            $code = 409;
        }
        return $code;
    }

    public function getUserMovieGradeObj($idMovie, $idUser){
        return \DB::table("user_movie_grade as umg")
            ->where([
                ["movie_id", $idMovie],
                ["user_id", $idUser]
            ])
            ->first();
    }

    public function filterMovies($dateArray, $technology, $sort, $searched, $genre){
        $continueQuery = $this->makeContinueQuery($dateArray["plus1Day"], $dateArray["minus1Day"],$technology, $searched, $genre);

        $movies =  \DB::table("movie AS m")
            ->join("movie_picture AS mp","m.id","mp.movie_id")
            ->join("picture AS p","mp.picture_id","p.id")
            ->join("projection as pro","pro.movie_id","m.id")
            ->join("movie_technology AS mt","pro.movie_technology_id","mt.id")
            ->join("movie_genre AS mg", "mg.movie_id", "m.id")
            ->join("genre AS g", "mg.genre_id", "g.id")
            ->select("m.id AS idMovie","m.description","m.name AS movieName","m.running_time","m.age_limit","m.description","m.in_cinemas_from","p.path","p.name AS picName","p.alt")
            ->where($continueQuery);
        $movies =  $movies->groupBy("idMovie","m.description","movieName","m.running_time","m.age_limit","m.description","m.in_cinemas_from","p.path","picName","p.alt" )
                            ->orderBy("m.name", $sort)
                            ->get();

        foreach($movies as $m){
            $m->grade = $this->getGrade($m->idMovie);
            $m->projections = $this->getProjections($m->idMovie, $dateArray, intval($technology));
            $m->genres = $this->getGenres($m->idMovie);
        }
       // dd($movies);
        return $movies;
    }

    public function makeContinueQuery($plus1Day, $minus1Day,$technology, $searched, $genre){
//        dd($minus1Day);
        $whereArray = [];
        array_push($whereArray,  ["pro.starts_at","<",$plus1Day], ["pro.starts_at",">",$minus1Day],
                                        ["m.is_deleted",0],["m.in_cinema",1],["pro.is_deleted",0]);

        if($technology != '0'){
            array_push($whereArray, ["mt.technology_id", intval($technology)]);
        }
        if($genre != '0'){
            array_push($whereArray, ["g.id",  intval($genre)]);
        }
        if($searched != ''){
            $stringToSearch = "%$searched%";
            array_push($whereArray, ["m.name", "LIKE" ,$stringToSearch]);
        }
        return $whereArray;
    }

    public function getSliderData(){
        $movies =  \DB::table("movie AS m")
            ->join("movie_picture AS mp","m.id","mp.movie_id")
            ->join("picture AS p","mp.slider_picture_id","p.id")
            ->join("director AS d","m.director_id","d.id")
            ->join("user_movie_grade AS umg","umg.movie_id","m.id")
            ->select("m.id AS idMovie","m.name AS movieName","m.running_time","m.in_cinemas_from","p.path","p.name AS picName","p.alt", "d.name AS dirName", \DB::raw("COUNT(*) AS voters"))
            ->where("mp.is_active_slider", 1)
            ->groupBy("idMovie", "movieName","m.running_time","m.in_cinemas_from","p.path", "picName","p.alt", "dirName")
            ->get();
        foreach($movies as $m){
            $m->grade = $this->getGrade($m->idMovie);
            $m->genres = $this->getGenres($m->idMovie);
            $m->actors = $this->getActors($m->idMovie);
        }

        return $movies;
    }

    public function getPaginationCount($dateArray){
        $prodNum = \DB::table("movie as m")
            ->join("projection as p", "m.id","p.movie_id")
            ->where([
                ["p.starts_at","<",$dateArray["plus1Day"]],
                ["p.starts_at",">",$dateArray["minus1Day"]],
                ["m.is_deleted",0],
                ["p.is_deleted", 0],
                ["m.in_cinema",1]
            ])
            ->select("m.id")
            ->groupBy("m.id")
            ->get();
        return ceil(count($prodNum) / $this->limit);
    }

    public function getMovies($dateArray,$offset = 0){//, $differentLimit = 0
        //$dateArray = $this->getDate();
        $offset = $offset * $this->limit;
        $movies =  \DB::table("movie AS m")
            ->join("movie_picture AS mp","m.id","mp.movie_id")
            ->join("picture AS p","mp.picture_id","p.id")
            ->join("projection as pro","pro.movie_id","m.id")
            ->select("m.id AS idMovie","m.description","m.name AS movieName","m.running_time","m.age_limit","m.description","m.in_cinemas_from","p.path","p.name AS picName","p.alt")
            ->where([
                ["pro.starts_at","<",$dateArray["plus1Day"]],
                ["pro.starts_at",">",$dateArray["minus1Day"]],
                ["pro.is_deleted",0],
                ["m.is_deleted",0],
                ["m.in_cinema",1]
            ]);
         $movies =  $movies->offset($offset)->limit($this->limit)
                    ->groupBy("idMovie","m.description","movieName","m.running_time","m.age_limit","m.description","m.in_cinemas_from","p.path","picName","p.alt" )
                    ->get();

        foreach($movies as $m){
            $m->grade = $this->getGrade($m->idMovie);
            $m->projections = $this->getProjections($m->idMovie,$dateArray);
            $m->genres = $this->getGenres($m->idMovie);
        }

        return $movies;
    }

    public function getGrade($idMovie){
        $gradeString = \DB::table("user_movie_grade AS umg")
                    ->select(\DB::raw("(SUM(grade)/COUNT(*)) AS grade"))
                    ->where("umg.movie_id",$idMovie)
                    ->groupBy("umg.movie_id")
                    ->first();
        if($gradeString){
            return number_format($gradeString->grade, 1);
        }
        return number_format("0", 1);
    }

    public function getProjections($idMovie, $dateArray, $technology = 0){
        $whereArray = [];
        array_push($whereArray, ["pr.movie_id",$idMovie],["pr.starts_at","<",$dateArray["plus1Day"]],["pr.starts_at",">",$dateArray["minus1Day"]],
            ["pr.is_deleted", 0]);
        if($technology != 0){
            array_push($whereArray, ["t.id",$technology]);
        }
        $projections = \DB::table("projection AS pr")
            ->join("hall AS h","pr.hall_id","h.id")
            ->join("movie_technology AS mt","pr.movie_technology_id", "mt.id")
            ->join("technology AS t","mt.technology_id","t.id")
            ->where($whereArray)
            ->select("pr.id","pr.starts_at","t.name AS technologyName","pr.reservation_available","h.name")
            ->orderBy("pr.starts_at")
            ->get();

        foreach($projections as $p){
            if($p->starts_at <= $dateArray["dateTimeNow"]){
                $p->projectionAlreadyStartedEnded = 1;
            }else{
                $p->projectionAlreadyStartedEnded = 0;
            }
        }
        return $projections;
    }

    public function getGenres($idMovie){
        return \DB::table("genre AS g")
            ->join("movie_genre AS mg","g.id","mg.genre_id")
            ->where("mg.movie_id",$idMovie)
            ->select("g.genre","g.id")
            ->get();
    }

    public function getActors($idMovie){
        return \DB::table("actor AS a")
                ->join("movie_actor AS ma","a.id","ma.actor_id")
                ->where("ma.movie_id",$idMovie)
                ->select("a.name","a.id")
                ->get();
    }

    public function getMovie($id){
        $movie = \DB::table("movie AS m")
                ->join("movie_picture AS mp","m.id","mp.movie_id")
                ->join("picture AS p","mp.picture_id","p.id")
                ->join("projection as pro","pro.movie_id","m.id")
                ->join("director AS d","m.director_id","d.id")
                ->join("distributer AS di","m.distributer_id","di.id")
                ->join("country as c","m.country_id","c.id")
                ->select("c.name AS country","di.name AS distributer","d.name AS director","m.id AS idMovie","m.description_detailed","m.name AS movieName","m.running_time","m.age_limit","m.description","m.in_cinemas_from","p.path","p.name AS picName","p.alt")//,"p1.name as sliderPicName"
                ->where([
                    ["m.id",$id],
//                    ["pro.starts_at","<",$dateArray["plus1Day"]],
//                    ["pro.starts_at",">",$dateArray["minus1Day"]]
                ])
                ->groupBy("c.name","di.name","d.name","idMovie","m.description_detailed","movieName","m.running_time","m.age_limit","m.description","m.in_cinemas_from","p.path","picName","p.alt")//,"p1.name"
                ->first();

//        $movie->projections = $this->getProjections($movie->idMovie, $dateArray);
        $movie->actors = $this->getActors($movie->idMovie);
        $movie->grade = $this->getGrade($movie->idMovie);
        $movie->genres = $this->getGenres($movie->idMovie);
        $movie->comments = $this->getComments($movie->idMovie);
        $movie->commentsCount = $this->getNumOfComments($movie->idMovie);
        $movie->backgroundPicName = $this->getBackgroundPicName($movie->idMovie);

        return $movie;
    }

    public function getBackgroundPicName($idMovie){
        return \DB::table("picture AS p")
            ->join("movie_picture AS mp", "p.id","mp.about_movie_pic_id")
            ->where("mp.movie_id",$idMovie)
            ->select("p.name","p.path")
            ->first();
    }

    public function getComments($idMovie){
        $com = \DB::table("comment AS c")
            ->join("user AS u","c.user_id","u.id")
            ->join("movie AS m", "c.movie_id","m.id")
            ->select("c.movie_id","c.id","c.text","c.inserted_at AS posted_at","c.updated_at","u.username","u.gender_id","u.registered_at","c.user_id", "m.id AS idMovie")
            ->where([
                ["m.id",$idMovie],
                ["c.is_deleted", 0],
                ["c.parent_id", NULL]
            ])
            ->offset(0)
            ->limit($this->limitComments)
            ->orderBy("c.inserted_at","desc")
            ->get();
        return $com;
    }

    public function getNumOfComments($idMovie){
        return \DB::table("comment")
            ->where([
                ["movie_id", $idMovie],
                ["is_deleted",0],
                ["parent_id", NULL]
            ])
            ->count();
    }

    public function getMoviesDdl($dateArray){

        $query = \DB::table("movie as m")
            ->join("projection as pro","pro.movie_id","m.id")
            ->select("m.id", "m.name");
            $query = $query->where([
                ["pro.starts_at","<",$dateArray["plus1Day"]],
                ["pro.starts_at",">",$dateArray["dateTimeNow"]],
                ["pro.is_deleted", 0],
                ["pro.reservation_available", 1],
                ["m.is_deleted",0],
                ["m.in_cinema",1]
            ]);
        $movies = $query
            ->groupBy("m.id", "m.name")
            ->get();
        return $movies;

    }

    public function comingSoon(){
        $cs = \DB::table("movie AS m")
            ->join("movie_picture AS mp","m.id","mp.movie_id")
            ->join("picture AS p","mp.picture_id","p.id")
            ->select("m.id AS idMovie","m.description","m.name AS movieName","m.running_time","m.in_cinemas_from","p.path","p.name AS picName","p.alt")
            ->where([
                ["m.is_deleted",0],
                ["m.in_cinema",0]
            ])
            ->get();
        foreach($cs as $m){
            $m->genres = $this->getGenres($m->idMovie);
        }

        return $cs;
    }

                                                    // ******** ADMIN **********

    public function insertMovie($name, $running_time, $desc, $detailed_desc, $distributer, $director,$country, $date, $actors, $genres, $age_limit, $cs){
            $movieId = \DB::table("movie")
                ->insertGetId([
                    "name" => $name,
                    "running_time" => $running_time,
                    "age_limit" => $age_limit,
                    "description" => $desc,
                    "description_detailed" => $detailed_desc,
                    "in_cinemas_from" => $date,
                    "director_id" => $director,
                    "country_id" => $country,
                    "distributer_id" => $distributer,
                    "in_cinema" => $cs,
                    "inserted_at" => date("Y-m-d H:i:s"),
                    "updated_at" => NULL,
                    "is_deleted" => 0
                ]);
//        dd($movieId);
        \DB::table("movie_actor")
            ->where("movie_id", $movieId)
            ->delete();
        \DB::table("movie_genre")
            ->where("movie_id", $movieId)
            ->delete();

        $this->insertMovieActors($movieId, $actors);
        $this->insertMovieGenres($movieId, $genres);

        return $movieId;
    }

    public function updateMovie($id, $name, $running_time, $desc, $detailed_desc, $distributer, $director,$country, $date, $actors, $genres, $age_limit, $cs){
        \DB::table("movie")
            ->where("id", $id)
            ->update([
                "name" => $name,
                "running_time" => $running_time,
                "age_limit" => $age_limit,
                "description" => $desc,
                "description_detailed" => $detailed_desc,
                "in_cinemas_from" => $date,
                "director_id" => $director,
                "country_id" => $country,
                "distributer_id" => $distributer,
                "in_cinema" => $cs,
                "updated_at" => date("Y-m-d H:i:s")
            ]);
        \DB::table("movie_actor")
            ->where("movie_id", $id)
            ->delete();
        \DB::table("movie_genre")
            ->where("movie_id", $id)
            ->delete();

        $this->insertMovieActors($id, $actors);
        $this->insertMovieGenres($id, $genres);
    }

    public function deleteMovie($id){
        \DB::table("movie")
            ->where("id",$id)
            ->update([
                "is_deleted" => 1
            ]);
    }

    public function insertMovieActors($movieId, $actors){
        foreach($actors as $a){
            \DB::table("movie_actor")
                ->insertGetId([
                    "id" => NULL,
                    "movie_id" => $movieId,
                    "actor_id" => $a
                ]);
        }
    }

    public function insertMovieGenres($movieId, $genres){
        foreach($genres as $g){
            \DB::table("movie_genre")
                ->insertGetId([
                    "id" => NULL,
                    "movie_id" => $movieId,
                    "genre_id" => $g
                ]);
        }
    }

    public function getMovieData($id){
        $movie = \DB::table("movie AS m")
            ->join("movie_picture AS mp", "m.id","mp.movie_id")
            ->select("m.id AS idMovie","m.description","m.description_detailed","m.name AS movieName","m.running_time","m.director_id",
                "m.distributer_id","m.country_id","m.in_cinemas_from","age_limit","in_cinema", "mp.is_active_slider")
            ->where([
                ["m.id",$id],
            ])
            ->first();
        $movie->actors = $this->getActors($movie->idMovie);
        $movie->genres = $this->getGenres($movie->idMovie);
        $movie->technologies = $this->getMovieTechnologies($movie->idMovie);
        return $movie;
    }

    public function getMovieTechnologies($idMovie){
        return \DB::table("movie AS m")
            ->join("movie_technology AS mt", "m.id", "mt.movie_id")
            ->join("technology AS t", "mt.technology_id", "t.id")
            ->select("t.id","t.name")
            ->where("m.id", $idMovie)
            ->get();
    }

    public function getMoviesAdmin($offset, $searched=0){
        $offset = $offset * $this->adminLimit;
        $query = [["m.is_deleted",0],["m.in_cinema",1]];
        if($searched){
            $query[] = ["m.name","LIKE", "%$searched%"];
        }
        $movies =  \DB::table("movie AS m")
            ->join("director AS d", "m.director_id", "d.id")
            ->join("movie_picture AS mp","m.id","mp.movie_id")
            ->join("picture AS p","mp.picture_id","p.id")
            ->select("m.id AS idMovie","m.description","m.name AS movieName","m.running_time","m.age_limit","m.description","m.in_cinemas_from","p.path","p.name AS picName","p.alt", "d.name AS dirName")
            ->where($query);
        $movies =  $movies->offset($offset)->limit($this->adminLimit)
            ->groupBy("idMovie","m.description","movieName","m.running_time","m.age_limit","m.description","m.in_cinemas_from","p.path","picName","p.alt","d.name")
            ->get();
        foreach($movies as $m){
            $m->grade = $this->getGrade($m->idMovie);
            $m->genres = $this->getGenres($m->idMovie);
            $m->actors = $this->getActors($m->idMovie);
        }
//        dd($movies);
        return $movies;
    }

    public function getAllMoviesAdmin(){
        return  \DB::table("movie AS m")
            ->where([
                ["m.is_deleted", 0],
                ["m.in_cinema", 1]
            ])
            ->get();
    }

    public function getAdminPaginationCount(){
        $prodNum = \DB::table("movie as m")
            ->where([
                ["m.is_deleted",0],
                ["m.in_cinema", 1]
            ])
            ->count();
        return ceil($prodNum / $this->adminLimit);
    }

    public function insertImage($fileName, $alt, $type, $folder){
        return \DB::table("picture")
            ->insertGetId([
                "name" => $fileName,
                "alt" => $alt,
                "type" => $type,
                "path" => $folder
            ]);
    }

    public function insertMovieImages($movieId, $imagesArray, $activeSlider){
        $queryArray = $imagesArray;
        $queryArray["id"] = NULL;
        $queryArray["is_active_slider"] = $activeSlider;
        $queryArray["movie_id"] = $movieId;
//        dd($queryArray);
        \DB::table("movie_picture")
            ->insertGetId($queryArray);
    }

    public function updateMovieImages($movieId, $imagesArray, $activeSlider){
        $queryArray = $imagesArray;
        $queryArray["is_active_slider"] = $activeSlider;
         \DB::table("movie_picture")
            ->where("movie_id", $movieId)
            ->update($queryArray);
    }

}
