<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PacientesController extends Controller
{
    public function getViewPacientes(){
        return Inertia::render('Pacientes');
    }
}
