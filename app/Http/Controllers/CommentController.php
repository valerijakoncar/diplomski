<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private $commentModel;
    private $activityModel;

    public function __construct()
    {
        $this->commentModel = new Comment();
        $this->activityModel = new Activity();
    }

    public function getReppliesOfComment($parent_id){
        $comments = $this->commentModel->getReppliesOfComment($parent_id);
        $loggedUserId = 0;
        if(session()->has('user')) {
            $loggedUserId = session()->get('user')->id;
        }
        return response()->json(["repplies" => $comments, "loggedUserId" => $loggedUserId], 200);
    }

    public function viewMoreComments($id, $offset){
        $comments = $this->commentModel->viewMoreComments($id, $offset);
        $loggedUserId = 0;
        if(session()->has('user')) {
            $loggedUserId = session()->get('user')->id;
        }
        return response()->json(["comments" => $comments, "loggedUserId" => $loggedUserId], 200);
    }

    public function deleteComment($id){
        if(session()->get("user")->role_id == 2){
            $text = $_SERVER['REMOTE_ADDR'] . "\t" . session('user')->username . " deleted comment with id: ". $id . "\t";
            $userId = session()->get('user')->id;
            $this->activityModel->write($text, date("Y.m.d H:i:s"), $userId);
        }
       try{
           $this->commentModel->deleteComment($id);
           return response()->json("", 204);
       }catch(\PDOException $ex){
           return response()->json("", 500);
       }

    }

    public function updateComment(Request $request){
        $modifiedCommText = $request->input('newComment');
        $commentId =  $request->input('commentId');
        $dateTime = $this->getDateTime();
        $data = $this->commentModel->updateComment($modifiedCommText, $commentId, $dateTime);
        $code = $data["code"];
        return response()->json("", $code);
    }

//    public function getComments(Request $request){
//        $idMovie = $request->input('idMovie');
//        $comments = $this->commentModel->getComments($idMovie);
//
//        $loggedUserId = $request->session()->get('user')->id;
//        return response()->json(["comments" => $comments, "loggedUserId" => $loggedUserId], 200);
//    }

    public function postComment(Request $request){
        $comment = $request->input("comment");
        $idMovie =  $request->input("idMovie");
        $idUser = $request->session()->get('user')->id;
        $dateTime = $this->getDateTime();
        if($request->has("parent_id")){
            $parent_id = $request->input("parent_id");
            $data = $this->commentModel->postComment($comment, $idMovie, $idUser, $dateTime, $parent_id);
        }else{
            $data = $this->commentModel->postComment($comment, $idMovie, $idUser, $dateTime);
        }
        $code = $data["code"];
        $loggedUserId = $request->session()->get('user')->id;
        $comment = $data["newComment"];
        return response()->json(["newComment" => $comment, "loggedUserId" => $loggedUserId], $code);
    }


    public function getDateTime(){
        date_default_timezone_set('Europe/Belgrade');

        return date("Y-m-d H:i:s");
    }
}
