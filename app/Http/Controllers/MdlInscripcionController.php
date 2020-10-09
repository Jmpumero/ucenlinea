<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Formacion;
use Carbon\Carbon;
use App\Requisicion;
use App\Mdl_inscripcion;
use App\Matricula_externa;
use App\Usuario_p_empresa;
use App\Expediente_usuario;

use App\User_ins_formacion;
use Illuminate\Http\Request;
use App\Certificados_f_estudiante;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\External_Enrolling_Export;

class MdlInscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax())
        {
            $now=Carbon::now();
            $now->addDays(2);
            return datatables()->of(Formacion::where('status','con postulados')->where('t_facilitador',0)->where('disponibilidad',1)->where('tipo','interna')->whereDate('fecha_de_inicio','<=',$now))->addColumn('action', function($data){
                $button = '<button type="button" name="edit" id="btn_edit_p" data-id="'.$data->id.'" class="examinar btn btn-info btn-sm"><i class="fas fa-search"></i></button>';

                $button .= '<button type="button" name="delete" id ="btn_enroll"    data-id="'.$data->id.'" class="btn-matricular btn btn-success btn-sm"><i class="fas fa-address-book"  style="margin-right: 0.5rem;" ></i>Matricular</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->toJson();

        }

        return view('responsable_control_de_estudio.rce_matricular');
    }



    public function matriculacion_externa_index()
    {

        if(request()->ajax())
        {
            $now=Carbon::now();
            $now->addDays(2);
            //$f_inicio=Formacion::find();
            $user=Auth::user();
            //esto es en caso del que proveedor matricule, si solo control de estudio matricula es mas sencillo, se elimina la parte de la requisicion
            $em_id=$user->empresa->first()->id;
            $r=Requisicion::where('empresa_id',$em_id);
            //
            return datatables()->of(Requisicion::where('empresa_id',$em_id)->join('formacions','requisicions.id','=','formacions.requisicion_id')->where('status','con postulados')->where('t_facilitador',0)->where('disponibilidad',1)->where('tipo','externa')->whereDate('fecha_de_inicio','<=',$now)->select('formacions.id as id','formacions.nombre','formacions.actual_matricula','formacions.fecha_de_inicio'))
            ->addColumn('action', function($data){
                $button = '<button type="button" name="edit" id="btn_edit_p" data-id="'.$data->id.'" class="examinar btn btn-info btn-sm"><i class="fas fa-search"></i></button>';

                $button .= '<button type="button" name="delete" id ="btn_enroll"    data-id="'.$data->id.'" class="btn-matricular btn btn-success btn-sm"><i class="fas fa-address-book"  style="margin-right: 0.5rem;" ></i>Ver</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->toJson();

        }

        return view('proveedor.pro_matricular');
    }




    public function facilitador_show()
    {
        $user=Auth::user();
        if(request()->ajax())
        {

            $roles = Role::findByName('Facilitador');
            $roles_us=$roles->users;
            $em_id=$user->empresa->first()->id;//ojo
            $usuarios=Empresa::find($em_id)->users;
            $q=$roles_us->intersect($usuarios);
            //para realizar la consulta mas apropia y dadeterminar los facilitadores optimos en esta tabla, es necesario datos de otro modulo que lamentablemente no esta operativo...(y ya me canse de hacer funcionalidades de otros modulos)
            //por ello se reaiza esta consulta mas "general" donde se obtienen solo los facilitadores de la empresa de quien esta matriculando

            return datatables()->of($q)->addColumn('action', function($data){
                $button = '<button type="button" name="edit"  data-id="'.$data->id.'" class="examinar btn btn-info btn-sm"><i class="fas fa-search"></i></button>';

                return $button;
            })
            ->rawColumns(['action'])
            ->toJson();

        }


    }






    public function external_enroll_file(&$m,&$i,$candidatos,$rol,$form_id) //otro metodo no usado de momento
    {
        foreach ($candidatos as $key => $value) {
            $user=Auth::user()->find($value->user_id);

            $m[$i][0]=$user->ci;
            $m[$i][1]=$user->name;
            $m[$i][2]=$user->email;
            $m[$i][3]=$rol;
            $i++;

            if ($rol==='Estudiante') {
                //$estu=Auth::user()->find($value->user_id);
                $user->assignRole('Estudiante');

                //crear un nuevo registro en el expediente del estudiante
                $exp= new Expediente_usuario;
                $exp->user_id=$value->user_id;
                $exp->formacion_id=$form_id;
                $s_id=User_ins_formacion::where('user_id',$value->user_id)->first()->supervisor_id;
                $exp->supervisor_id=$s_id;
                $exp->save();
            }

        }
    }

    public function external_enroll($candidatos,$rol,$form_id,$emp_id) //
    {
        foreach ($candidatos as $key => $value) {
            $user=Auth::user()->find($value->user_id);

            Matricula_externa::create([ //se inserta
                'empresa_id' => $emp_id,
                'user_id' => $value->user_id,
                'formacion_id' =>$form_id,
                'ci'=>$user->ci,
                'nombre'=>$user->name,
                'email'=>$user->email,
                'rol_shortname' => $rol,


            ]);

            if ($rol==='Estudiante') {
                //$estu=Auth::user()->find($value->user_id);
                $user->assignRole('Estudiante');

                //crear un nuevo registro en el expediente del estudiante
                $exp= new Expediente_usuario;
                $exp->user_id=$value->user_id;
                $exp->formacion_id=$form_id;
                $s_id=User_ins_formacion::where('user_id',$value->user_id)->first()->supervisor_id;
                $exp->supervisor_id=$s_id;
                $exp->save();
            }

        }
    }


    public function enroll($postulados,$rol,$form_id,$emp_id)
    {
        foreach ($postulados as $key => $value) {

                Mdl_inscripcion::create([ //se inserta
                    'empresa_id' => $emp_id,
                    'user_id' => $value->user_id,
                    'formacion_id' =>$form_id,
                    'rol_shortname' => $rol,

                ]);
                //otorgar permisos en la uvc de esto se encargaria TI pero...

                //se le otorga el rol de estudiante y se crea el expediente
                if ($rol=='student') {
                    $estu=Auth::user()->find($value->user_id);
                    $estu->assignRole('Estudiante');

                    //crear un nuevo registro en el expediente del estudiante
                    $exp= new Expediente_usuario;
                    $exp->user_id=$value->user_id;
                    $exp->formacion_id=$form_id;
                    $s_id=User_ins_formacion::where('user_id',$value->user_id)->first()->supervisor_id;
                    $exp->supervisor_id=$s_id;
                    $exp->save();
                }
                //
                if ($rol=='teacher') {
                    $estu=Auth::user()->find($value->user_id);
                    $estu->assignRole('Facilitador');
                }
                //
                if ($rol=='supervisor') {
                    $estu=Auth::user()->find($value->user_id);
                    $estu->assignRole('Supervisor');
                }


        }
    }


    public function verifica_facilitador($postulados,$facilitadores,&$a_error)
    {

        foreach ($facilitadores as $key => $fa) {

            foreach ($postulados as $key => $post) {
                if ($post->user_id===$fa->user_id) {
                    $a_error[0]['status']=500;
                    $a_error[1]['msj']='El facilitador: '.$fa->name.' '.$fa->ci.',  YA esta inscrito como estudiante para esta Formacion, recuerde que un estudiante NO puede tener el rol de Facilitador para el mismo curso';
                    return(false);

                }
            }
        }

        return(true);
    }


    public function enrolling(Request $request)
    {

        if(request()->ajax())
        {
            $tipo=Formacion::find($request->f_id)->tipo;

            $array_e=[];
            $array_e[]=['status'=>200];
            $array_e[]= ['msj'=>'Matriculacion completada con exito'];

            $postulados=User_ins_formacion::where('formacion_id',$request->f_id)->select('user_id')->get();

            $supervisores=User::join('user_ins_formacions','user_ins_formacions.supervisor_id','=','id')->select('id as user_id','formacion_id')->where('formacion_id',$request->f_id)->distinct()->get();


            $facilitadores=User::whereIn('id', $request->id)->select('id as user_id','name','ci')->get();


            $id_responsable=User_ins_formacion::where('formacion_id',$request->f_id)->first();

            $user=Auth::user()->find($id_responsable->rp_id);

            $em_id=$user->empresa->first()->id;

            $responsable_personal=Usuario_p_empresa::where('empresa_id',$em_id)->join('model_has_roles','model_id','=','usuario_p_empresas.user_id')->where('model_has_roles.role_id',2)->select('user_id')->get();// 2 es el rol de rp


            if ($this->verifica_facilitador($postulados,$facilitadores,$array_e)) {
                if ($tipo==='interna') {
                    $this->enroll($postulados,'student',$request->f_id,$em_id);
                    $this->enroll($supervisores,'supervisor',$request->f_id,$em_id);
                    $this->enroll($facilitadores,'teacher',$request->f_id,$em_id);
                    $this->enroll($responsable_personal,'rpcurso',$request->f_id,$em_id);
                }else {

                    $this->external_enroll($postulados,'Estudiante',$request->f_id,$em_id);
                    $this->external_enroll($supervisores,'Supervisor',$request->f_id,$em_id);
                    $this->external_enroll($facilitadores,'Facilitador',$request->f_id,$em_id);
                    $this->external_enroll($responsable_personal,'Responsable de Personal',$request->f_id,$em_id);
                    /*version de archivo no usado
                    $archivo[0][0]='CI ';
                    $archivo[0][1]='Nombre  ';
                    $archivo[0][2]='Correo';
                    $archivo[0][3]='Rol';
                    $i=1;

                    $this->external_enroll_file($archivo,$i,$postulados,'Estudiante',$request->f_id);
                    $this->external_enroll_file($archivo,$i,$supervisores,'Supervisor',$request->f_id);
                    $this->external_enroll_file($archivo,$i,$facilitadores,'Facilitador',$request->f_id);
                    $this->external_enrol_file($archivo,$i,$responsable_personal,'Responsable de Personal',$request->f_id);

                    $n_archivo=$em_id.'_'.$request->f_id.'_Matricula.xlsx';
                    Excel::store(new External_Enrolling_Export($archivo), $n_archivo,'matriculas');
                    //$n_archivo=$em_id.'_'.$request->f_id.'_Matricula.csv';
                    //Excel::store(new External_Enrolling_Export($archivo), $n_archivo,'matriculas');
                    */

                }


             }else{
                 return response()->json( $array_e);
             }

             $f=Formacion::find($request->f_id); //comentada por pruebas si funciona
             $f->status='matriculada';
             $f->save();
            return response()->json( $array_e);
        }

    }


//proveedor
    public function formaciones_externas(Request $request){//OJO PENDIENTE DE MODIFICAR QUERY
       /* $result=User_ins_formacion::all();
        return view('proveedor.pro_download_matricula')->with('results', $result);*/
        if(request()->ajax())
        {
            //modificar esta consulta
            $user=Auth::user();
            $em_id=$user->empresa->first()->id;

            $r=Requisicion::where('empresa_id',$em_id);

            return datatables()->of(Requisicion::where('empresa_id',$em_id)->join('formacions','requisicions.id','=','formacions.requisicion_id')->where('status','matriculada')->where('disponibilidad',1)->where('tipo','externa')->select('formacions.id as id','formacions.imagen','formacions.nombre as nombre','formacions.fecha_de_inicio'))
            ->addColumn('action', function($data){
                $button = '<button type="button"  id ="btn_ver_m" name="btn_ver" data-nf="'.$data->nombre.'" data-id="'.$data->id.'" class="examinar btn btn-morado btn-sm"><i class="fas fa-eye" style="margin-right: 0.5rem;"></i>ver</button>';

                return $button;


            })
            ->rawColumns(['action'])
            ->toJson();

        }

        return view('proveedor.pro_download_matricula');


    }

//proveedor
    public function show_external_enroll(Request $request)
    {

        if(request()->ajax())
        {


            return datatables()->of(Matricula_externa::where('formacion_id',$request->fid))->toJson();
        }


    }

//ver la matricula de una formacion como facilitador
    public function show_matricula_formacion(Request $request)
    {

        if(request()->ajax())
        {
            return datatables()->of(User_ins_formacion::where('formacion_id',$request->fid)->join('users','users.id','=','user_ins_formacions.user_id'))->toJson();
        }


    }



    //facilitador
    public function show_formaciones_facilitador(Request $request){

         if(request()->ajax())
         {
            $idf=[];
            $user=Auth::user();

            $q1=Matricula_externa::where('user_id',$user->id)->where('rol_shortname','Facilitador')->select('formacion_id')->get();

            $q2=Mdl_inscripcion::where('user_id',$user->id)->where('rol_shortname','teacher')->select('formacion_id')->get();

           // dump($q1);
            foreach ($q1 as $key => $value) {

                $idf[]=$value->formacion_id;

            }
            foreach ($q2 as $key => $value) {

                $idf[]=$value->formacion_id;

            }

            $qw = DB::table('formacions as tblf')->join('requisicions as tblr', 'tblf.requisicion_id', '=', 'tblr.id')->whereIn('tblf.id',$idf)->join('empresas as tblm','tblr.empresa_id','=','tblm.id')->select('tblf.id as id','tblf.imagen as imagen','tblf.nombre as nombre_formacion','tblm.nombre as nombre_empresa')->get();

            //$q=Formacion::whereIn('id',$idf)->get();

             return datatables()->of($qw)
             ->addColumn('action', function($data){
                 $button = '<button type="button"  id ="btn_ver_m" name="btn_ver" data-nf="'.$data->nombre_formacion.'"   data-id="'.$data->id.'" class="examinar btn btn-morado btn-sm"><i class="fas fa-eye" style="margin-right: 0.5rem;"></i>ver</button>';

                 return $button;


             })
             ->rawColumns(['action'])
             ->toJson();

         }

         return view('facilitador.fac_download_matricula');


     }






    public function pruebas(Request $request)
    {
        $idf=[];
        $user=Auth::user();


        $data=DB::table('certificados_f_estudiantes')->where('user_id',$user->id)->where('formacion_id',4)->join('users as tbl_user','certificados_f_estudiantes.user_id','=','tbl_user.id')->join('formacions as tbl_f','certificados_f_estudiantes.formacion_id','=','tbl_f.id')->select('tbl_user.name','certificados_f_estudiantes.codigo_certificado','tbl_f.nombre','tbl_f.empresa_proveedora_id','tbl_f.fecha_de_inicio','tbl_f.fecha_de_culminacion','tbl_user.ci')->get();

       // dump($data);
        //dump($q[0]['nombre']);

        return view('estudiante.vista_certificado',compact('data'));


        /*$q=Expediente_usuario::where('user_id',1)->where('formacion_id',4)->first();
        $q->califico_formacion=2;
            $q->califico_facilitador=3;
            $q->save();*/
        //dump();

        //$cf=$q->califico_formacion+1;
        //dump($cf);
        /*$q1=Matricula_externa::where('user_id',$user->id)->where('rol_shortname','Facilitador')->select('formacion_id')->get();

        $q2=Mdl_inscripcion::where('user_id',$user->id)->where('rol_shortname','teacher')->select('formacion_id')->get();

       // dump($q1);
        foreach ($q1 as $key => $value) {

            $idf[]=$value->formacion_id;

        }
        foreach ($q2 as $key => $value) {

            $idf[]=$value->formacion_id;

        }

        $qw = DB::table('formacions as tblf')->join('requisicions as tblr', 'tblf.requisicion_id', '=', 'tblr.id')->whereIn('tblf.id',$idf)->join('empresas as tblm','tblr.empresa_id','=','tblm.id')->select('tblf.imagen as imagen','tblf.nombre as nombre','tblm.nombre as nombre_empresa')->get();

        $q=Formacion::whereIn('id',$idf)->get();


        dump($qw);
        $q=User_ins_formacion::where('formacion_id',3)->join('users','users.id','=','user_ins_formacions.user_id')->get();*/


        //$tipo=Formacion::find(3)->tipo;
        //dump($tipo);
        /*$now=Carbon::now();
        $now->addDays(3);
        $user=Auth::user();
        $em_id=$user->empresa->first()->id;
        dump(Requisicion::where('empresa_id',$em_id)->join('formacions','requisicions.id','=','formacions.requisicion_id')->where('status','con postulados')->where('t_facilitador',0)->where('disponibilidad',1)->where('tipo','externa')->whereDate('fecha_de_inicio','<=',$now)->get());*/
        //$empresa_id=Formacion::find(2)->requisicion_id;
        //dump();
        //->whereDate('created_at', '2016-12-31')

       /* $postulados=User_ins_formacion::where('formacion_id',2)->get();

        $supervisores=User::join('user_ins_formacions','user_ins_formacions.supervisor_id','=','id')->select('id as user_id')->where('formacion_id',2)->distinct()->get();
        $facilitadores=User::whereIn('id', $idt)->select('id as user_id','name','ci')->get();
        $id=User_ins_formacion::where('formacion_id',2)->first();
        $user=Auth::user()->find($id->rp_id);
        $em_id=$user->empresa->first()->id;
        $rp=Usuario_p_empresa::where('empresa_id',$em_id)->join('model_has_roles','model_id','=','usuario_p_empresas.user_id')->where('model_has_roles.role_id',2)->get();


        $archivo[0][0]='CI ';
        $archivo[0][1]='Nombre  ';
        $archivo[0][2]='Correo';
        $archivo[0][3]='Rol';
        $i=1;
        $j=0;
       foreach ($postulados as $key => $value) {
            $user=Auth::user()->find($value->user_id);

            $archivo[$i][0]=$user->ci;
            $archivo[$i][1]=$user->name;
            $archivo[$i][2]=$user->email;
            $archivo[$i][3]='Estudiante';
            $i++;

        }
        dump($archivo);*/






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
     * @param  \App\Mdl_inscripcion  $mdl_inscripcion
     * @return \Illuminate\Http\Response
     */
    public function show(Mdl_inscripcion $mdl_inscripcion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mdl_inscripcion  $mdl_inscripcion
     * @return \Illuminate\Http\Response
     */
    public function edit(Mdl_inscripcion $mdl_inscripcion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mdl_inscripcion  $mdl_inscripcion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mdl_inscripcion $mdl_inscripcion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mdl_inscripcion  $mdl_inscripcion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mdl_inscripcion $mdl_inscripcion)
    {
        //
    }
}
