<?php

namespace App\Http\Controllers;
//import chromelogger as console;
//include 'ChromePhp.php';
use App\User_ins_formacion;
use App\Formacion;
use Illuminate\Http\Request;

class UserInsFormacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('responsable_de_personal.inscripcion');
    }




    public function select_formacion(Request $request)
    {
        /*$term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }*/

        //$tags = Tag::search($term)->limit(5)->get();

        $formaciones = Formacion::all();
        $formaciones_array = [];
        //$formaciones2 [] = ['id' => 2, 'text' => 'algo'];


        //dd($formaciones);

        //dd($formaciones);
        foreach ($formaciones as $formacion) {
            //dump($f);
            $formaciones_array[] = ['id' => $formacion->id, 'text' => $formacion->nombre];

        }
        //dump($formaciones_array);
        //dd($formaciones_array);
        //dump($formaciones);
        //var_dump($formaciones);
        //die($formaciones);
        //print_r($formacion);
        return response()->json($formaciones_array);



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User_ins_formacion  $user_ins_formacion
     * @return \Illuminate\Http\Response
     */
    public function show(User_ins_formacion $user_ins_formacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User_ins_formacion  $user_ins_formacion
     * @return \Illuminate\Http\Response
     */
    public function edit(User_ins_formacion $user_ins_formacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User_ins_formacion  $user_ins_formacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User_ins_formacion $user_ins_formacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User_ins_formacion  $user_ins_formacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(User_ins_formacion $user_ins_formacion)
    {
        //
    }
}
