<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CustomerImport implements ToModel , WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        return new Customer([
            'branch_id'=> $row[0],
            'first_name'=>$row[1],
            'last_name'=>$row[2],
            'email'=>$row[3],
            'phone'=>$row[4],
            'gender'=>$row[5],
        ]);
    }
}
