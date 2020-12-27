<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\Technology;
use Illuminate\Http\Request;

class HomeController extends FrontController
{
    private $moviesModel;
    private $genreModel;
    private $technologyModel;

    public function __construct()
    {
        parent::__construct();
        $this->moviesModel = new Movie();
        $this->genreModel = new Genre();
        $this->technologyModel = new Technology();
    }

    public function home(){
        $this->data['movies'] =  $this->moviesModel->getMovies(parent::getDate());
        $this->data['genres'] = $this->genreModel->getGenres();
        $this->data['technologies'] = $this->technologyModel->getTechnologies();
        $this->data['pagination'] = $this->moviesModel->getPaginationCount(parent::getDate());
        return view("pages.home", $this->data);
    }

}
