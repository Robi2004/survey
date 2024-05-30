<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Http\Requests\ExportUserRequest;
use App\Http\Resources\ExcelResource;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Inertia\Inertia;

class ExcelController extends Controller
{
    /**
     * Show the page for select all element the user want to export
     */
    public function index()
    {
        return Inertia::render('Admin/ExportExcel');
    }

    /**
     * Export the element selecetd by the user.
     */
    public function export(ExportUserRequest $request) 
    {
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $email = $request->input('email');
        $users = User::all();
        $users = ExcelResource::collection($users);
        return Excel::download(new UserExport($users,$firstName,$lastName,$email), 'users'.time().'.xlsx');
    }
}
