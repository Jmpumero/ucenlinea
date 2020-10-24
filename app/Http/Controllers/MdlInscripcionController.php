<?php

namespace App\Http\Controllers;

use Validator;
use App\Empresa;
use App\Formacion;
use Carbon\Carbon;
use App\Requisicion;
use App\Motivo_retiro;
use App\Mdl_inscripcion;
use App\Facilitador_temp;

use App\Marco_regulatorio;
use App\Matricula_externa;
use App\Usuario_p_empresa;
use App\Expediente_usuario;
use App\User_ins_formacion;
use App\Imports\ActasImport;
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
            return datatables()->of(Formacion::where('status','con postulados')->where('t_facilitador',0)->where('disponibilidad',1)->whereDate('fecha_de_inicio','<',$now))->addColumn('action', function($data){
                $button = '<button type="button" name="edit" id="btn_edit_p" data-id="'.$data->id.'" class="examinar btn btn-info btn-sm"><i class="fas fa-search"></i></button>';

                $button .= '<button type="button" name="delete" id ="btn_enroll"    data-id="'.$data->id.'" class="btn-matricular btn btn-success btn-sm"><i class="fas fa-address-book"  style="margin-right: 0.5rem;" ></i>Matricular</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->toJson();

        }

        return view('responsable_control_de_estudio.rce_matricular');
    }



    //OJO en desuso por eliminar
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
            return datatables()->of(Requisicion::where('empresa_id',$em_id)->join('formacions','requisicions.id','=','formacions.requisicion_id')->where('status','con postulados')->where('t_facilitador',0)->where('disponibilidad',1)->whereDate('fecha_de_inicio','<=',$now)->select('formacions.id as id','formacions.nombre','formacions.actual_matricula','formacions.fecha_de_inicio'))
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
            //para realizar la consulta mas apropia y adeterminar los facilitadores optimos en esta tabla, es necesario datos de otro modulo que lamentablemente no esta operativo...(y ya me fastidie de hacer funcionalidades de otros modulos)
            //por ello se reaiza esta consulta mas "general" donde se obtienen solo los facilitadores de la empresa de quien esta matriculando
            $q=Facilitador_temp::join('users','users.id','=','facilitador_id');

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

    public function external_enroll($candidatos,$rol,$form_id) //no usada
    {
        foreach ($candidatos as $key => $value) {
            $user=Auth::user()->find($value->user_id);

            Matricula_externa::create([ //se inserta
                //'empresa_id' => $emp_id,
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


    public function enroll($postulados,$rol,$form_id)
    {
        foreach ($postulados as $key => $value) {

                Mdl_inscripcion::create([ //se inserta
                    ///'empresa_id' => $emp_id,
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


    public function libre_enroll(Request $request)
    {
        if(request()->ajax())
        {
            $user=Auth::user();

            if (!(Mdl_inscripcion::where('user_id',$user->id)->where('formacion_id',$request->form_id)->exists())) {
                Mdl_inscripcion::create([ //se inserta
                    ///'empresa_id' => $emp_id,
                    'user_id' => $user->id,
                    'formacion_id' =>$request->form_id,
                    'rol_shortname' => 'student',

                ]);

                //crear un nuevo registro en el expediente del estudiante
                $exp= new Expediente_usuario;
                $exp->user_id=$user->id;
                $exp->formacion_id=$request->form_id;
                //$s_id=User_ins_formacion::where('user_id',$value->user_id)->first()->supervisor_id;
                //$exp->supervisor_id=$s_id; en este caso no se coloca supervisor
                $exp->save();
            }

        }else {
            return redirect('/home');
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
                //if ($tipo==='interna') {
                    $this->enroll($postulados,'student',$request->f_id);
                    $this->enroll($supervisores,'supervisor',$request->f_id);
                    $this->enroll($facilitadores,'teacher',$request->f_id);
                    $this->enroll($responsable_personal,'rpcurso',$request->f_id);
                //}else {

                   /* $this->external_enroll($postulados,'Estudiante',$request->f_id);
                    $this->external_enroll($supervisores,'Supervisor',$request->f_id);
                    $this->external_enroll($facilitadores,'Facilitador',$request->f_id);
                    $this->external_enroll($responsable_personal,'Responsable de Personal',$request->f_id);*/

               // }


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


            return datatables()->of(Mdl_inscripcion::where('formacion_id',$request->fid))->toJson();
        }


    }

    /** FACILITADOR  */
//ver la matricula de una formacion como facilitador
    public function show_matricula_formacion(Request $request)
    {

        if(request()->ajax())
        {
            return datatables()->of(Expediente_usuario::where('formacion_id',$request->fid)->join('users as tbl_us','tbl_us.id','=','expediente_usuarios.user_id')->where('expediente_usuarios.status','Cursando'))->toJson();
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

            $qw = DB::table('formacions as tblf')->join('requisicions as tblr', 'tblf.requisicion_id', '=', 'tblr.id')->whereIn('tblf.id',$idf)->where('tblf.status','matriculada')->join('empresas as tblm','tblr.empresa_id','=','tblm.id')->select('tblf.id as id','tblf.imagen as imagen','tblf.nombre as nombre_formacion','tblm.nombre as nombre_empresa')->get();

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




     /*facilitador*/
    public function show_cargar_acta_facilitador(Request $request){

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

        // $fn=Carbon::parse(Formacion::find(2)->fecha_de_inicio);
        //$d=$fn->addDay(1);
        $now=Carbon::now();
        $now=$now->subDay(1);
        $qw = DB::table('formacions as tblf')->join('requisicions as tblr', 'tblf.requisicion_id', '=', 'tblr.id')->whereIn('tblf.id',$idf)->where('fecha_de_inicio','<',$now)->where('tblf.status','matriculada')->join('empresas as tblm','tblr.empresa_id','=','tblm.id')->select('tblf.id as id','tblf.imagen as imagen','tblf.nombre as nombre_formacion','tblm.nombre as nombre_empresa')->get();

        //$q=Formacion::whereIn('id',$idf)->get();

            return datatables()->of($qw)
            ->addColumn('action', function($data){
                $button = '<button type="button"  id ="btn_cargar" name="btn_ver" data-nf="'.$data->nombre_formacion.'"   data-id="'.$data->id.'" class="examinar btn btn-morado  "><i class="fas fa-file-import fa-lg" style="margin-right: 0.5rem;"></i> Cargar</button>';

                return $button;


            })
            ->rawColumns(['action'])
            ->toJson();

        }

        return view('facilitador.fac_cargar_acta');


    }



    public function generate_string($input, $strength ) {
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }


    public function certificado ($ci,$user_id,$form_id)
    {
        $empre_r=Formacion::find($form_id)->empresa_proveedora_id;
        $cadena=$ci;
        $cadena=$this->generate_string($cadena,7);
        $codigo=$user_id.$cadena.$form_id;

        if (!(Certificados_f_estudiante::where('user_id',$user_id)->where('formacion_id',$form_id)->exists())) {
            $cert= new Certificados_f_estudiante;
            $cert->codigo_certificado=$codigo;
            $cert->user_id=$user_id;
            $cert->formacion_id=$form_id;
            $cert->empresa_res_id=$empre_r;
            $cert->save();
        }

    }

    /* facilitador*/
    public function validacion_est($est,$form_id,&$errores){

        $ci_est=$est['ci'];
        $nota_est=$est['nota'];
        //$ci_est='gg123';
        //$id_est=User::firstWhere('ci',$ci_est)->exists();

        if (User::firstWhere('ci',$ci_est)!=null) {
            $id_est=User::firstWhere('ci',$ci_est)->id;

            if (Expediente_usuario::where('user_id',$id_est)->where('formacion_id',$form_id)->exists()) {


                    if ($nota_est<5) {
                        Expediente_usuario::where('user_id',$id_est)->where('formacion_id',$form_id) ->update(['status' => 'Abandonada']);
                    }else{
                        if ($nota_est>=9.5) {
                            Expediente_usuario::where('user_id',$id_est)->where('formacion_id',$form_id) ->update(['status' => 'Finalizada','calificacion_obtenida'=>$nota_est]);
                            // el certificado;
                            $this->certificado ($ci_est,$id_est,$form_id);

                        }

                        if (($nota_est>=5)AND($nota_est<9.5)) {
                            Expediente_usuario::where('user_id',$id_est)->where('formacion_id',$form_id) ->update(['status' => 'Finalizada','calificacion_obtenida'=>$nota_est]);
                            //dump('reprobado '.$ci_est);
                        }

                    }

            }else{
                $errores[0]['status']=500;
                array_push ( $errores[1]['errores'] , 'El estudiante  CI: '.$ci_est .' NO pertenece a la formacion selecionada, verifique el documento'  );
                //dump($array_e);
                return response()->json( $errores);
            }

        }else{
            $errores[0]['status']=500;
            array_push ( $errores[1]['errores'] , 'La CI: '.$ci_est .' NO existe en el sistema verifique el documento'  );
            //dump($array_e);
            return response()->json( $errores);
        }

    }

    //facilitador pendiente de mas pruebas
    public function import_acta_excel(Request $request)
    {
        if ($request->ajax()) {

            $array_e=[];
            $array_e[]=['status'=>200];
            $array_e[]= ['errores'=>[]];
            $array_e[]=['cont_e'=>0];

            //**validacion del archivo */
            $messages = [  'archivo.extension' => 'El documento debe ser un archivo Excel' ];
            $error= Validator::make(
                [
                    'file'      => $request->file('archivo'),
                    'extension' => strtolower($request->file('archivo')->getClientOriginalExtension()),
                ],
                [
                    'file'          => 'required',
                    'extension'      => 'required|in:xlsx,xls,odt,ods',
                ],
                $messages
                );
                if($error->fails())
                {
                $array_e[0]['status']=260;
                array_push ( $array_e[1]['errores'] , 'El documento debe ser un archivo Excel .xlsx'  );
                return response()->json( $array_e);

                }

            $acta= Excel::toArray(new ActasImport,  request()->file('archivo'));
            $encabezado=[];
            $notas=[];
            $p;
            $i=0;
            foreach ($acta as $key => $value) {
                foreach ($value as $key2 => $value2) {

                    if (count($value2)>3) {
                        if ($i==1) {
                            $encabezado= $value2;
                        }
                        if ($i>1) {
                            if ((is_numeric($value2[3]))AND ((((float)$value2[3])>=0)AND (((float)$value2[3])<=20))) {
                                //dump($value2[3]);

                                $notas[]=['ci'=>$value2[0],'nota' => (float)$value2[3]];
                            }else{
                                $array_e[0]['status']=500;
                                array_push ( $array_e[1]['errores'] , 'El estudiante  CI: '.$value2[0] .' NO tiene una calificacion valida, verifique el documento'  );
                                return response()->json( $array_e);
                            }
                        }
                    }else{
                        $array_e[0]['status']=500;
                        array_push ( $array_e[1]['errores'] , 'El documento no presenta el formato adecuado (formato de matricula)'  );
                        return response()->json( $array_e);
                    }
                    $i++;

                }

            }

            if (($encabezado[0]=='CI')AND($encabezado[1]=='Nombre')AND($encabezado[2]=='Correo')AND ($encabezado[3]=='Calificacion')) {

                foreach ($notas as $key => $value) {
                    if ($array_e[0]['status']==200) {
                        $this->validacion_est($value,$request->f_id,$array_e);
                    }else{
                        return response()->json( $array_e);
                    }

                }
            }else{
                $array_e[0]['status']=500;
                array_push ( $array_e[1]['errores'] , 'El documento no presenta el formato adecuado (formato de matricula)'  );
                //dump($array_e);
                return response()->json( $array_e);
            }

                if ($array_e[0]['status']==200) {
                    $forma=Formacion::find($request->f_id);
                    $forma->status='finalizada';
                    $forma->save();
                }
                return response()->json( $array_e);
        }


    }



    //supervisor
    public function show_formaciones_supervisor(Request $request){

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

           $qw = DB::table('formacions as tblf')->join('requisicions as tblr', 'tblf.requisicion_id', '=', 'tblr.id')->whereIn('tblf.id',$idf)->where('tblf.status','matriculada')->join('empresas as tblm','tblr.empresa_id','=','tblm.id')->select('tblf.id as id','tblf.imagen as imagen','tblf.nombre as nombre_formacion','tblm.nombre as nombre_empresa')->get();

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




    /*facilitador*/







    public function pruebas(Request $request)
    {

        $user=Auth::user();
        $roles = Role::findByName('Estudiante');
        $roles_us=$roles->users;
        $em_id=$user->empresa->first()->id;//ojo
        $usuarios=Empresa::find($em_id)->users;
        $q=$roles_us->intersect($usuarios);
        $now=Carbon::now();
        $nom='CV Josem.pdf';


        $qw = DB::table('formacions as tbl_f')->where('tbl_f.publicar',1)->join('empresas as tbl_em','tbl_em.id','=','tbl_f.empresa_proveedora_id')->select('tbl_f.nombre','tbl_f.imagen','tbl_f.f_resumen','tbl_f.formacion_libre','tbl_f.precio','tbl_f.fecha_de_inicio','tbl_em.nombre as nombre_empresa')->get();

        dump($qw);
    }
       /* $idf=[];
        $user=Auth::user();


        $now=Carbon::now('-4:00');
        $now->addDays(2); //fecha limite 3 dias antes del inicio
        $em_id=$user->empresa->first()->id;

        $r=Requisicion::where('empresa_id',$em_id);
        $formaciones_list=$r->join('formacions','requisicions.id','=','formacions.requisicion_id')->where('status','sin postulados')->where('disponibilidad',1)->where('fecha_de_inicio','>',$now)->get()->pluck('nombre','id');



        $q1=DB::table('requisicions as tbl_r')->where('tbl_r.empresa_id',$em_id)->join('formacions as tbl_f','tbl_r.id','=','tbl_f.requisicion_id')->where('tbl_f.status','sin postulados')->where('tbl_f.disponibilidad',1)->where('tbl_f.fecha_de_inicio','>',$now)->select('tbl_f.id as formacion_id','tbl_f.nombre as nombre')->get();

        $q2=DB::table('requisicions as tbl_r')->where('tbl_r.empresa_id',$em_id)->join('formacions as tbl_f','tbl_r.id','=','tbl_f.requisicion_id')->where('tbl_f.status','con postulados')->where('tbl_f.disponibilidad',1)->where('tbl_f.fecha_de_inicio','>',$now)->select('tbl_f.id as formacion_id','tbl_f.nombre as nombre')->get();

        foreach ($q1 as $key => $value) {

            $idf[]=$value->formacion_id;

        }
        foreach ($q2 as $key => $value) {

            $idf[]=$value->formacion_id;

        }

        $q3=Formacion::whereIn('id',$idf)->get()->pluck('nombre','id');*/
        //dump($formaciones_list);
        //dump($q3);


        //$fn=Formacion::find(2)->fecha_de_inicio;
        //$fn=Carbon::now(Formacion::find(2)->fecha_de_inicio);
        //$fn=Carbon::parse(Formacion::find(2)->fecha_de_inicio);
        /* $now=Carbon::now();
        $now=$now->subDay(1);
        $qw = DB::table('formacions as tblf')->join('requisicions as tblr', 'tblf.requisicion_id', '=', 'tblr.id')->whereIn('tblf.id',$idf)->where('fecha_de_inicio','<',$now)->where('tblf.status','matriculada')->join('empresas as tblm','tblr.empresa_id','=','tblm.id')->select('tblf.id as id','tblf.imagen as imagen','tblf.nombre as nombre_formacion','tblm.nombre as nombre_empresa')->get();
        dump($qw);*/






}
