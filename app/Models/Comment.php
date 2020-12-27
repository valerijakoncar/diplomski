<?php


namespace App\Models;


class Comment
{
    private $limitComments = 5;
//    private static $offsetComments = 5;

    public function getAllComments(){
        return  \DB::table("comment AS c")
            ->join("user AS u","c.user_id","u.id")
            ->join("movie AS m", "c.movie_id","m.id")
            ->select("c.id","c.text","c.inserted_at AS posted_at","c.updated_at","u.username","u.gender_id","u.registered_at","c.user_id", "m.id AS idMovie")
            ->where([
                ["c.is_deleted", 0]
            ])
            ->orderBy("c.inserted_at","desc")
            ->get();
    }

    public function viewMoreComments($id, $offset){
        $com = \DB::table("comment AS c")
            ->join("user AS u","c.user_id","u.id")
            ->join("movie AS m", "c.movie_id","m.id")
            ->select("c.id","c.text","c.inserted_at AS posted_at","c.updated_at","u.username","u.gender_id","u.registered_at","c.user_id", "m.id AS idMovie")
            ->where([
                ["m.id",$id],
                ["c.is_deleted", 0],
                ["c.parent_id", NULL]
            ])
            ->offset($offset)
            ->limit($this->limitComments)
            ->orderBy("c.inserted_at","desc")
            ->get();

        return $com;
    }

    public function deleteComment($id){
        return \DB::table("comment")
                ->where("id",$id)
                ->update([
                    "is_deleted" => 1
                ]);

    }

    public function updateComment($modifiedCommText, $commentId, $dateTime){
        $data = [];
        $code = 200;
        try{
            $success = \DB::table("comment")
                ->where("id", $commentId)
                ->update([
                    "text" => $modifiedCommText,
                    "updated_at" => $dateTime
                ]);

            if($success){
                $code = 204;
            }
        }catch (\PDOException $ex){
            $code= 409;
           $ex->getMessage() ;
        }
        $data["code"] = $code;
        return $data;
    }

    public function getReppliesOfComment($parent_id){
        $com = \DB::table("comment AS c")
            ->join("user AS u","c.user_id","u.id")
            ->join("movie AS m", "c.movie_id","m.id")
            ->select("c.id","c.text","c.inserted_at AS posted_at","u.username","u.gender_id","u.registered_at","c.user_id","c.movie_id")
            ->where([
                ["c.parent_id",$parent_id],
                ["c.is_deleted", 0],
            ])
            ->orderBy("c.inserted_at","desc")
            ->get();
        return $com;
    }

     public function postComment($comment, $idMovie, $idUser, $dateTime, $parent_id = NULL)
     {
         $code = 200;
         $data = [];
         try {
            $idInserted = \DB::table("comment")
                ->insertGetId([
                    "id" => NULL,
                    "text" => $comment,
                    "parent_id" => $parent_id,
                    "user_id" => $idUser,
                    "movie_id" => $idMovie,
                    "inserted_at" => $dateTime,
                    "updated_at" => NULL,
                    "is_deleted" => 0
                ]);
            if($idInserted){
                $code = 201;
                $newComment = $this->getNewlyPostedComment($idInserted);
                $data["newComment"] = $newComment;
            }else{
                $code= 409;
            }
       }catch (\PDOException $ex){
             $code= 409;
             $ex->getMessage();
       }
       $data["code"] = $code;
       return $data;
     }

     public function getNewlyPostedComment($idInserted){
         return \DB::table("comment AS c")
             ->join("user AS u","c.user_id","u.id")
             ->join("movie AS m", "c.movie_id","m.id")
             ->select("c.id","c.text","c.inserted_at AS posted_at","u.username","u.gender_id","u.registered_at","c.user_id")
             ->where("c.id", $idInserted)
             ->first();
     }

}
