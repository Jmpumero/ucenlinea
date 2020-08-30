<?php

namespace App\Http\Controllers;
//import chromelogger as console;
//include 'ChromePhp.php';
use App\User_ins_formacion;
use App\Formacion;
use App\User;
use App\Empresa;
use App\Requisicion;
use App\User_p_empresa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class UserInsFormacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* //una forma
        //$query=DB::table('formacions')->where('status','sin postulados');
        //$formaciones_list=$query->pluck('nombre','id');*/


        //$q=User::query()->get()->toJson();

        $user=Auth::user();
        if ($user->hasPermissionTo('inscribir estudiantes')) {
            //falta un condicional especial para el rol admin y super-admin
            $now=Carbon::now('-4:00'); //bueno como se cambio la variable  'timezone' =>'America/Caracas' ya no es necesario hacer esta inicializacion bastaria con usar Carbon::now()
            $em_id=$user->empresa->first()->id;
            //dump($em_id);
            $r=Requisicion::where('empresa_id',$em_id);
            //dump($r->get());
            $formaciones_list=$r->join('formacions','requisicions.id','=','formacions.requisicion_id')->where('status','sin postulados')->where('disponibilidad',1)->where('fecha_de_inicio','>',$now)->get()->pluck('nombre','id');
            //dump($formaciones_list);

            return view('responsable_de_personal.inscripcion',['formaciones_list'=>$formaciones_list]);
        }



    }





    public function select_formacion(Request $request) //select con ajax
    {
        /*$term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }*/

        //$tags = Tag::search($term)->limit(5)->get();

        $formaciones = Formacion::all();
        $formaciones_array = [];

        foreach ($formaciones as $formacion) {
            //dump($f);
            $formaciones_array[] = ['id' => $formacion->id, 'text' => $formacion->nombre];

        }

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
    public function show($id)
    {
        if(request()->ajax())
        {


            //$t=json_encode($f);
            $q=User_ins_formacion::where('formacion_id',$id)->join('users','user_ins_formacions.user_id','=','users.id')->select('users.ci','users.name','users.apellido','users.email','user_ins_formacions.supervisor_id')->get();

            $t=collect($q);
            return datatables()->of($q)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="inscribir btn btn-success btn-sm">Inscribir</button>';

                        $button .= '<button type="button" name="delete" id ="btn-eliminar"    data-id="'.$data->id.'" class="btn-eliminar btn btn-danger btn-sm">Borrar</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->toJson();
        }else {
            $q3=User_ins_formacion::join('users as tbl1','tbl1.id','=','user_ins_formacions.user_id')->join('users as tbl2','tbl2.id','=','user_ins_formacions.supervisor_id')->get()->dump();


            $q=User_ins_formacion::where('formacion_id',$id)->join('users','user_ins_formacions.user_id','=','users.id')->select('users.ci','users.name','users.apellido','users.email','user_ins_formacions.supervisor_id')->get();

            foreach ($q as $item) {
                //dump($f);
                $f[] = ['ci' => $item->ci, 'name' => $item->name,'apellido' => $item->apellido,'email' => $item->email,'supervisor' => User::find($item->supervisor_id)->name.' '.User::find($item->supervisor_id)->apellido];

            }






        }
        //return view('responsable_de_personal.inscripcion');
       // return response()->json($formaciones_array);

    }




    public function especialdt($id)
    {

        $q3=User_ins_formacion::join('users as tbl1','tbl1.id','=','user_ins_formacions.user_id')->join('users as tbl2','tbl2.id','=','user_ins_formacions.supervisor_id')->select('tbl1.name','tbl1.apellido','tbl2.apellido')->dump();

        $q3=User_ins_formacion::join('users as tbl1','tbl1.id','=','user_ins_formacions.user_id')->join('users as tbl2','tbl2.id','=','user_ins_formacions.supervisor_id')->select('tbl1.name','tbl1.apellido','tbl2.name as snombre','tbl2.apellido as sapellido')->get()->dump();

        /*$q=User_ins_formacion::where('formacion_id',$id)->join('users','user_ins_formacions.user_id','=','users.id')->select('users.ci','users.name','users.apellido','users.email','user_ins_formacions.supervisor_id')->get();

            foreach ($q as $item) {
                //dump($f);
                $data[] = ['ci' => $item->ci, 'name' => $item->name,'apellido' => $item->apellido,'email' => $item->email,'supervisor' => User::find($item->supervisor_id)->name.' '.User::find($item->supervisor_id)->apellido];
            }

            $d=json_encode($data);
            dump($d);*/
            //return response()->json($data);
            //return $q3;

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
