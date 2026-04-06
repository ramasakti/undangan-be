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
        if (empty(trim($row['nama_tamu'] ?? ''))) return null;

        return new TamuModel([
            'kode_tamu'   => Str::random(6),
            'nama_tamu'   => trim($row['nama_tamu']),
            'no_wa'       => trim($row['nomor_wa'] ?? ''),
            'uploaded_by' => Auth::id()
        ]);
    }
}