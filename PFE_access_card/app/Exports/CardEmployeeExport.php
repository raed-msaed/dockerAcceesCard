<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CardEmployeeExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    public function __construct(public Collection $records)
    {
        //
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->records;
    }

    public function map($cardEmployee): array
    {
        return [
            $cardEmployee->first_name,
            $cardEmployee->last_name,
        ];
    }

    public function headings(): array
    {
        return [
            'الإسم',
            'اللقب',
        ];
    }
}
