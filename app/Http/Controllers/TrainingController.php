<?php

namespace App\Http\Controllers;

use App\Models\Training;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::where('status', 'open')->get();
        return view('pelatihan', compact('trainings'));
    }
}
