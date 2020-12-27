<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Actor;
use App\Models\Comment;
use App\Models\Country;
use App\Models\Director;
use App\Models\Distributer;
use App\Models\Gender;
use App\Models\Genre;
use App\Models\Hall;
use App\Models\MenuModel;
use App\Models\Movie;
use App\Models\Projection;
use App\Models\Role;
use App\Models\Technology;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $menuModel;
    private $movieModel;
    private $genreModel;
    private $actorModel;
    private $distributerModel;
    private $directorModel;
    private $countryModel;
    private $hallModel;
    private $projectionModel;
    private $technologyModel;
    private $userModel;
    private $genderModel;
    private $roleModel;
    private $commentModel;
    private $activityModel;
    private $data = [];

    public function __construct()
    {
        $this->menuModel = new MenuModel();
        $this->movieModel = new Movie();
        $this->genreModel = new Genre();
        $this->actorModel = new Actor();
        $this->distributerModel = new Distributer();
        $this->directorModel = new Director();
        $this->countryModel = new Country();
        $this->hallModel = new Hall();
        $this->projectionModel = new Projection();
        $this->technologyModel = new Technology();
        $this->userModel = new User();
        $this->genderModel = new Gender();
        $this->roleModel = new Role();
        $this->commentModel = new Comment();
        $this->activityModel = new Activity();
        $this->data["menu"]  = $this->menuModel->getMenuLinksAdmin();
        $this->data["movies"] = $this->movieModel->getMoviesAdmin(0);
        $this->data["allMovies"] = $this->movieModel->getAllMoviesAdmin();
        $this->data["pages"] = $this->movieModel->getAdminPaginationCount();
        $this->data["genres"] = $this->genreModel->getGenres();
        $this->data["actors"] = $this->actorModel->getActors();
        $this->data["distributers"] = $this->distributerModel->getDistributers();
        $this->data["directors"] = $this->directorModel->getDirectors();
        $this->data["countries"] = $this->countryModel->getCountries();
        $this->data["halls"] = $this->hallModel->getHalls();
        $this->data["projections"] = $this->projectionModel->getProjections();
        $this->data["technologies"] = $this->technologyModel->getTechnologies();
        $this->data["users"] = $this->userModel->getUsers();
        $this->data["genders"] = $this->genderModel->getGenders();
        $this->data["roles"] = $this->roleModel->getRoles();
        $this->data["comments"] = $this->commentModel->getAllComments();
        $this->data["links"] = $this->menuModel->getAllLinks();
        $this->data["activities"]  =$this->activityModel->print();
    }

    public function admin(){
        return view("admin.pages.admin", $this->data);
    }
}
