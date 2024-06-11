<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\SurveyResource;
use App\Http\Resources\UserResource;
use App\Models\Answer;
use App\Models\Question;
use App\Models\UserAnswer;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->can('admin'))
        {
            $surveys = SurveyResource::collection(Survey::paginate(12));
            return Inertia::render('Admin/SurveyDashboard', ['surveys' => $surveys]);
        }else{
            $surveys = SurveyResource::collection(Survey::where('id_user',Auth::id())->paginate(12));
            return Inertia::render('Survey/SurveyDashboard', ['surveys' => $surveys]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {       
        if(Auth::user()->can('user'))
        {
            return Inertia::render('Survey/CreateSurvey');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSurveyRequest $request)
    {
        if(Auth::user()->can('user'))
        {
            if($request->hasFile('image')){
                $path = Storage::disk('public')->putFile('image', new File($request->file('image')));
            }
            $survey = Survey::create(array_merge($request->validated(),[
                'title' => $request->title,
                'image' => $path ?? null,
                'id_user' => Auth::id(),
                'locked' => false,
            ]));
            return redirect('/surveys/'.$survey->id);   
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $survey = Survey::where('id', $id)->get();
        $survey['user'] = User::where('id',$survey[0]->id_user)->get();
        if(Auth::user()->can('admin') || $survey[0]->id_user == Auth::id())
        {
            $survey['questions'] = Question::where('id_survey',$id)->get();
            foreach($survey['questions'] as $question){
            $question['answer'] = Answer::where('id_question', $question->id)->get();}
            $survey['url'] = request()->root();
            return Inertia::render('Survey/Survey', ['survey' => $survey]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $survey = Survey::where('id', $id)->get();
        if(!$survey[0]->locked){
            $survey['user'] = User::where('id',$survey[0]->id_user)->get();
            if(Auth::user()->can('admin') || $survey[0]->id_user == Auth::id())
            {
                return Inertia::render('Survey/EditSurvey', ['survey' => $survey]);
            }
        }else{
            return redirect('/surveys/'.$survey[0]->id);   
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSurveyRequest $request, $id)
    {
        $survey = Survey::find($id);
    
        if (Auth::user()->can('admin') || $survey->id_user == Auth::id()) {
            $validatedData = $request->validated();
    
            $survey->title = $validatedData['title'];
    
            if ($request->hasFile('image')) {
                $path = Storage::disk('public')->putFile('image', $request->file('image'));
    
                if ($survey->image != null) {
                    Storage::disk('public')->delete($survey->image);
                }
    
                $survey->image = $path;
            }
    
            $survey->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $survey = Survey::find($id);
        if(Auth::user()->can('admin') || $survey->id_user == Auth::id())
        {
            if($survey->image != null){
                Storage::disk('public')->delete($survey->image);
            }
            $survey->delete();
            foreach(User::where('id_survey',$id) as $user){
                $user->delete();
            }
            return response()->json(['message' => 'Le sondage a été supprimé'], 200);
        }

        return response()->json(['error' => 'Vous n\'êtes pas autoriser à supprimer cette élément'], 403);
    }

    /**
     * Show all the answer from survey
     */
    public function answer($id)
    {
        $survey = Survey::where('id', $id)->get();
        if($survey != null){

        }else{
            $survey['user'] = User::where('id',$survey[0]->id_user)->get();
            if(Auth::user()->can('admin') || $survey[0]->id_user == Auth::id())
            {
                $survey['userAnswer'] = UserResource::collection(User::with('answers')->where('id_survey', $id)->paginate(5));
                $survey['questions'] = Question::where('id_survey',$id)->get();
                if(Auth::user()->can('admin')){
                    return Inertia::render('Admin/AnswerSurvey', ['survey' => $survey]);
                }else{
                    return Inertia::render('Survey/AnswerSurvey', ['survey' => $survey]);
                }
            }
        }
    }

    /**
     * Display the survey for getting answers
     */
    public function getAnswer($id)
    {
        $survey = Survey::where('id', $id)->get();
        $survey['user'] = User::where('id',$survey[0]->id_user)->get();
        $survey['questions'] = Question::where('id_survey',$id)->get();
        foreach($survey['questions'] as $question){
            if($question->type != "Text")
                $question['answer'] = Answer::where('id_question', $question->id)->get();
        }
        return Inertia::render('Survey/GetAnswerSurvey', ['survey' => $survey]);
    }

}
