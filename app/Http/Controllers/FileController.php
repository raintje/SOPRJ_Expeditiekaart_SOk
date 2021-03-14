<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|unique:posts|max:255',
            'path' => 'required',
        ]);
    }
}
