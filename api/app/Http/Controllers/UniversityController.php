<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    //
    public function view(){
        $universities = University::select('id', 'pt_code', 'name')->get();

        return response()->json(compact('universities'),201);

    }
}
