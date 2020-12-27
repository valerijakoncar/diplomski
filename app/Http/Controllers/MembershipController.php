<?php

namespace App\Http\Controllers;

use App\Http\Requests\MembershipRequest;
use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    private $membershipModel;

    public function __construct()
    {
        $this->membershipModel = new Membership();
    }

    public function becomeMemberRequest(Request $request){
        $memberName = $request->input("memReqName");
        $memberLastname = $request->input("memReqLastname");
        $memberEmail = $request->session()->get("userMembershipInfo")["email"];
        $userId = $request->input("memReqUserId");
        $member = $this->membershipModel->getMember($memberEmail);
        $request->session()->forget("userMembershipInfo");
        if($request->session()->has("successSentEmailMembership")){
            $request->session()->forget("successSentEmailMembership");
        }
        if($request->session()->has("successSentEmailMembership")){
            $request->session()->forget("errorSentEmailMembership");
        }

        if($member){
            return redirect("/membership")->with("error", "Member with same email already exists.");
        }else{
            $code = $this->membershipModel->becomeMember($memberName, $memberLastname, $memberEmail, $userId);
            if($code === 201){
                return redirect("/membership")->with("success", "Your request was successfully sent.");
            }else{
                return redirect("/membership")->with("error", "There was an error. Try again later.");
            }
        }

    }
}
