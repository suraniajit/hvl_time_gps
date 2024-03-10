<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\hvi\Leader;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Support\Facades\View;
use Validator;
use Illuminate\Validation\Rule;

class LearderController extends Controller
{
    public function leadview(Request $request)
    {
        return "connected to function";
        return view('hvl/show');
    }
}
