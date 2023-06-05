<?php

namespace App\Imports;

use App\Models\CashBuyer;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToModel;

class CashBuyersImport implements ToModel, WithStartRow
{
    public function startRow(): int {
        return 2;
    }

    public function model(array $row) {
        return new CashBuyer([
            "name" => $row[0],
            "description" => $row[1],
            "email" => $row[2],
            "contact_no" => $row[3],
            "min_price_range" => $row[4],
            "max_price_range" => $row[5],
            "min_profit_deal" => $row[6],
            "property_type" => $row[7],
            "state" => $row[8],
            "city" => $row[9],
            "zip" => $row[10],
            "beds" => $row[11],
            "baths" => $row[12],
        ]);
    }
}
