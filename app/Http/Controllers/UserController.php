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
use Spatie\Permission\Models\Role;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = UserResource::collection(User::role('user')->paginate(12));
        return Inertia::render('Admin/User/UserDashboard', ['users' => $users]);
    }

    /**
     * Display a listing of the resource.
     */
    public function inscription()
    {
        $users = UserResource::collection(User::doesntHave('roles')->paginate(12));
        return Inertia::render('Admin/User/InscriptionDashboard', ['users' => $users]);
    }

    /**
     * Display a listing of the resource.
     */
    public function validate($id)
    {
        $user = User::where('id', $id)->get();
        $user[0]->assignRole('user');
        return redirect('/users/inscription');
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
        $user = User::where('id', $id)->get();
        return Inertia::render('Admin/User/EditUser', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $request->validated();
        $user = User::find($id);
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->update();

        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();
    }

}
