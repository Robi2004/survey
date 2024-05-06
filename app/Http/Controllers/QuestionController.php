<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Answer;
use Inertia\Inertia;
use App\Models\UserAnswer;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $question = Question::paginate(12); // Paginate après avoir récupéré tous les articles
        return Inertia::render('Visit', ['question' => $question]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Post/CreatePost');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        $question = Question::create(array_merge($request->validated(), [
            'content' => $request->content,
            'id_survey' => $request->id_survey,
        ]));

        return redirect('/posts');     
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $question = Question::where('id',$id)->get();
        return Inertia::render('Post/Post', ['question' => $question]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $question = Question::where('id',$id)->get();
        return Inertia::render('Post/EditPost', ['answer' => $question]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, $id)
    {
        if(Question::where('id',$id)->exists()){
            $question = Question::find($id);
            $question->content = $request->answer;
            $question->update();
            return redirect('/posts');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $question = Question::find($id);
        $answers = Answer::where('id_question',$question->id)->delete();
        foreach($answers as $answer){
            UserAnswer::where('id_answer',$answer->id)->delete();
        }
        $answer->delete();
        $question->delete();
    }
}
