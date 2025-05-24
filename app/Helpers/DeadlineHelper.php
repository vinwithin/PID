<?php

use App\Models\Deadline;
use Carbon\Carbon;

if (!function_exists('isDeadlineActive')) {
    function isDeadlineActive($namaDokumen) {
        $deadline = Deadline::where('nama_dokumen', $namaDokumen)->first();
        $today = Carbon::today();

        if (!$deadline) return true;

        return $today >= $deadline->dibuka && $today <= $deadline->ditutup;
    }
}

