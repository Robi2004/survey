<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChartResource;
use App\Http\Resources\UserResource;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChartController extends Controller
{
    /**
     * Show the chart of all survey created by this user.
     */
    public function homepage()
    {
        if(Auth::user()->can('admin'))
        {
            $surveys = count(Survey::all());
            $users = count(User::where('password','!=',null)->get());
            $inscriptions = count(User::where('password','!=',null)->doesntHave('roles')->get());
            return Inertia::render('Admin/HomePage', ['surveys' => $surveys,'users' => $users,'inscriptions' => $inscriptions]);
        }else{
            $surveys = Survey::where('id_user',Auth::id())->get();
            for($x = 0; $x < count($surveys);$x++){
                $surveys[$x]->user = count(User::where('id_survey',$surveys[$x]->id)->get());
            }
            $surveys = ChartResource::collection($surveys);
            return Inertia::render('HomePage', ['surveys' => $surveys]);
        }
    }
}
