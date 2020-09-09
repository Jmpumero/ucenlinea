<?php

use Illuminate\Database\Seeder;
use App\Usuario_p_empresa;
class Usuario_p_empresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        App\Usuario_p_empresa::create([
            'user_id'      => 1,
            'empresa_id'     => 1,

        ]);
        Usuario_p_empresa::create([
            'user_id'      => 2,
            'empresa_id'     => 1,

        ]); Usuario_p_empresa::create([
            'user_id'      => 3,
            'empresa_id'     => 1,

        ]); Usuario_p_empresa::create([
            'user_id'      => 4,
            'empresa_id'     => 1,

        ]);


        factory(Usuario_p_empresa::class,90)->create();
    }
}
