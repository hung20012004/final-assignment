<?php
namespace App\Exports;

use App\Models\Salary;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SalaryExport implements FromArray, WithEvents
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function array(): array
    {
        $salaries = Salary::where('month', $this->month)
                      ->where('year', $this->year)
                      ->get();
         $data = [];
         $row = 1;
    
        foreach ($salaries as $salary) {
            $data[] = [
                'STT' => $row,
                'ID' => $salary->id,
                'Staff' => $salary->user->name,
                'Month' => $salary->month,
                'Year' => $salary->year,
                'Base_salary' => $salary->base_salary,
                'Allowances' => $salary->allowances,
                'Deductions' =>$salary->deductions,
                'Created_at' => $salary->created_at,
                'Updated_at' => $salary->updated_at,
                'Total ' => $salary->total_salary
            ];
            $row++; 
    }
        return $data;
    }

   public function registerEvents(): array
{
    $evenRowColor = 'EEEEEE'; // Màu cho dòng chẵn
    $oddRowColor =  'FFFFFF';  // Màu cho dòng lẻ

    return [
        AfterSheet::class => function (AfterSheet $event) use ($evenRowColor, $oddRowColor) {
            $sheet = $event->sheet->getDelegate();

            // Merge cells for the header row (A1:K1)
            $sheet->mergeCells('A1:K1');

            // Set header text
            $sheet->setCellValue('A1', 'BẢNG LƯƠNG THÁNG ' . $this->month . ' NĂM ' . $this->year . '');

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
                        'argb' => 'FFCCFFCC', // Màu mặc định cho dòng chẵn
                    ],
                ],
                'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
            ]);

            // Set column headings manually
            $headings = ['STT', 'ID', 'Tên NV', 'Tháng', 'Năm', 'LCB', 'Phụ cấp', 'Phụ thu', 'Ngày tạo', 'Ngày cập nhật', 'Tổng lương'];
            $sheet->fromArray($headings, null, 'A2');

            // Set styles for the column headings (A2:K2)
            $sheet->getStyle('A2:K2')->applyFromArray([
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
            $sheet->getStyle('A3:K' . ($sheet->getHighestRow() + 2))->applyFromArray([
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
            foreach (range('A', 'K') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            // Write data starting from row 3
            $data = $this->array();
            foreach ($data as $index => $row) {
                $backgroundColor = ($index % 2 == 0) ? $evenRowColor : $oddRowColor;

                // Apply background color to the entire row
                $sheet->getStyle('A' . ($index + 3) . ':K' . ($index + 3))->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => $backgroundColor,
                        ],
                    ],
                ]);
            }

            $sheet->fromArray($data, null, 'A3');
        },
    ];
}
}