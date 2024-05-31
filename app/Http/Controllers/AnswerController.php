<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Http\Requests\StoreAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Models\Answer;
use App\Models\Survey;
use App\Models\User;
use App\Models\UserAnswer;
use Inertia\Inertia;

class AnswerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnswerRequest $request, $id)
    {
        $survey = Survey::where('id',$id)->get();
        $user = User::create(array_merge($request->validated(),[
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'city' => $request->city,
            'id_survey' => $survey[0]->id,
        ]));
        foreach($request->questions as $question){
            if($question['type'] == "Text"){
                if($question['userAnswers'] != null){
                    $answer = Answer::create([
                        'content' => $question['userAnswers'],
                        'id_question' => $question['id'],
                    ]);
                    UserAnswer::create([
                        'id_user' => $user->id,
                        'id_answer' => $answer->id,
                    ]);
                }
            }
        }

        return redirect('/questions/');     
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $answer = Answer::where('id',$id)->get();
        return Inertia::render('Admin/EditAnswer', ['answer' => $answer,]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnswerRequest $request, $id)
    {
        $request->validated();
        $answer = Answer::find($id);
        $answer->content = $request->content;
        $answer->update();

        $question = Question::where('id', $answer->id_question)->get();

        return redirect('/surveys/'.$question[0]->id_survey.'/answer');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $answer = Answer::find($id);
        $answer->delete();
    }
}
