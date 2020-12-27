<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function sortActivity(Request $request){
        $am = new Activity();
        $act = $am->sortActivity($request->input("sort"));
        return response()->json(["activities" => $act], 200);
    }

}
