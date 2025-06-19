<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class nilaiMonevPerTeam implements FromView
{
    protected $data;
    protected $title;
    protected $rubrik;
    protected $nilai;

   public function __construct($data, $rubrik, $nilai, $title)
    {
        $this->data = $data;
        $this->rubrik = $rubrik;
        $this->nilai = $nilai;
        $this->title = $title;
    }

    public function view(): View
    {
        // dd($this->nilai);
        return view('excel.nilai-monev', [
            'data' => $this->data,
            'dataNilai' => $this->rubrik,
            'nilai' => $this->nilai
        ]);
    }

    public function title(): string
    {
        return $this->title;
    }
}
