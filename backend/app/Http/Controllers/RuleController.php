<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rule;

class RuleController extends Controller
{
    public function index()
    {
        return response()->json(Rule::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $rule = Rule::create($validated);
    
        return response()->json($rule, 201);
    }
    
}
