<?php

namespace App\Exports;

//use App\Invoice;
use Maatwebsite\Excel\Concerns\FromArray;

class ErroresExport implements FromArray
{
    protected $errores;

    public function __construct(array $errores)
    {
        $this->errores = $errores;
    }

    public function array(): array
    {
        return $this->errores;
    }
}
