<?php

namespace App\Http\Controllers\reviewer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class reviewerController extends Controller
{
    public function index(){
        return view('reviewer.dashboard');
    }
}
