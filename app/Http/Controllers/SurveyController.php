<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Http\Resources\SurveyResource;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use App\Models\UserAnswer;
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
        if($request->hasFile('image')){
            $path = Storage::disk('public')->putFile('image', new File($request->file('image')));
        }
        $survey = Survey::create([
            'title' => $request->title,
            'image' => $path ?? null,
            'id_user' => Auth::id(),
        ]);
        for($i=1; $i < count($request->contentQuestion);$i++) {
            $question = Question::create([
                'content' => $request->contentQuestion[$i],
                'type' => $request->type[$i],
                'id_survey' => $survey->id,
            ]);
            if(isset($request->contentAnswer[0][$i]))
            for($x=1;$x < count($request->contentAnswer[0][$i]);$x++){
                $answers = Answer::create([
                    'content' => $request->contentAnswer[0][$i][$x],
                    'id_question' => $question->id,
                ]);
            }
        }
        return redirect('/surveys/'.$survey->id);   
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $survey = Survey::where('id', $id)->get();
        $survey['user'] = User::where('id',$survey[0]->id_user)->get();
        $survey['questions'] = Question::where('id_survey',$id)->get();
        foreach($survey['questions'] as $question){
            $question['answer'] = Answer::where('id_question', $question->id)->get();}
        return Inertia::render('Survey/Survey', ['survey' => $survey]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $survey = Survey::where('id', $id)->get();
        $survey['user'] = User::where('id',$survey[0]->id_user)->get();
        $survey['questions'] = Question::where('id_survey',$id)->get();
        foreach($survey['questions'] as $question){
            $question['answer'] = Answer::where('id_question', $question->id)->get();}
        return Inertia::render('Survey/EditSurvey', ['survey' => $survey]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSurveyRequest $request, $id)
    {
        $survey = Survey::find($id);
        $questions = Question::where('id_survey',$id)->get();
        if($request->hasFile('image')){
            $path = Storage::disk('public')->putFile('image', new File($request->file('image')));
            if($survey->image != null)
                Storage::disk('public')->delete($survey->image);
            $survey->image = $path;
        }
        for($i=1; $i < count($request->contentQuestion);$i++) {
            $question = Question::create([
                'content' => $request->contentQuestion[$i], 
                'type' => $request->type[$i],
                'id_survey' => $survey->id,
            ]);
            if(isset($request->contentAnswer[0][$i]))
            for($x=1;$x < count($request->contentAnswer[0][$i]);$x++){
                $answers = Answer::create([
                    'content' => $request->contentAnswer[0][$i][$x],
                    'id_question' => $question->id,
                ]);
            }
        }
        $survey->update();
        return redirect('/surveys/'.$survey->id);   
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $survey = Survey::find($id);
        if($survey->image != null){
            Storage::disk('public')->delete($survey->image);
        }
        $survey->delete();
    }
}
