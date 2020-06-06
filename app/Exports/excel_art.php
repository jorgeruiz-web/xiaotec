<?php

namespace App\Exports;

use App\articulos;
use Maatwebsite\Excel\Concerns\FromCollection;

class excel_art implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return articulos::all();
    }
}
