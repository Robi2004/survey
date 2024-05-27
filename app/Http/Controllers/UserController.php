<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Jetstream;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = UserResource::collection(User::paginate(12));
        return Inertia::render('Admin/User/UserDashboard', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {       
        return Inertia::render('Admin/User/CreateUser');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        User::create(array_merge($request->validated(),[
            'firstName' => $request['firstName'],
            'lastName' => $request['lastName'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]));
        return redirect('/users');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = UserResource::collection(User::where('id', $id)->get());
        
        $surveyCount = count(Survey::where('id_user',$id)->get());
        return Inertia::render('Admin/User/User', ['user' => $user, 'surveyCount' => $surveyCount]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $survey = Survey::where('id', $id)->get();
        $survey['user'] = User::where('id',$survey[0]->id_user)->get();
        if(Auth::user()->can('admin') || $survey[0]->id_user == Auth::id())
        {
            return Inertia::render('Survey/EditSurvey', ['survey' => $survey]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSurveyRequest $request, $id)
    {
        $survey = Survey::find($id);
        if(Auth::user()->can('admin') || $survey[0]->id_user == Auth::id())
        {
        $request->validated();
        $survey->title = $request->title;
        if($request->hasFile('image')){
            $path = Storage::disk('public')->putFile('image', new File($request->file('image')));
            if($survey->image != null)
                Storage::disk('public')->delete($survey->image);
            $survey->image = $path;
        }
        $survey->update();

        return redirect('/surveys/'.$survey->id);   
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();
    }

}
