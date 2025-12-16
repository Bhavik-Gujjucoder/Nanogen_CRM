<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;



class AreaWiseSalesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
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
            'Order No',
            'Name',
            'Firm Name',
            'Sales Person',
            'Product',
            'Quantity',
            'Unit',
            'Date',
            'Sales Amount',
            'Status',
        ];
    }

    public function map($row): array
    {
        $type = $row->distributors_dealers->user_type == 1 ? '(Distributor)' : ($row->distributors_dealers->user_type == 2 ? '(Dealer)' : '');
        return [
            $row->unique_order_id ?? '',
            $row->distributors_dealers->applicant_name . ' ' . $type ?? '',
            // firm name
            $row->distributors_dealers->firm_shop_name ?? '',

            trim($row->sales_person_detail->first_name ?? '') . ' ' . trim($row->sales_person_detail->last_name ?? ''),
            $row->products->map(function ($orderProduct) {
                return  $orderProduct->product->product_name;
            })->implode("\n"),
            $row->products->map(function ($orderProduct) {
                return   $orderProduct->qty;
            })->implode("\n"),
            $row->products->map(function ($orderProduct) {
                return   $orderProduct->variation_option->unit;
            })->implode("\n"),
            Carbon::parse($row->order_date)->format('d M Y') ?? '',
            IndianNumberFormat($row->grand_total) ?? '',
            $row->statusName() ?? '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('D')->getAlignment()->setWrapText(true);
        $sheet->getStyle('E')->getAlignment()->setWrapText(true);
        $sheet->getStyle('E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true);
        $sheet->getStyle('F')->getAlignment()->setWrapText(true);
        $sheet->getStyle('G')->getAlignment()->setWrapText(true);
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
