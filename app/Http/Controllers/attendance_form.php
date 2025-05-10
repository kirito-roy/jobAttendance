<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class attendance_form extends Controller
{
    function create()
    {
        return view('attendance_form');
    }
    function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'status' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        // Process the attendance data (e.g., save to database)
        // For demonstration, we'll just return the data as a response
        return view("/");
    }
    function show()
    {
        return view('attendance_form');
    }
    function edit()
    {
        return view('attendance_form');
    }
    function update()
    {
        return view('attendance_form');
    }
}
