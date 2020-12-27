<?php

use App\Http\Controllers\admin\ActivityController;
use App\Http\Controllers\admin\ProjectionController as AdminProjectionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MenuLinkController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PHPMailerController;
use App\Http\Controllers\ProjectionController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", [HomeController::class, "home"]);
Route::get("/home", [HomeController::class, "home"]);
Route::get("/getSliderData", [MovieController::class, "getSliderData"]);
Route::post("/login", [UserController::class, "login"]);
Route::get("/logout", [UserController::class, "logout"]);
Route::post("/registration", [UserController::class, "registration"]);
Route::get("/page/{offset}", [MovieController::class, "getMovies"]);
Route::get("/filterMovies", [MovieController::class, "filterMovies"]);
Route::get("/movie/{id}", [MovieController::class, "getMovie"]);
Route::post("/movie/postComment",[CommentController::class, "postComment"]);
Route::post("/movie/updateComment",[CommentController::class, "updateComment"]);
Route::get("/movie/deleteComment/{id}",[CommentController::class, "deleteComment"]);
Route::get("/movie/viewMoreComments/{id}/{offset}", [CommentController::class, "viewMoreComments"]);
Route::post("/movie/postRepply", [CommentController::class, "postComment"]);
Route::get("/movie/getReppliesOfComment/{parent_id}",[CommentController::class, "getReppliesOfComment"]);
Route::get("/getMoviesDdl", [MovieController::class, "getMoviesDdl"]);
Route::get("/getProjectionsDdl", [ProjectionController::class, "getProjectionsDdl"]);
Route::get("/continueReservation", [ReservationController::class, "continueReservation"]);
Route::get("/continueReservation/{projectionId}", [ReservationController::class, "continueProjectionReservation"]);
Route::post("/makeReservation", [ReservationController::class, "makeReservation"]);
Route::post("/rateMovie", [MovieController::class, "rateMovie"]);
Route::get("/coming-soon", [MovieController::class, "comingSoon"]);
Route::get("/membership", [FrontController::class, "membership"]);
Route::post("/becomeMember", [PHPMailerController::class, "becomeMember" ]);
Route::post("/becomeMemberRequest", [MembershipController::class, "becomeMemberRequest" ]);
Route::get("/about-cinema", [FrontController::class, "aboutCinema"]);
Route::get("/website-author", [FrontController::class, "aboutAuthor"]);
Route::get("/website-admin", [FrontController::class, "websiteAdmin"]);
Route::get("/contact-cinema", [FrontController::class, "contactCinema"]);
Route::post("/forget-password", [PHPMailerController::class, "forgetPassword"]);
Route::get("/forget-password", [PHPMailerController::class, "forgetPassword"]);
Route::post("/account-access", [UserController::class, "accountAccess"]);
Route::post("/contact-cinema", [MessageController::class, "contactCinema"]);
Route::post("/contact-admin", [MessageController::class, "contactAdmin"]);

// ADMIN

Route::get("/admin", [AdminController::class, "admin"])->middleware(["IsAdminLoggedIn"]);
Route::get("/admin/moviesPage/{offset}/{searched}", [\App\Http\Controllers\admin\MovieController::class, "getMovies"])->middleware(["IsAdminLoggedIn"]);
Route::get("/getMovieData", [\App\Http\Controllers\admin\MovieController::class, "getMovieData"])->middleware(["IsAdminLoggedIn"]);
Route::post("/updateMovie", [\App\Http\Controllers\admin\MovieController::class, "updateMovie"])->middleware(["IsAdminLoggedIn"]);
Route::post("/insertMovie", [\App\Http\Controllers\admin\MovieController::class, "insertMovie"])->middleware(["IsAdminLoggedIn"]);
Route::get("/deleteMovie/{id}", [\App\Http\Controllers\admin\MovieController::class, "deleteMovie"])->middleware(["IsAdminLoggedIn"]);
Route::get("/getMovieTechnologies/{movieId}", [\App\Http\Controllers\admin\MovieController::class, "getMovieTechnologies"])->middleware(["IsAdminLoggedIn"]);
Route::post("/insertProjections", [AdminProjectionController::class, "insertProjections"])->middleware(["IsAdminLoggedIn"]);
Route::get("/getProjectionData/{id}", [AdminProjectionController::class, "getProjectionData"])->middleware(["IsAdminLoggedIn"]);
Route::get("/getProjections", [AdminProjectionController::class, "getProjections"])->middleware(["IsAdminLoggedIn"]);
Route::post("/updateProjection", [AdminProjectionController::class, "updateProjection"])->middleware(["IsAdminLoggedIn"]);
Route::get("/deleteProjection/{id}", [AdminProjectionController::class, "deleteProjection"])->middleware(["IsAdminLoggedIn"]);
Route::get("/getUser/{id}", [UserController::class, "getUser"])->middleware(["IsAdminLoggedIn"]);
Route::post("/updateUser", [UserController::class, "updateUser"])->middleware(["IsAdminLoggedIn"]);
Route::get("/getUsers", [UserController::class, "getUsers"])->middleware(["IsAdminLoggedIn"]);
Route::get("/deleteUser/{id}", [UserController::class, "deleteUser"])->middleware(["IsAdminLoggedIn"]);
Route::get("/getLinkData/{id}", [MenuLinkController::class, "getLinkData"])->middleware(["IsAdminLoggedIn"]);
Route::post("/updateLink", [MenuLinkController::class, "updateLink"])->middleware(["IsAdminLoggedIn"]);
Route::post("/insertLink", [MenuLinkController::class, "insertLink"])->middleware(["IsAdminLoggedIn"]);
Route::get("/getLinks", [MenuLinkController::class, "getLinks"])->middleware(["IsAdminLoggedIn"]);
Route::get("/deleteLink/{id}", [MenuLinkController::class, "deleteLink"])->middleware(["IsAdminLoggedIn"]);
Route::get("/deleteComment/{id}", [CommentController::class, "deleteComment"])->middleware(["IsAdminLoggedIn"]);
Route::get("/sortActivity", [ActivityController::class, "sortActivity"])->middleware(["IsAdminLoggedIn"]);
