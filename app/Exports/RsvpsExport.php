<?php

namespace App\Exports;

use App\Models\Rsvp;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class RsvpsExport implements FromQuery, WithMapping
{
    use Exportable;

    public function query()
    {
        return Rsvp::query();
    }

    public function map($model): array
    {
        return [
            $model->id,
            $model->name,
            $model->code,
            $model->phone,
            $model->children,
            $model->created_at,
        ];
    }
}