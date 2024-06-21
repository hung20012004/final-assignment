<?php

namespace App\Exports;

use App\Models\Laptop;
use Maatwebsite\Excel\Concerns\FromCollection;

class LaptopsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Laptop::with('category', 'manufactory')->get()->map(function($laptop) {
            return [
                'ID' => $laptop->id,
                'Name' => $laptop->name,
                'Price' => $laptop->price,
                'Quantity' => $laptop->quantity,
                'Status' => $laptop->status,
                'Category' => $laptop->category->name,
                'Manufactory' => $laptop->manufactory->name,
                'Created At' => $laptop->created_at,
                'Updated At' => $laptop->updated_at,
            ];
        });
    }
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Price',
            'Quantity',
            'Status',
            'Category',
            'Manufactory',
            'Created At',
            'Updated At',
        ];
    }
}
