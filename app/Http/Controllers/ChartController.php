<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChartResource;
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
        $surveys = Survey::where('id_user',Auth::id())->get();
        for($x = 0; $x < count($surveys);$x++){
            $surveys[$x]->user = count(User::where('id_survey',$surveys[$x]->id)->get());
        }
        $surveys = ChartResource::collection($surveys);
        return Inertia::render('HomePage', ['surveys' => $surveys]);
    }
}
