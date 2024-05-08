<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Http\Resources\SurveyResource;
use App\Models\Question;
use App\Models\User;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surveys = SurveyResource::collection(Survey::paginate(12)); // Paginate après avoir récupéré tous les articles
        return Inertia::render('Dashboard', ['surveys' => $surveys]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Survey/CreateSurvey');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSurveyRequest $request)
    {
        $survey = Survey::create(array_merge($request->validated(), [
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]));

        return redirect('/posts');   
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $survey = Survey::where('id', $id)->get(); // Paginate après avoir récupéré tous les articles
        $survey['user'] = User::where('id',$survey[0]->id_user)->get();
        $survey['question'] = Question::where('id_survey',$id)->get();
        return Inertia::render('Survey/Survey', ['survey' => $survey]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Survey $survey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSurveyRequest $request, Survey $survey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Survey $survey)
    {
        //
    }
}
