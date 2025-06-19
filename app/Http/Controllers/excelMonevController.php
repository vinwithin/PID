<?php

namespace App\Http\Controllers;

use App\Exports\nilaiMonevExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class excelMonevController extends Controller
{
    public function export(){
         return Excel::download(new nilaiMonevExport(), 'nilai-monev.xlsx');
    }   
}
