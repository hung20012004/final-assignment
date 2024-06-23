<?php

namespace App\Exports;
use App\Models\Blog;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\FromCollection;

class BlogsExport implements FromArray, WithEvents
{
    /**
    // * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Blog::all();
    // }
    public function array(): array
    {
        $blogs = Blog::all();
        $data = [];
        $row = 1;

        foreach ($blogs as $blog) {
            $data[] = [
                'STT' => $row,
                'ID' => $blog->id,
                'Tiêu đề' => $blog->title,
                'Nhân viên' => $blog->user->name,
                'nội dung' => $blog->pcontent,
                'Tác giả' => $blog->author,
                'Ngày tạo' => $blog->created_at->format('d-m-Y H:i:s'),
                'Ngày cập nhật' => $blog->updated_at->format('d-m-Y H:i:s'),
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
                $sheet->setCellValue('A1', 'DANH SÁCH BÀI VIẾT');

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
                $headings = ['STT', 'ID', 'Tiêu đề', 'Nhân viên', 'Nội dung', 'Tác giả', 'Ngày tạo', 'Ngày cập nhật'];
                $sheet->fromArray($headings, null, 'A2');

                // Set styles for the column headings (A2:H2)
                $sheet->getStyle('A2:H2')->applyFromArray([
                    'font' => [
                        'name' => 'Times New Roman',
                        'bold' => true,
                        'size' => 13,
                        'italic' => true,
                        //underline để gạch chân
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

                foreach (range('A', 'H') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }

                // Write data starting from row 3
                $data = $this->array();
                $sheet->fromArray($data, null, 'A3'); // điền vào từ ô A3
            },
        ];
    }
}
