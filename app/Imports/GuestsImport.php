<?php

namespace App\Imports;

use App\Models\Guest;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuestsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $family = $row['family_name'];
        $children = $row['childrens_name'];
        $phoneNumber = $row['phone_number'];
        $numberOfChildren = $row['number_of_children'];

        return new Guest([
            'family' => $family,
            'children' => $children,
            'phone' => $phoneNumber,
            'total' => ($numberOfChildren) ? intval($numberOfChildren) : 0
        ]);
    }
}
