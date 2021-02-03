<?php

namespace App\Exports;

//use App\Invoice;
use Maatwebsite\Excel\Concerns\FromArray;
//use Maatwebsite\Excel\Concerns\Exportable;

class ErroresExport implements FromArray
{
    protected $errores;
    //use Exportable;
    public function __construct(array $errores)
    {
        $this->errores = $errores;
    }

    public function array(): array
    {
        return $this->errores;
    }
}
