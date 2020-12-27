<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends FrontController
{
    private $userModel;
    private $activityModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->activityModel = new Activity();
    }

    public function deleteUser($id){
        $this->userModel->deleteUser($id);
        $text = $_SERVER['REMOTE_ADDR'] . "\t" . session('user')->username . " deleted user with id: ". $id . "\t";
        $userId = session()->get('user')->id;
        $this->activityModel->write($text, date("Y.m.d H:i:s"), $userId);
        return back();
    }

    public function getUsers(){
        $users = $this->userModel->getUsers();
        return response()->json(["users" => $users], 200);
    }

    public function updateUser(Request $request){
//        dd($request);
        $id = $request->input("id");
        $username = $request->input("username");
        $password = $request->input("password");
        $email = $request->input("email");
        $gender = $request->input("gender");
        $role = $request->input("role");
        $news = $request->input("news");
        try{
            $this->userModel->updateUser($id, $username, $password, $email, $gender, $role, $news);
            $text = $_SERVER['REMOTE_ADDR'] . "\t" . session('user')->username . " updated user with id: ". $id . "\t";
            $userId = session()->get('user')->id;
            $this->activityModel->write($text, date("Y.m.d H:i:s"), $userId);
            return response()->json("", 200);
        }catch(\PDOException $ex){
//            dd($ex->getMessage());
            return response()->json("", 500);
        }
    }

    public function getUser($id){
        $user = $this->userModel->getUser($id);
        return response()->json(["user" => $user], 200);
    }

    public function accountAccess(Request $request){
        $code = $request->session()->get("randomCode");
        $userCode = $request->input("accountAccessCode");
        $newPass = $request->input("accountAccessPass");
        $email = $request->session()->get('email');

        if($code === $userCode){
            try{
                $this->userModel->changePassword($email, $newPass);
                $this->data['successfullyChangedPass'] = "Your password was changed successfully.";
                return view("pages.regain_account_access", $this->data);
            }catch(\PDOException $ex){
                return redirect()->back()->with("error", "There was an error.");
            }
        }
    }

    public function login(LoginRequest $request){
        $username = $request->input("logUsername");
        $password = $request->input("logPass");

        $user = $this->userModel->getUserByUsernamePassword($username, $password);

        if($user){
            $request->session()->put("user", $user);
            if($user->role_id === 1){
                return \redirect("/home");
            }else if($user->role_id === 2){
                return \redirect("/admin");
            }

        }else{
            return redirect("/home")->with("message", "You are not registered.");
        }
    }
    public function logout(Request $request){
        $request->session()->forget("user");
        return redirect("/home");
    }

    public function registration(RegistrationRequest $request){
        $username = $request->input("username");
        $password = $request->input("pass");
        $tel = $request->input("tel");
        $email = $request->input("email");
        $selectedGender = $request->input("selectedGender");
        $sendViaMail = $request->input("sendViaMail");
        // dd($request);
        $code = $this->userModel->registerUser($username, $password, $tel, $email, $selectedGender, $sendViaMail);

        return response()->json('', $code);
    }
}
