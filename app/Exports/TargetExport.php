<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class TargetExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Target Name',
            'Sales Person',
            'Target Value',
            'Region',
            'Date',
        ];
    }

    public function map($row): array
    {
        return [
            $row->subject ?? '',
            trim(
                ($row->sales_person_detail?->first_name ?? '') . ' ' .
                    ($row->sales_person_detail?->last_name ?? '')
            ),
            $row->target_value  ?? '0',
            $row->city->city_name ?? '',
            $row->created_at->format('d M Y'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'C6EFCE'], // Light Green
                ],
            ],
        ];
    }
}
