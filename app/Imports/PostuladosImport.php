<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\User_ins_formacion;

class PostuladosImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    //use Importable;


    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            User_ins_formacion::create([
                'user_id' => $row['postulado'],
                'supervisor_id' => $row['supervisor'],
            ]);
        }
    }
}
