<?php

namespace App\Exports;

use App\vendedores;
use Maatwebsite\Excel\Concerns\FromCollection;

class excel_vend implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return vendedores::all();
    }
}
