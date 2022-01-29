<?php

namespace App\Exports;

use App\Profit;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProfitExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Profit::all();
    }
}
