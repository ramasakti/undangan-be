<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class TamuTemplateExport implements WithHeadings, WithEvents
{
    public function headings(): array
    {
        return [
            'No',
            'Nama Tamu',
            'Nomor WA',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // Set lebar kolom
                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(25);
                $sheet->getColumnDimension('C')->setWidth(17);

                // LOCK semua cell dulu
                $sheet->getStyle('A1:Z1001')
                    ->getProtection()
                    ->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);

                // UNLOCK hanya kolom A, B, C
                $sheet->getStyle('A2:C1001')
                    ->getProtection()
                    ->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);

                // Aktifkan proteksi sheet
                $sheet->getProtection()->setSheet(true);
                $sheet->getProtection()->setPassword('Ramasakti123');
            },
        ];
    }
}