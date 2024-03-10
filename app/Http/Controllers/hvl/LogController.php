<?php

namespace App\Http\Controllers\hvl;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class LeadMasterController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:Access logs', ['only' => ['show', 'index']]);
        $this->middleware('permission:Create logs', ['only' => ['create']]);
        $this->middleware('permission:Read logs', ['only' => ['read']]);
        $this->middleware('permission:Edit logs', ['only' => ['edit']]);
        $this->middleware('permission:Delete logs', ['only' => ['delete']]);
    }

    public function index()
    {

    }
}
