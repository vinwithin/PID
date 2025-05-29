<?php

namespace App\Http\Controllers;

use App\Exports\nilaiProposalExport;
use App\Exports\nilaiProposalPerTeam;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class excelController extends Controller
{
    public function export(){
         return Excel::download(new nilaiProposalExport(), 'nilai-proposal.xlsx');
    }   
}
