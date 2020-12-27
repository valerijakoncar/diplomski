<?php

namespace App\Http\Controllers;

use App\Models\AboutCinema;
use App\Models\Author;
use App\Models\MenuModel;
use App\Models\Movie;
use App\Models\PageSectionModel;
use App\Models\Price;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    protected $data = [];
    protected $menuModel;
    protected $pageSecModel;
    private $moviesModel;
    private $pricesModel;

   public function __construct()
   {
        $this->menuModel = new MenuModel();
        $this->pageSecModel = new PageSectionModel();
        $this->moviesModel = new Movie();
        $this->pricesModel = new Price();

        $this->data['menuLinks'] = $this->menuModel->getMenuLinks();
        $dateArray = $this->getDate();
        $this->data['moviesResDdl'] = $this->moviesModel->getMoviesDdl($dateArray);
        $this->data['footerHeadlines'] = $this->pageSecModel->getPageSection('footer_headline');
        $this->data['socials'] = $this->pageSecModel->getPageSection('social_network');
        $this->data['prices'] = $this->pricesModel->getPrices();
   }

   public function membership(){
       return view("pages.membership", $this->data);
   }

   public function aboutCinema(){
       $aboutCinemaModel = new AboutCinema();
       $text = $aboutCinemaModel->getAboutCinemaText()->text;
       $this->data['text'] = $text;
       return view("pages.about_cinema", $this->data);
   }

   public function aboutAuthor(){
       $authorModel = new Author();
       $text = $authorModel->getAuthorInfo()->text;
       $this->data['author'] = $text;
       return view("pages.about_author", $this->data);
   }

   public function websiteAdmin(){
       return view("pages.contact_admin", $this->data);
   }

    public function contactCinema(){
        return view("pages.contact_cinema", $this->data);
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
            $todayDate = date("Y-m-d", strtotime("2020-12-26"));
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
