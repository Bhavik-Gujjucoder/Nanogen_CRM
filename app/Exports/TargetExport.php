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
            'Quarter 1',
            'Quarter 2',
            'Quarter 3',
            'Quarter 4',
            'Region',
            'Created Date',
        ];
    }

    public function map($row): array
    {
        $quarter_1 = $row->target_quarterly->where('quarterly', 1)->pluck('quarterly_target_value')->first() ?? 0;
        $quarter_2 = $row->target_quarterly->where('quarterly', 2)->pluck('quarterly_target_value')->first() ?? 0;
        $quarter_3 = $row->target_quarterly->where('quarterly', 3)->pluck('quarterly_target_value')->first() ?? 0;
        $quarter_4 = $row->target_quarterly->where('quarterly', 4)->pluck('quarterly_target_value')->first() ?? 0;

        return [
            $row->subject ?? '',
            trim(
                ($row->sales_person_detail?->first_name ?? '') . ' ' .
                    ($row->sales_person_detail?->last_name ?? '')
            ),
            $row->target_value  ? '₹' . number_format($row->target_value, 0) : '-',
            $quarter_1 ? '₹' . number_format($quarter_1, 0) : '-',
            $quarter_2 ? '₹' . number_format($quarter_2, 0) : '-',
            $quarter_3 ? '₹' . number_format($quarter_3, 0) : '-',
            $quarter_4 ? '₹' . number_format($quarter_4, 0) : '-',
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
