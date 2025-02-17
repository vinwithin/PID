<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class MonevController extends Controller
{
    public function index(){
        return view('monitoring-evaluasi.index', [
            'data' => Registration::with(['bidang', 'fakultas', 'program_studi', 'reviewAssignments', 'registration_validation', 'proposal_score'])->
            whereHas('registration_validation', function ($query) {
                $query->where('status', 'lolos');
            })->get(),

        ]);
    }
}
