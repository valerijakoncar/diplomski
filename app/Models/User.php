<?php

namespace App\Models;


class User
{

    public function deleteUser($id){
        \DB::table("user")
            ->where("id", $id)
            ->update([
                "is_deleted" => 1
            ]);
    }

    public function updateUser($id, $username, $password, $email, $gender, $role, $news){
        $query = ["username" => $username,
            "email" => $email,
            "gender_id" => $gender,
            "role_id" => $role,
            "send_via_mail" => $news,
            "updated_at" => date("Y-m-d H:i:s")];
        if($password){
            $query["password"] = md5($password);
        }
//        dd($query);
        return \DB::table("user")
            ->where("id",$id)
            ->update($query);
    }

    public function getUser($id){
        return \DB::table("user")
            ->where("id",$id)
            ->get();
    }

    public function getUsers(){
        return \DB::table("user AS u")
            ->join("role AS r","u.role_id", "r.id")
            ->join("user_genre AS g", "u.gender_id", "g.id")
            ->select("u.id AS idUser","u.username","u.email","u.password", "u.send_via_mail", "r.role AS roleName", "g.name AS genderName")
            ->where("u.is_deleted", 0)
            ->get();
    }

    public function changePassword($email, $newPass){
       \DB::table("user")
            ->where("email",$email)
            ->update([
                "password" => md5($newPass)
            ]);
    }

    public function getUsername($email){
        return \DB::table("user")
            ->select("username")
            ->where([
                ["email", "=", $email]
            ])
            ->first();
    }

    public function getUserByUsernamePassword($username, $password){
        return \DB::table("user")
            ->select("username", "role_id", "id", "email", "gender_id", "registered_at")
            ->where([
                ["password", "=", md5($password)],
                ["username", "=", $username],
                ["is_deleted", 0]
            ])
            ->first();
    }

    public function registerUser($username, $password, $tel, $email, $selectedGender, $sendViaMail){
        date_default_timezone_set('Europe/Belgrade');
        try{
            $insertedId = \DB::table('user')
                ->insertGetId(
                    ['id' => NULL, 'username' => $username,  'email' => $email, 'password' => md5($password),
                        'registered_at' => date('Y-m-d H:i:s'), 'role_id' => 1,'send_via_mail' => intval($sendViaMail),
                        'gender_id' => $selectedGender, 'inserted_at' => date('Y-m-d H:i:s'), 'updated_at' => NULL, 'is_deleted' => 0]
                );

            if($insertedId){
                $code = 201;
            }else{
                $code = 409;
            }
        }catch(\PDOException $ex) {
            $code = 409;
        }
        return $code;
    }
}
