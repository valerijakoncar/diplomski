<?php

namespace App\Http\Controllers;

use App\Http\Requests\MembershipRequest;
use App\Models\User;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;

class PHPMailerController extends FrontController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function becomeMember(MembershipRequest $request){
        $email  = $request->input("memEmail");
        $firstname = $request->input("memName");
        $lastname = $request->input("memLastname");
        $userId = $request->input("membershipHidden");
        if(!$userId){
            $userId = 0;
        }
        $userMembershipInfo = ["email" => $email, "firstname" => $firstname, "lastname" => $lastname, "userId" => $userId];
        $request->session()->put("userMembershipInfo", $userMembershipInfo);

        try{
            $mail = $this->getMailer($email);
            $randomCode = $this->getRandomString();
            $request->session()->put("randomCode", $randomCode);
            $mail->isHTML(true); 																	// Set email format to HTML
            $mail->Subject = 'MovieBlackout-Become member';
            $mail->Body    = 'Your verification code is: '. $randomCode;			// message

            $mail->send();
            $request->session()->put("successSentEmailMembership", "Confirmation mail was sent to your email address.");
            return view("pages.membership", $this->data);
        }catch (Exception $e) {
            $request->session()->put("errorSentEmailMembership", "There was an error. Email could not be sent.");
            return back();
        }
    }

    public function forgetPassword(Request $request){
        $email = $request->input("forgetPassEmail");

        $request->session()->put("email", $email);
        $userModel = new User();
        $username = $userModel->getUsername($email);
        $request->session()->put("username", $username);
        try{
            $mail = $this->getMailer($email);
            $randomCode = $this->getRandomString();
            $request->session()->put("randomCode", $randomCode);
            $mail->isHTML(true); 																	// Set email format to HTML
            $mail->Subject = 'MovieBlackout-Password change';
            $mail->Body    = 'Your verification code is: '. $randomCode;			// message

            $mail->send();
            $request->session()->put("successForgetPass", "Success.");
            return view("pages.regain_account_access", $this->data);
        }catch (Exception $e) {
            $request->session()->put("errorForgetPass", "Error.");
            return back();
        }

    }

    public function getMailer($email){
        // load Composer's autoloader
        $mail = new PHPMailer(true);                            // Passing `true` enables exceptions

            // Server settings
            $mail->SMTPDebug = 0;                                    // Enable verbose debug output
            $mail->isSMTP();                                        // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                                                // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                // Enable SMTP authentication
            $mail->Username = 'valerija.movieblackout@gmail.com';             // SMTP username
            $mail->Password = 'movie.blackout98';              // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('valerija.movieblackout@gmail.com', 'MovieBlackout');
            $mail->addAddress($email, 'Optional name');    // Add a recipient, Name is optional
            $mail->addReplyTo('valerija.movieblackout@gmail.com', 'Mailer');
            $mail->addCC($email);
            $mail->addBCC($email);
            return $mail;
    }

    public function getRandomString(){
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomCode = substr(str_shuffle(str_repeat($pool, 5)), 0, 10);
        return $randomCode;
    }
}
