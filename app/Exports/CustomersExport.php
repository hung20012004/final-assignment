<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class CustomersExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @return Collection
     */
    public function collection()
    {
       $customers = Customer::all();

    // Thêm cột 'STT' vào từng khách hàng
    $customers->transform(function ($customer, $key) {
        $customerArray = $customer->toArray(); // Chuyển đổi thành mảng để có thể thêm phần tử mới
        $customerArray['STT'] = $key + 1; // Thêm số thứ tự
        return $customerArray;
    });

    return $customers;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'STT',
            'ID',
            'Tên',
            'Địa chỉ',
            'Điện thoại',
            'Email',
            'Ngày tạo',
            'Ngày cập nhật'
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles( $sheet): array
    {
        // Style cho dòng "Danh sách khách hàng"
        $styles = [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 14,
                    'name' => 'Times New Roman',
                    'color' => ['argb' => 'FF000000'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFB3E6C4'],
                ],
            ],
            // Style cho dòng tiêu đề các cột
            2 => [
                'font' => [
                    'bold' => true,
                    'size' => 13,
                    'name' => 'Times New Roman',
                    'color' => ['argb' => 'FF000000'],
                    'italic' => true,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ],
            // Style cho các dòng dữ liệu
            3 => [
                'font' => [
                    'size' => 13,
                    'name' => 'Times New Roman',
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ],
        ];

        return $styles;
    }

  /**
 * @return array
 */
public function registerEvents(): array
{
    return [
        AfterSheet::class => function(AfterSheet $event) {
            // Thêm dòng "Danh sách khách hàng" và merge cells
            $event->sheet->mergeCells('A1:H1'); // Điều chỉnh merge cell từ A đến H thay vì A đến G
            $event->sheet->getStyle('A1')->applyFromArray($this->styles($event->sheet)[1]);
            $event->sheet->setCellValue('A1', 'Danh sách khách hàng');

            // Dịch chuyển dòng headings xuống dưới dòng "Danh sách khách hàng"
            $event->sheet->getStyle('A2:H2')->applyFromArray($this->styles($event->sheet)[2]);

            // Di chuyển dòng dữ liệu xuống dưới dòng headings
            $rowCount = $this->collection()->count() + 2; // +2 để tính cả dòng "Danh sách khách hàng" và dòng tiêu đề
            $event->sheet->getStyle('A3:H' . $rowCount)->applyFromArray($this->styles($event->sheet)[3]);
        },
    ];
}
}