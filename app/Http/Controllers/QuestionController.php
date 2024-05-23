<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\SurveyResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Answer;
use App\Models\Survey;
use Inertia\Inertia;
use App\Models\UserAnswer;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $questions = QuestionResource::collection(Question::where('id_survey',$id)->paginate(12)); // Paginate après avoir récupéré tous les articles
        return Inertia::render('Question/QuestionDashboard', ['questions' => $questions, 'id_survey'=>$id]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        return Inertia::render('Question/CreateQuestion', ['id_survey'=>$id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        $question = Question::create(array_merge($request->validated(), [
            'content' => $request->content,
            'type' => $request->type,
            'id_survey' => $request->id_survey,
        ]));
        if($request->type != "Text"){
            foreach($request->answers as $answer){
                if($answer != null){
                Answer::create([
                    'content' => $answer,
                    'id_question' => $question->id,
                ]);}
            }
        }

        return redirect('/questions/'.$request->id_survey);     
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $answers = [];
        $question = Question::where('id',$id)->get();
        $survey = SurveyResource::collection(Survey::where('id',$question[0]->id_survey)->get());
        if($question[0]->type != "Text"){
            $answers = AnswerResource::collection(Answer::where('id_question',$id)->get());
        }
        $question = QuestionResource::collection($question);
        return Inertia::render('Question/Question', ['question' => $question, 'survey' => $survey, 'answers' => $answers]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $surveys = Survey::all();
        $question = Question::where('id',$id)->get();
        $question['survey'] = Survey::where('id',$question[0]->id_survey)->get();
        $question['answers'] = Answer::where('id_question',$id)->get();
        return Inertia::render('Question/EditQuestion', ['question' => $question, 'surveys' => $surveys]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, $id)
    {
        $question = Question::where('id',$id)->get();
        if($question[0]->type != "Text"){
            if(isset($request->oldAnswers)){
                foreach($request->oldAnswers as $oldAnswer){
                    $answer = Answer::where('id',$oldAnswer['id']);
                    for($x =1; $x<count($request->answers['id']);$x++){
                        if($answer->id == $request->answers['id'][$x]){
                            if($request->answers['content'][$x] != null){
                                $answer->content = $request->answers['content'][$x];
                                $request->answers['content'][$x] = null;
                                $answer->update();
                            }
                        }
                    }




                    $existAnswer = false;
                    if(isset($request->answers['id'])){
                        for($x=1;$x < count($request->answers['id']);$x++){
                            if($request->answers['id'][$x]==$answer->id){
                                $existAnswer = true;
                                $answer->content = $request->answers['content'][$x];
                                $answer->update();
                            }
                        }
                    }
                    if(!$existAnswer){
                        $answer->delete();
                    }
                }
            }
        }
        $question = Question::find($id);
        $question->type = $request->type;
        $question->content = $request->content;
        $question->update();
        return redirect('/questions/'.$question->id_survey);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $question = Question::find($id);
        $question->delete();
    }
}
