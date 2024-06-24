<?php
namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CustomersExport implements FromArray, WithEvents
{
    public function array(): array
    {
        $customers = Customer::all();
        $data = [];
        $row = 1;

        foreach ($customers as $customer) {
            $data[] = [
                'STT' => $row,
                'ID' => $customer->id,
                'Tên' => $customer->name,
                'Địa chỉ' => $customer->address,
                'Điện thoại' => $customer->phone,
                'Email' => $customer->email,
                'Ngày tạo' => $customer->created_at->format('d-m-Y H:i:s'),
                'Ngày cập nhật' => $customer->updated_at->format('d-m-Y H:i:s'),
            ];
            $row++;
        }

        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Merge cells for the header row (A1:H1)
                $sheet->mergeCells('A1:H1');

                // Set header text
                $sheet->setCellValue('A1', 'DANH SÁCH KHÁCH HÀNG');

                // Set styles for the header row
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'name' => 'Times New Roman',
                        'bold' => true,
                        'size' => 14,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],

                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFCCFFCC', // Mã màu xanh lá cây nhạt
                        ],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Set column headings manually
                $headings = ['STT', 'ID', 'Tên', 'Địa chỉ', 'Điện thoại', 'Email', 'Ngày tạo', 'Ngày cập nhật'];
                $sheet->fromArray($headings, null, 'A2');

                // Set styles for the column headings (A2:H2)
                $sheet->getStyle('A2:H2')->applyFromArray([
                    'font' => [
                        'name' => 'Times New Roman',
                        'bold' => true,
                        'size' => 13,
                        'italic' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Set styles for all data rows (A3:Hn)
                $sheet->getStyle('A3:H' . ($sheet->getHighestRow() + 2))->applyFromArray([
                    'font' => [
                        'name' => 'Times New Roman',
                        'size' => 13,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Adjust column widths
                foreach (range('A', 'H') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }

                // Write data starting from row 3
                $data = $this->array();
                $sheet->fromArray($data, null, 'A3');
            },
        ];
    }
}