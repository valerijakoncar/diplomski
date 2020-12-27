<?php


namespace App\Models;


class Projection
{

    public function  deleteProjection($id){
        return \DB::table("projection")
            ->where("id", $id)
            ->update([
                "is_deleted" => 1
            ]);

    }

    public function getProjections($searched = 0){
        $where = [["p.is_deleted", 0]];
        if($searched){
            $searched = "%$searched%";
            $where[] = ["m.name", "LIKE", $searched];
        }
        return \DB::table("projection AS p")
            ->join("movie AS m", "p.movie_id", "m.id")
            ->join("movie_technology AS mt", "mt.movie_id", "m.id")
            ->join("technology AS t", "mt.technology_id", "t.id")
            ->join("hall AS h", "p.hall_id", "h.id")
            ->where($where)
            ->select("m.name", "p.*", "t.name AS technName", "h.name AS hallName")
            ->orderBy("m.name","ASC")
            ->orderBy("p.starts_at","ASC")
            ->get();
    }

    public function updateProjection($idProjection, $movie, $dateTimeProj, $hall, $technology, $reservation){
        return \DB::table("projection")
            ->where("id", $idProjection)
            ->update([
                "movie_id" => $movie,
                "starts_at" => $dateTimeProj,
                "hall_id" => $hall,
                "movie_technology_id" => $technology,
                "reservation_available" => $reservation
            ]);
    }

    public function insertProjections($projectionMovie, $dateTimeProj, $projectionHall, $projectionTechnology, $projectionResAvailable){
        return \DB::table("projection")
            ->insertGetId([
                "id" => NULL,
                "movie_id" => $projectionMovie,
                "starts_at" => $dateTimeProj,
                "hall_id" => $projectionHall,
                "movie_technology_id" => $projectionTechnology,
                "reservation_available" => $projectionResAvailable,
                "is_deleted" => 0
            ]);
    }

    public function projectionAvailable($projectionHall, $dateArray, $idProjection = 0){
        $query = [ ["p.hall_id", $projectionHall], ["p.starts_at", ">", $dateArray["minus1Day"]],["p.starts_at", "<",$dateArray["plus1Day"]],["p.is_deleted", 0]];
        if($idProjection){
            $query[] = ["p.id", "<>", $idProjection];
        }

        return \DB::table("projection AS p")
            ->join("movie AS m", "p.movie_id", "m.id")
            ->select(\DB::raw("(p.starts_at + INTERVAL m.running_time MINUTE + INTERVAL 30 MINUTE) as hallFreeAt, p.starts_at, m.running_time"))
            ->where($query)
            ->get();
    }

    public function getProjectionsDdl($dateArray, $movieId){
        $whereArray = [];
        array_push($whereArray, ["pr.movie_id",$movieId],["pr.starts_at","<",$dateArray["plus1Day"]],
            ["pr.starts_at",">",$dateArray["minus1Day"]],["pr.reservation_available",">",0],["pr.starts_at", ">", $dateArray["dateTimeNow"]],
            ["pr.is_deleted", 0]);

        $projections = \DB::table("projection AS pr")
            ->join("movie_technology AS mt","pr.movie_technology_id", "mt.id")
            ->join("technology AS t","mt.technology_id","t.id")
            ->where($whereArray)
            ->select("pr.id","pr.starts_at","t.name AS technologyName")
            ->orderBy("pr.starts_at")
            ->get();

        return $projections;
    }

    public function getProjection($projectionId){//$movieId,
        return \DB::table("projection as p")
            ->join("movie as m","p.movie_id","m.id")
            ->join("hall as h","p.hall_id","h.id")
            ->join("movie_technology as mt", "p.movie_technology_id","mt.id")
            ->join("technology as t","mt.technology_id","t.id")
            ->select("m.id as idMovie","m.name as movieName","p.id as idProjection","p.starts_at","t.name as technName","t.id as idTechnology",
                "h.name as hallName", "h.id as idHall","p.reservation_available")
            ->where([
                ["p.id",$projectionId],
//                ["m.id", $movieId]
            ])
            ->first();
    }

}
