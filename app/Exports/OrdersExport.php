<?php
namespace App\Exports;

use App\Models\Order;
use App\Models\OrderDetail;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class OrdersExport implements FromArray, WithHeadings, WithEvents
{
    public function array(): array
{
    $orders = Order::with(['user', 'customer', 'order_detail.laptop'])->get();
    $data = [];
    $row = 1; 
    foreach ($orders as $order) {
        foreach ($order->order_detail as $orderDetail) {
            $data[] = [
                'STT' => $row,
                'ID' => $order->id,
                'NVBH' => $order->user->name,
                'Khách hàng' => $order->customer->name,
                'Laptop' => $orderDetail->laptop->name,
                'Số lượng' => $orderDetail->quantity,
                'Giá' => ($orderDetail->laptop->price * $orderDetail->quantity),
                'Ngày tạo' => $order->created_at->format('d-m-Y H:i:s'),
                'Ngày cập nhật' => $order->updated_at->format('d-m-Y H:i:s'),
            ];
        }

       $row++;
    }

    return $data;
}

    public function headings(): array
    {
        return [
            'STT', 'ID', 'NVBH', 'Khách hàng', 'Laptop', 'Số lượng','Giá', 'Ngày tạo', 'Ngày cập nhật'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Merge cells for the header row (A1:H1)
                $sheet->mergeCells('A1:I1');

                // Set header text
                $sheet->setCellValue('A1', 'DANH SÁCH ĐƠN HÀNG');

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
                ]);
                $headings = ['STT', 'ID', 'NVBH', 'Khách hàng', 'Laptop', 'Số lượng','Giá', 'Ngày tạo', 'Ngày cập nhật'];
                $sheet->fromArray($headings, null, 'A2');
                // Set styles for the column headings (A2:H2)
                $sheet->getStyle('A2:I2')->applyFromArray([
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
                $sheet->getStyle('A3:I' . ($sheet->getHighestRow()))->applyFromArray([
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
                foreach (range('A', 'I') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
            },
        ];
    }
}