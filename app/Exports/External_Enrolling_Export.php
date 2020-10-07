<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
//use Maatwebsite\Excel\Concerns\Exportable;

class External_Enrolling_Export implements FromArray
{
    protected $matricula;
    //use Exportable;
    public function __construct(array $matricula)
    {
        $this->matricula = $matricula;
    }

    public function array(): array
    {
        return $this->matricula;
    }
}
