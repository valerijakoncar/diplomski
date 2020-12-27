<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\MenuModel;
use Illuminate\Http\Request;

class MenuLinkController extends Controller
{
    private $menuModel;
    private $activityModel;

    public function __construct(){
        $this->menuModel = new MenuModel();
        $this->activityModel = new Activity();
    }

    public function deleteLink($id){
        $this->menuModel->deleteLink($id);
        $text = $_SERVER['REMOTE_ADDR'] . "\t" . session('user')->username . " deleted comment with id: ". $id . "\t";
        $userId = session()->get('user')->id;
        $this->activityModel->write($text, date("Y.m.d H:i:s"), $userId);
        return back();
    }

    public function getLinks(){
        $links = $this->menuModel->getAllLinks();
        return response()->json(["links" => $links], 200);
    }

    public function insertLink(Request $request){
        $text = $request->input("text");
        $path = $request->input("path");
        $parent = $request->input("parent");
        $header = $request->input("header");
        $footer = $request->input("footer");
        $admin = $request->input("admin");
        if($parent == 0){
            $parent = NULL;
        }
        try{
            $id = $this->menuModel->insertLink($text,$path, $parent, $header, $footer, $admin);
            $text = $_SERVER['REMOTE_ADDR'] . "\t" . session('user')->username . " inserted link with id: ". $id . "\t";
            $userId = session()->get('user')->id;
            $this->activityModel->write($text, date("Y.m.d H:i:s"), $userId);
            $links = $this->menuModel->getAllLinks();
            return response()->json(["links" => $links], 201);
        }catch(\PDOException $ex){
//            dd($ex->getMessage());
            return response()->json("", 500);
        }
    }

    public function updateLink(Request $request){
        $id = $request->input("id");
        $text = $request->input("text");
        $path = $request->input("path");
        $parent = $request->input("parent");
        $header = $request->input("header");
        $footer = $request->input("footer");
        $admin = $request->input("admin");
        if($parent == 0){
            $parent = NULL;
        }
       try{
           $this->menuModel->updateLink($id, $text,$path, $parent, $header, $footer, $admin);
           $text = $_SERVER['REMOTE_ADDR'] . "\t" . session('user')->username . " updated link with id: ". $id . "\t";
           $userId = session()->get('user')->id;
           $this->activityModel->write($text, date("Y.m.d H:i:s"), $userId);
           return response()->json("", 204);
       }catch(\PDOException $ex){
           dd($ex->getMessage());
           return response()->json("", 500);
       }
    }

    public function getLinkData($id){
        $link = $this->menuModel->getLinkData($id);
        return response()->json(["link" => $link], 200);
    }
}
