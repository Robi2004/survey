<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Http\Requests\StoreAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Models\UserAnswer;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $answers = Answer::paginate(12); // Paginate après avoir récupéré tous les articles
        return Inertia::render('Visit', ['answers' => $answers]);
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
    public function store(StoreAnswerRequest $request)
    {
        $answer = Answer::create(array_merge($request->validated(), [
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
        $answer = Answer::where('id',$id)->get();
        return Inertia::render('Post/Post', ['answer' => $answer]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $answer = Answer::where('id',$id)->get();
        return Inertia::render('Post/EditPost', ['answer' => $answer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnswerRequest $request, $id)
    {
        if(Answer::where('id',$id)->exists()){
            $answer = Answer::find($id);
            $answer->content = $request->content;
            $answer->update();
            return redirect('/posts');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $answer = Answer::find($id);
        UserAnswer::where('id_answer',$answer->id)->delete();
        $answer->delete();
    }
}
