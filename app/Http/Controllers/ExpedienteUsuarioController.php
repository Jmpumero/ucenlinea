<?php

namespace App\Http\Controllers;

use App\Formacion;

use Carbon\Carbon;
use App\Expediente_usuario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//use PDF;
class ExpedienteUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    //estudiante califica y/o ve certificado
    public function show_formaciones_calificar_certificado_index()
    {
        if(request()->ajax())
        {
            //modificar esta consulta
            $user=Auth::user();
            //$em_id=$user->empresa->first()->id;

            $q= DB::table('expediente_usuarios as tbl_ex')->where('tbl_ex.user_id',$user->id)->where('tbl_ex.status','Finalizada')->where('calificacion_obtenida','>=',9.5)->join('formacions as tbl_f','tbl_ex.formacion_id','=','tbl_f.id')->select('tbl_f.nombre','tbl_f.id','tbl_ex.califico_formacion','tbl_ex.califico_facilitador','tbl_f.imagen');

            return datatables()->of($q)
            ->addColumn('action', function($data){
                if ($data->califico_formacion<0) {

                    $button = '<button type="button"  id ="btn_calificar" name="btn_ver" data-nf="'.$data->nombre.'" data-id="'.$data->id.'" class="califica btn btn-a1 btn-lg"><i class="fas fa-vote-yea" style="margin-right: 0.5rem;"></i>Calificar</button>';

                }else{
                    $button = '<button type="button"  id ="btn_ver_c" name="btn_ver" data-nf="'.$data->nombre.'" data-id="'.$data->id.'" class="ver btn btn-morado btn-sm"><i class="fas fa-eye" style="margin-right: 0.5rem;"></i>ver</button>';
                }


                return $button;


            })
            ->rawColumns(['action'])
            ->toJson();

        }

        return view('estudiante.est_certificado_calificar');

    }


    public function califica_formacion_facilitador(Request $request){

        if(request()->ajax())
        {
            //modificar esta consulta
            $user=Auth::user();

            $user_exp=Expediente_usuario::where('user_id',$user->id)->where('formacion_id',$request->formacion_id);

            $user_exp= DB::table('expediente_usuarios')->where('user_id',$user->id)->where('formacion_id',$request->formacion_id)->update(['califico_formacion' => $request->d_formacion,'califico_facilitador' => $request->d_facilitador]);

        }

        return view('estudiante.est_certificado_calificar');

    }



    public function certificado_donwload(Request $request){


        $user=Auth::user();
        $data=DB::table('certificados_f_estudiantes')->where('user_id',$user->id)->where('formacion_id',$request->f_id)->join('users as tbl_user','certificados_f_estudiantes.user_id','=','tbl_user.id')->join('formacions as tbl_f','certificados_f_estudiantes.formacion_id','=','tbl_f.id')->join('empresas as tbl_em','tbl_f.empresa_proveedora_id','=','tbl_em.id')->select('tbl_user.name','certificados_f_estudiantes.codigo_certificado','tbl_f.nombre','tbl_f.empresa_proveedora_id','tbl_f.fecha_de_inicio','tbl_f.fecha_de_culminacion','tbl_user.ci','tbl_em.nombre as empresa_nombre','tbl_em.direccion','tbl_f.created_at');
        //$data->toArray();
        if ($data->exists()) {
            $data=$data->get();
            foreach ($data as $key => $value) {
                $f_inicio= Carbon::parse($value->fecha_de_inicio)->format('d-m-Y ');
                $f_cul= Carbon::parse($value->fecha_de_culminacion)->format('d-m-Y ');
            }

            $pdf = PDF::loadView('estudiante.vista_certificado',compact('data','f_inicio','f_cul'));
            //$pdf = PDF::loadView('estudiante.vista_certificado',$data);
            return $pdf->stream( 'Formacion: '.$request->f_id.'_Certificado.pdf');
        }else{
            return redirect()->back();
        }

        //asegurarse que $data no sea vacio

       //no se porque el download no funciona... hace colapsar el serve
        //return view('estudiante.vista_certificado',compact('data'));
    }



    //supervisor
    public function index_supervisor(){
        return view('supervisor.sup_califica_estudiantes');
    }


    //supervisor //siempre post carga de notas entonces finalizada y abandonadas
    public function show_postulados_supervisor(Request $request){

        if(request()->ajax())
        {
           $ids_user=[];
           $user=Auth::user();

           $q=Expediente_usuario::where('expediente_usuarios.supervisor_id',$user->id)->where('expediente_usuarios.formacion_id',$request->f_id)->where('expediente_usuarios.status','Finalizada') ->orWhere(function($query) use ($user,$request) {
            $query->where('expediente_usuarios.supervisor_id',$user->id)->where('expediente_usuarios.formacion_id',$request->f_id)->where('expediente_usuarios.status','Abandonada');
        })->join('users','users.id','=','expediente_usuarios.user_id')->get();



           //$q=Formacion::whereIn('id',$idf)->get();

            return datatables()->of($q)
            ->addColumn('action', function($data){
                $button = '<button type="button"  id ="btn_calificar" name="btn_ca"    data-id="'.$data->id.'" class="examinar btn btn-calificar btn"><i class="fas fa-star fa-2x" "></i></button>';

                return $button;


            })
            ->rawColumns(['action'])
            ->toJson();

        }

        return view('supervisor.sup_califica_estudiantes');


    }



     //supervisor
     public function show_formaciones_supervisor(Request $request){

        if(request()->ajax())
        {
            $idf=[];
            $user=Auth::user();

            $q=Expediente_usuario::where('supervisor_id',$user->id)->where('calificacion_supervisor',-1)->where('status','Finalizada')->orWhere(function($query) use ($user) {
                $query->where('supervisor_id',$user->id)->where('calificacion_supervisor',-1)->where('status','Abandonada');
            })->get();


            foreach ($q as $key => $value) {

                $idf[]=$value->formacion_id;

            }

            $idf=array_values(array_unique($idf));
            //de esta forma para variar
            $now=Carbon::now();
            $now=$now->subDay(7);
            $qw = Formacion::whereIn('id',$idf)->where('fecha_de_culminacion','<=',$now)->select('id','imagen','nombre','fecha_de_culminacion')->get();


           //$q=Formacion::whereIn('id',$idf)->get();

            return datatables()->of($qw)
            ->addColumn('action', function($data){
                $button = '<button type="button"  id ="btn_ver_m" name="btn_ver" data-nf="'.$data->nombre.'"   data-id="'.$data->id.'" class="examinar btn btn-primary btn"><i class="fas fa-search fa-lg" style="margin-right: 0.5rem;"></i>ver</button>';

                return $button;


            })
            ->rawColumns(['action'])
            ->toJson();

        }

        return view('supervisor.sup_califica_estudiantes');


    }





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
     * @param  \App\Expediente_usuario  $expediente_usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Expediente_usuario $expediente_usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expediente_usuario  $expediente_usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Expediente_usuario $expediente_usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expediente_usuario  $expediente_usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expediente_usuario $expediente_usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expediente_usuario  $expediente_usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expediente_usuario $expediente_usuario)
    {
        //
    }
}
