<?php

namespace App\Http\Controllers;

use App\Models\FileCategory;
use Illuminate\Http\Request;

class FileCategoryController extends Controller
{
    //
    public function view(){
        $file_categories = FileCategory::select('id', 'name', 'image_url')->get();

        return response()->json(compact('file_categories'),201);
    }
}
