<?php

namespace App\Http\Controllers;

use App\Models\Advisory;
use Illuminate\Http\Request;

class AdvisoryController extends Controller
{
    public function index()
    {
        $advisories = Advisory::with("creator")->latest()->paginate(10);

        return view("advisories.index", [
            "advisories" => $advisories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => ["required", "string", "max:150"],
            "message" => ["required", "string", "max:2000"],
            "category" => ["required", "in:general,weather,outbreak,tip"],
        ]);

        Advisory::create([
            ...$validated,
            "created_by" => $request->user()->id,
        ]);

        return back()->with("status", "Advisory posted successfully.");
    }

    public function destroy(Advisory $advisory)
    {
        $advisory->delete();

        return back()->with("status", "Advisory deleted.");
    }
}