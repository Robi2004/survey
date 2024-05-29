<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Http\Requests\ExportSurveyRequest;
use App\Http\Resources\SurveyResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Inertia\Inertia;

class PDFController extends Controller
{
    /**
     * Show the page for select all element the user want to export
     */
    public function index()
    {
        return Inertia::render('Admin/ExportPDF');
    }

    /**
     * Export the element selecetd by the user.
     */
    public function export(ExportSurveyRequest $request)
    {
        $surveys = SurveyResource::collection(Survey::all());

        $pdf = PDF::loadView('pdf/pdf', ['data' => $surveys, 'title'=> $request->title,'image'=>$request->image]);
        return $pdf->stream('Posts.pdf');
    }
}
