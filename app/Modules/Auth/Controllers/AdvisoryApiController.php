<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Advisory;

class AdvisoryApiController extends Controller
{
    public function index()
    {
        return response()->json(Advisory::latest()->get());
    }
}