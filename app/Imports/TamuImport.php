<?php

namespace App\Imports;

use App\Models\TamuModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class TamuImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new TamuModel([
            'kode_tamu' => $row['kode_tamu'] ?? Str::random(6),
            'nama_tamu' => $row['nama_tamu'],
            'no_wa' => $row['no_wa'],
            'uploaded_by' => Auth::user()->id
        ]);
    }
}