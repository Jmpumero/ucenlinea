<?php

namespace App\Http\Controllers;

use App\User; //ojo entrar en conflicto con el auth?

use App\Empresa;
use App\Formacion;
use Carbon\Carbon;
use App\Motivo_retiro;
use App\Mdl_inscripcion;
use App\Rce_ti_uvc_retiro;
use App\Retiro_uvc_rp_rce;
use App\Expediente_usuario;
use Illuminate\Http\Request;
use App\Retiro_formacion_est_rp;
use App\Retiro_formacion_rp_rce;
use App\Motivos_retiro_formacion;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
//use PDF;
class ExpedienteUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //estudiante
    public function retirar_formacion_index()
    {

        //$result=DB::table('expediente_usuarios as tbl_exp')->where('tbl_exp.user_id',$user->id)->where('tbl_exp.status','Cursando')->join('formacions as tbl_f','tbl_f.id','=','tbl_exp.formacion_id')->select('tbl_f.nombre')->get(); kek me equivoq
        $result=Motivo_retiro::all();

        return view('estudiante.est_retira_formacion')->with('results', $result);


    }

    //estudiante
    public function enviar_solicitud_retiro(Request $request)
    {
        if(request()->ajax())
        {
            $user=Auth::user();
            $em_id=$user->empresa->first()->id;

            $solicitud= new Retiro_formacion_est_rp;
            $solicitud->postulado_id=$user->id;
            $solicitud->formacion_retira_id=$request->formacion_id;
            $solicitud->descripcion=$request->des_retiro;
            $solicitud->empresa_del_postulado_id=$em_id;
            $solicitud->save();

            Expediente_usuario::where('user_id',$user->id)->where('formacion_id',$request->formacion_id) ->update(['solicitud_retiro' => true]);

            $array_m=explode(',',$request->f_motivos);

            for ($i=0; $i <count($array_m) ; $i++) {
                $mot=Motivo_retiro::firstWhere('motivo',$array_m[$i]);

                $motivos= new Motivos_retiro_formacion;
                $motivos->mrf_postulado_id=$user->id;
                $motivos->mrf_formacion_id=$request->formacion_id;
                $motivos->mrf_motivo_id=$mot->id;
                $motivos->save();
            }
            //
        }
    }

    public function tabla_retira_formacion_index()
    {
        if(request()->ajax())
        {
            $user=Auth::user();
                //$em_id=$user->empresa->first()->id;

            $q= DB::table('expediente_usuarios as tbl_ex')->where('tbl_ex.user_id',$user->id)->where('tbl_ex.status','Cursando')->where('tbl_ex.solicitud_retiro',false)->join('formacions as tbl_f','tbl_ex.formacion_id','=','tbl_f.id')->select('tbl_f.nombre','tbl_f.id','tbl_f.imagen');

            return datatables()->of($q)
            ->addColumn('action', function($data){


                $button = '<button type="button"  id ="btn_retirar" name="btn_ver" data-nf="'.$data->nombre.'" data-id="'.$data->id.'" class="califica btn btn-outline-danger btn"><i class="fas fa-minus" style="margin-right: 0.5rem;"></i>Retirar</button>';

                return $button;


            })
            ->rawColumns(['action'])
            ->toJson();
        }
        return view('estudiante.est_retira_formacion');


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

            //$user_cert= DB::table('certificados_f_estudiantes')->where('user_id',$user->id)->where('formacion_id',$request->formacion_id)->update(['califico_formacion' => $request->d_formacion,'califico_facilitador' => $request->d_facilitador]);

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

           $q=Expediente_usuario::where('expediente_usuarios.supervisor_id',$user->id)->where('expediente_usuarios.formacion_id',$request->f_id)->where('expediente_usuarios.status','Finalizada')->where('calificacion_supervisor',-1) ->orWhere(function($query) use ($user,$request) {
            $query->where('expediente_usuarios.supervisor_id',$user->id)->where('expediente_usuarios.formacion_id',$request->f_id)->where('expediente_usuarios.status','Abandonada')->where('calificacion_supervisor',-1);
        })->join('users','users.id','=','expediente_usuarios.user_id')->get();

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


    //supervisor
    public function calificar_postulado(Request $request){

        if(request()->ajax())
        {

            $user=Auth::user();

            $q=Expediente_usuario::where('user_id',$request->user_id)->where('formacion_id',$request->f_id)->where('supervisor_id',$user->id) ->update(['calificacion_supervisor' => $request->d_postulado]);





        }
    }



    //responsable de personal
    public function index_retiro_uvc(){
        return view('responsable_de_personal.rp_solicitud_retiro_uvc');
    }


    //responsable de personal
    public function tabla_postulados_retirar_uvc()
    {
        $user=Auth::user();
        if(request()->ajax())
        {

            $roles = Role::findByName('Estudiante');
            $roles_us=$roles->users;
            $em_id=$user->empresa->first()->id;//ojo
            $usuarios=Empresa::find($em_id)->users;
            $q=$roles_us->intersect($usuarios);
            return datatables()->of($q->where('status',1))
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="postulado" id="btn_retirar" data-id="'.$data->id.'" class="inscribir btn  btn-outline-danger btn"><i class="fas fa-trash fa-lg"></i></button>';


                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->toJson();
        }
        return view('responsable_de_personal.rp_solicitud_retiro_uvc');


    }

    //responsable de personal
    public function solicitudes_retiro_formacion_postulados_index()
    {

        return view('responsable_de_personal.rp_solicitudes_de_postulados');


    }


    //responsable de personal
    public function tabla_solicitudes_post_rp()
    {
        if(request()->ajax())
        {
            $user=Auth::user();
            $em_id=$user->empresa->first()->id;

            $q= DB::table('retiro_formacion_est_rps as tbl_ret')->where('tbl_ret.empresa_del_postulado_id',$em_id)->where('tbl_ret.status_solicitud','NO PROCESADA')->join('users as tbl_us','tbl_ret.postulado_id','=','tbl_us.id')->select('tbl_us.name','tbl_us.ci','tbl_us.avatar','tbl_ret.created_at','tbl_us.id','tbl_ret.formacion_retira_id');

            return datatables()->of($q)
            ->addColumn('action', function($data){


                $button = '<button type="button"  id ="btn_ver" name="btn_ver" data-f="'.$data->formacion_retira_id.'" data-uid="'.$data->id.'" class="califica btn btn-success btn"><i class="fas fa-eye" style="margin-right: 0.5rem;"></i>Ver</button>';

                return $button;


            })
            ->rawColumns(['action'])
            ->toJson();
        }
        return view('responsable_de_personal.rp_solicitudes_de_postulados');


    }

    //responsable de personal
    public function datos_modal_solicitudes_post_rp(Request $request)
    {
        if(request()->ajax())
        {
            $user=Auth::user();
            $em_id=$user->empresa->first()->id;

            $q= DB::table('retiro_formacion_est_rps as tbl_ret')->where('tbl_ret.empresa_del_postulado_id',$em_id)->where('tbl_ret.postulado_id',$request->user_id)->where('tbl_ret.formacion_retira_id',$request->f_id)->where('tbl_ret.status_solicitud','NO PROCESADA')->join('users as tbl_us','tbl_ret.postulado_id','=','tbl_us.id')->select('tbl_us.name','tbl_us.ci','tbl_ret.created_at','tbl_us.id','tbl_ret.descripcion')->get();

            $f=Formacion::find($request->f_id);

            $m=Motivos_retiro_formacion::where('mrf_postulado_id',$request->user_id)->where('mrf_formacion_id',$request->f_id)->join('motivo_retiros','motivos_retiro_formacions.mrf_motivo_id','=','motivo_retiros.id')->select('motivo')->get();

            foreach ($m as $key => $value) {
                $am[]=$value->motivo;
            }

            foreach ($q as $key => $value) {
                $array_d[]=['f_solicitud'=>$value->created_at,'p_nombre'=>$value->name,'p_ci'=>$value->ci,'descripcion'=>$value->descripcion,'f_nombre'=>$f->nombre,'f_inicio'=>$f->fecha_de_inicio,'motivos'=>$am];
            }


            return response()->json($array_d);
        }
        return view('responsable_de_personal.rp_solicitudes_de_postulados');


    }


    //responsable de personal
     public function procesar_solicitud_retiro(Request $request)
     {
         if(request()->ajax())
         {
             $user=Auth::user();


             $solicitud= new Retiro_formacion_rp_rce;
             $solicitud->rp_id=$user->id;
             $solicitud->postulado_id=$request->p_id;
             $solicitud->formacion_retira_id=$request->formacion_id;
             $solicitud->save();

             Retiro_formacion_est_rp::where('postulado_id',$request->p_id)->where('formacion_retira_id',$request->formacion_id) ->update(['status_solicitud' => 'PROCESADA']);

             //

         }
     }

     //responsable de personal
     public function enviar_solicitud_retiro_uvc(Request $request)
     {
         if(request()->ajax())
         {
             $user=Auth::user();


             $solicitud= new Retiro_uvc_rp_rce;
             $solicitud->rp_id=$user->id;
             $solicitud->postulado_id=$request->user_id;
             $solicitud->save();


             //el cambio de status del user es para filtrarlo en la tabla y no reaparesca
             User::where('id',$request->user_id)->update(['status' => 0]);


         }
     }



     //responsable de control de estudio
     public function procesar_retiro_uvc(Request $request)
     {
         if(request()->ajax())
         {
             $user=Auth::user();

             Retiro_uvc_rp_rce::where('postulado_id',$request->user_id)->update(['status_solicitud' => 'PROCESADA']);

             //actualiza expediente
             Expediente_usuario::where('user_id',$request->user_id)->where('status','Cursando') ->update(['status' => 'Retirada']);
             //desmatricula
             Mdl_inscripcion::where('user_id',$request->user_id)->where('rol_shortname','student')->delete();

             $postulado=User::find($request->user_id);
             $postulado->removeRole('Estudiante');
             //generea solicitud a ti

            $em_p=$postulado->empresa->first()->id; //ojo con esto en algn futuro


            $solicitud= new Rce_ti_uvc_retiro;
            $solicitud->rce_id=$user->id;
            $solicitud->retirado_id=$request->user_id;
            $solicitud->empresa_retirado_id=$em_p;
            $solicitud->save();

             //

         }
     }


      //responsable de control de estudio
    public function tabla_retiro_uvc_rp_rces()
    {
        if(request()->ajax())
        {
            $user=Auth::user();
           // $em_id=$user->empresa->first()->id;

            $q= DB::table('retiro_uvc_rp_rces as tbl_ret')->where('tbl_ret.status_solicitud','NO PROCESADA')->join('users as tbl_us','tbl_ret.postulado_id','=','tbl_us.id')->select('tbl_us.name','tbl_us.ci','tbl_us.avatar','tbl_ret.created_at','tbl_us.id');

            return datatables()->of($q)
            ->addColumn('action', function($data){


                $button = '<button type="button"  id ="btn_retirar" name="btn_ver"  data-id="'.$data->id.'" class="btn btn-danger btn"><i class="fas fa-trash" style="margin-right: 0.5rem;"></i>retirar</button>';

                return $button;


            })
            ->rawColumns(['action'])
            ->toJson();
        }
        return view('responsable_control_de_estudio.rce_solicitudes_retiro_uvc');


    }



      //responsable de control de estudio
    public function tabla_retiro_formacion_rp_rces()
    {
        if(request()->ajax())
        {
            $user=Auth::user();
           // $em_id=$user->empresa->first()->id;

            $q= DB::table('retiro_formacion_rp_rces as tbl_ret')->where('tbl_ret.status_solicitud','NO PROCESADA')->join('users as tbl_us','tbl_ret.postulado_id','=','tbl_us.id')->select('tbl_us.name','tbl_us.ci','tbl_us.avatar','tbl_ret.created_at','tbl_us.id','tbl_ret.formacion_retira_id');

            return datatables()->of($q)
            ->addColumn('action', function($data){


                $button = '<button type="button"  id ="btn_retirar" name="btn_ver" data-f="'.$data->formacion_retira_id.'" data-uid="'.$data->id.'" class="btn btn-danger btn"><i class="fas fa-trash" style="margin-right: 0.5rem;"></i>retirar</button>';

                return $button;


            })
            ->rawColumns(['action'])
            ->toJson();
        }
        return view('responsable_control_de_estudio.rce_solicitud_retiro_formacion');


    }


    //responsable de control de estudio
    public function procesar_retiro_formacion(Request $request)
    {
        if(request()->ajax())
        {
            $user=Auth::user();

            Retiro_formacion_rp_rce::where('postulado_id',$request->user_id)->where('formacion_retira_id',$request->formacion_id) ->update(['status_solicitud' => 'PROCESADA']);

            //actualiza expediente
            Expediente_usuario::where('user_id',$request->user_id)->where('formacion_id',$request->formacion_id) ->update(['status' => 'Retirada']);
            //desmatricula
            Mdl_inscripcion::where('user_id',$request->user_id)->where('formacion_id',$request->formacion_id)->where('rol_shortname','student')->delete();

            //

        }
    }




}
