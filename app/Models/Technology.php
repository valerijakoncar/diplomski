<?php


namespace App\Models;


class Technology
{

    public function deleteTechnologyMovie($id){
        \DB::table("movie_technology")
            ->where("movie_id", $id)
            ->delete();
    }

    public function insertTechnologyMovie($technology, $movieId){
        \DB::table("movie_technology")
            ->insertGetId([
                "id" => NULL,
                "movie_id" => $movieId,
                "technology_id" => $technology
            ]);
    }

    public function getMovieTechnologiesProjection($id){
        return  \DB::table("movie_technology AS mt")
            ->join("technology AS t", "mt.technology_id", "t.id")
            ->join("projection AS p", "mt.movie_id", "p.movie_id")
            ->select("mt.id", "t.name")
            ->where("p.id",$id)
            ->get();

    }

    public function getMovieTechnologies($movieId){
        return \DB::table("movie_technology AS mt")
            ->join("technology AS t", "mt.technology_id", "t.id")
            ->select("mt.id", "t.name")
            ->where("movie_id",$movieId)
            ->get();
    }

    public function getTechnologies(){
        return \DB::table("technology")
            ->get();
    }
}
