<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
//use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use App\User_ins_formacion;

class PostuladosImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    //use Importable;
    //use SkipsErrors;


    public function collection(Collection $rows)
    {


       /*no se como funciona esto,nada de lo que haga aqui parece afectar*/
        Validator::make($rows->toArray(), [
            '*.0' => 'integer',
            '*.1' => 'integer',
        ])->validate();


        foreach ($rows as $row)
        {
            if ($row['postulado']!='y') {
                return[ User_ins_formacion::create([
                    'user_id' => $row['postulado'],
                    'supervisor_id' => $row['supervisor'],
                ])];
            }

        }

    }


    /*public function rules(){
        //...
     }*/
}
