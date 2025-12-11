<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DistributorDealerExport implements FromCollection, WithHeadings, WithMapping, WithStyles

{
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
        // return only specific columns you want to export
            // return $this->data->map(function ($item) {
            //     return [
            //         'Sales Person'          => $item->sales_person->first_name ?? ''.' '.$item->sales_person->last_name ?? '',
            //         'Code No'               => $item->code_no,
            //         'Name of the Applicant' => $item->applicant_name,
            //         'Firm Name'             => $item->firm_shop_name,
            //         'Firm Address'          => $item->firm_shop_address,
            //         'Mobile'                => $item->mobile_no,
            //         'Pan Card'              => $item->pancard,
            //         'Aadhar Card'           => $item->aadhar_card,
            //         'Created Date'          => $item->created_at->format('Y-m-d'),
            //     ];
        // });
    }

    public function headings(): array
    {
        return [
            'Sales Person',
            'Code No',
            'Name of the Applicant',
            'Firm Name',
            'Firm Address',
            'Mobile',
            'Pan Card',
            'Aadhar Card',
            'Created Date',
        ];
    }
    public function map($row): array
    {
        return [
            $row->sales_person->first_name ?? '' . ' ' . $row->sales_person->last_name ?? '',
            $row->code_no,
            $row->applicant_name,
            $row->firm_shop_name,
            $row->firm_shop_address,
            " " . $row->mobile_no,
            " " . $row->pancard,
            " " . $row->aadhar_card,
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
            ], // Row 1 (headings) bold
        ];
    }


  



}
