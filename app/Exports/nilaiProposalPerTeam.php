<?php

namespace App\Exports;

use App\Models\Registration;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class nilaiProposalPerTeam implements FromView
{

    protected $data;
    protected $title;
    protected $rubrik;

   public function __construct($data, $rubrik, $title)
    {
        $this->data = $data;
        $this->rubrik = $rubrik;
        $this->title = $title;
    }

    public function view(): View
    {
        // dd($this->rubrik);
        return view('excel.nilai-proposal', [
            'data' => $this->data,
            'dataNilai' => $this->rubrik
        ]);
    }

    public function title(): string
    {
        return $this->title;
    }
}
