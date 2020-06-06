<?php

namespace App\Exports;

use App\historial;
use Maatwebsite\Excel\Concerns\FromCollection;

class excel_his implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return historial::all();
    }
}
