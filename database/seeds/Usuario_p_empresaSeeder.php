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

        ]);


        Usuario_p_empresa::create([
            'user_id'      => 9,
            'empresa_id'     => 1,
        ]);

        Usuario_p_empresa::create([
            'user_id'      => 10,
            'empresa_id'     => 1,
        ]);

        Usuario_p_empresa::create([
            'user_id'      => 11,
            'empresa_id'     => 1,
        ]);
        Usuario_p_empresa::create([
            'user_id'      => 12,
            'empresa_id'     => 1,
        ]);

        Usuario_p_empresa::create([
            'user_id'      => 3,
            'empresa_id'     => 2,

        ]);
        Usuario_p_empresa::create([
            'user_id'      => 4,
            'empresa_id'     => 2,
        ]);
        Usuario_p_empresa::create([
            'user_id'      => 5,
            'empresa_id'     => 2,
        ]);

        Usuario_p_empresa::create([
            'user_id'      => 6,
            'empresa_id'     => 2,
        ]);

        Usuario_p_empresa::create([
            'user_id'      => 7,
            'empresa_id'     => 2,
        ]);

        Usuario_p_empresa::create([
            'user_id'      => 13,
            'empresa_id'     => 2,
        ]);

        Usuario_p_empresa::create([
            'user_id'      => 14,
            'empresa_id'     => 2,
        ]);

        Usuario_p_empresa::create([
            'user_id'      => 15,
            'empresa_id'     => 2,
        ]);
        Usuario_p_empresa::create([
            'user_id'      => 8,
            'empresa_id'     => 3,
        ]);





        //factory(Usuario_p_empresa::class,80)->create();
    }
}
