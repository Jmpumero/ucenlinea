<?php

namespace App\Http\Controllers;
//import chromelogger as console;
//include 'ChromePhp.php';
use App\User;
use Validator;
use App\Empresa;
use App\Formacion;
use Carbon\Carbon;
use App\Requisicion;
use App\User_p_empresa;
use App\Expediente_usuario;
use App\User_ins_formacion;
use App\Imports\ActasImport;
use Illuminate\Http\Request;
use App\CustomClass\CedulaVE;
use  App\Exports\ErroresExport;
use Maatwebsite\Excel\Importer;
use App\Imports\PostuladosImport;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use  App\Exports\ErroresvistaExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;


class UserInsFormacionController extends Controller
{
    public $prueba=null;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $user=Auth::user();
        if ($user->hasPermissionTo('inscribir estudiantes en formacion')) {
            //falta un condicional especial para el rol admin y super-admin
            $now=Carbon::now('-4:00'); // como se cambio la variable  'timezone' =>'America/Caracas' ya no es necesario hacer esta inicializacion bastaria con usar Carbon::now()
            $now->addDays(2); //fecha limite 3 dias antes del inicio
            $em_id=$user->empresa->first()->id; //un problema aqui es si el usuario no esta asociado a ninguna empresa, se supone que ese caso no deberia ocurrir ya que todo usuario dentro del sistema pertenece a una empresa
            $idf=[];
            //bueno esto es ineficiente pero sirve....y es mas facil de leer
            $q1=DB::table('requisicions as tbl_r')->where('tbl_r.empresa_id',$em_id)->join('formacions as tbl_f','tbl_r.id','=','tbl_f.requisicion_id')->where('tbl_f.status','sin postulados')->where('tbl_f.disponibilidad',1)->where('tbl_f.fecha_de_inicio','>',$now)->select('tbl_f.id as formacion_id','tbl_f.nombre as nombre')->get();

            $q2=DB::table('requisicions as tbl_r')->where('tbl_r.empresa_id',$em_id)->join('formacions as tbl_f','tbl_r.id','=','tbl_f.requisicion_id')->where('tbl_f.status','con postulados')->where('tbl_f.disponibilidad',1)->where('tbl_f.fecha_de_inicio','>',$now)->select('tbl_f.id as formacion_id','tbl_f.nombre as nombre')->get();

            foreach ($q1 as $key => $value) {

                $idf[]=$value->formacion_id;

            }
            foreach ($q2 as $key => $value) {

                $idf[]=$value->formacion_id;

            }

            $formaciones_list=Formacion::whereIn('id',$idf)->get()->pluck('nombre','id');

            return view('responsable_de_personal.inscripcion',['formaciones_list'=>$formaciones_list]);
        }



    }

    public function select_usuarios(Request $request) //select con ajax borrar añ final no se usa
    {
        /*$term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }*/

        //$tags = Tag::search($term)->limit(5)->get();
        //falta hacer el search
            $user=Auth::user();

            if ($user->hasPermissionTo('inscribir estudiantes en formacion')) {

                $em_id=$user->empresa->first()->id;
                $usuarios=Empresa::find($em_id)->users;

                foreach ($usuarios as $u) {
                    $nombre=$u->name;
                    $users_array[] = ['id' => $u->id, 'text' => $u->ci.' -> '.$nombre];

                }

                return response()->json($users_array);

        }



        /*$formaciones = Formacion::all();
        $formaciones_array = [];



        return response()->json($formaciones_array);*/



    }

    public function users_show()
    {
        $user=Auth::user();
        if(request()->ajax())
        {

            //$t=json_encode($f);
            /*$q3=User_ins_formacion::where('formacion_id',$id)->join('users as tbl1','tbl1.id','=','user_ins_formacions.user_id')->join('users as tbl2','tbl2.id','=','user_ins_formacions.supervisor_id')->select('tbl1.ci','tbl1.name','tbl1.email','tbl2.name as supervisor');*/

            $em_id=$user->empresa->first()->id;
            $usuarios=Empresa::find($em_id)->users;
            return datatables()->of($usuarios)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="postulado" id="btn_select_p" data-id="'.$data->id.'" class="inscribir btn  btn-outline-success btn-sm"><i class="fas fa-check"></i></button>';


                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->toJson();
        }

       // $em_id=$user->empresa->first()->id;
        //$usuarios=Empresa::find($em_id)->users->dump();


    }


    public function sup_show()
    {
        $user=Auth::user();
        if(request()->ajax())
        {
            $roles = Role::findByName('Supervisor');
            $roles_us=$roles->users;
            $em_id=$user->empresa->first()->id;//ojo
            $usuarios=Empresa::find($em_id)->users;
            $q=$roles_us->intersect($usuarios);

            return datatables()->of($q)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="s_up" id="btn_select_sup" data-id="'.$data->id.'" class="inscribir btn  btn-outline-success btn-sm"><i class="fas fa-check"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->toJson();
        }

        $roles = Role::findByName('Supervisor');
        $roles_us=$roles->users;

        $em_id=$user->empresa->first()->id;
        $usuarios=Empresa::find($em_id)->users;
        $r=$roles_us->intersect($usuarios);
        //$super_v=$roles_us->join();


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
        $user=Auth::user();

        if ($request->ajax()) {


            if ((($request->id_user!=null)and ($request->id_sp!=null))and($request->idf!=null))
            {


                $formacion=Formacion::find($request->idf);
                $matricula_max=$formacion->max_matricula;
                $matricula_actual=$formacion->actual_matricula;

                if (User_ins_formacion::where('user_id', $request->id_user)->where('formacion_id',$request->idf)->exists()) {

                    return response()->json(['error' => 'El postulado ya se encuentra registrado en la formacion']);
                }

                if ($request->id_user==$request->id_sp) {
                    return response()->json(['error' => 'El postulado no puede ser su propio supervisor']);
                }

                if ($matricula_max>$matricula_actual)
                {
                    $nuevo =new User_ins_formacion;
                    $nuevo->user_id=$request->id_user;
                    $nuevo->formacion_id=$request->idf;
                    $nuevo->supervisor_id=$request->id_sp;
                    $nuevo->rp_id=$user->id;
                    $nuevo->save();

                    $matricula_actual++;
                    $formacion->actual_matricula=$matricula_actual;
                    if ($formacion->status==='sin postulados') {
                        $formacion->status='con postulados';
                    }

                    $formacion->save();

                }else{
                    return response()->json(['error' => 'Formacion llena']);
                }

            }

            return response()->json(['success' => 'Estudiante añadido a la formacion']);

        }else {
            return redirect()->back()->withInput();



        }
    }


    public function import_excel(Request $request,$id)
    {
        if ($request->ajax()) {

            //validacion de permisos pendiente
            $array_e=[];
            $array_e[]=['status'=>0];
            $array_e[]= ['errores'=>[]];
            $array_e[]=['cont_e'=>0];
            $m_e;
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
              ///** */
            $cont_error=0;
            //$postulados = Excel::toArray(new PostuladosImport,  request()->file('archivo'));
        /**se buscan los encbezados*/
            $postulados = Excel::toArray(new PostuladosImport,  request()->file('archivo'));
            $encabezados=[];
            foreach ($postulados as $key => $value) { //ineficiente pero seguro para obtener todas las posibles claves presente
                foreach ($value as $key2 => $value2) {
                    foreach ($value2 as $key3 => $value3) {
                        $encabezados[]=$key3;
                    }
                    break 2;
                }
            }//se validan los encabezados
            if (strcasecmp('postulado',$encabezados[0])!=0) {

                $array_e[0]['status']=250;
                $array_e[2]['cont_e']++;
                array_push ( $array_e[1]['errores'] , 'Error: No se encontro la columna Postulado'  );

            }else{
                if (strcasecmp('supervisor',$encabezados[1])!=0) {
                    $array_e[0]['status']=250;
                    $array_e[2]['cont_e']++;
                    array_push ( $array_e[1]['errores'] , 'Error: No se encontro la columna Supervisor'  );

                }

            }
            //** */

            if ( $array_e[0]['status']==250) {
                return response()->json( $array_e);
            }

             $this->validacion_con_ci($postulados,$id,$array_e,$m_e);


             if ( $array_e[0]['status']==300) {
                $name=Auth::User()->id.'_'.$id.'_ErroresPostulados.xlsx';
                Excel::store(new ErroresExport($m_e), $name,'excels');
            }


             return response()->json( $array_e); //fino
        }


    }


    public function download_excel_er(Request $request)
    {
        $path='public/excel/'.$request->user_id_download.'_'.$request->f_id_download.'_ErroresPostulados.xlsx';

       if ( Storage::exists($path)) {
            return Storage::download($path);

       }
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
            /*$q3=User_ins_formacion::where('formacion_id',$id)->join('users as tbl1','tbl1.id','=','user_ins_formacions.user_id')->join('users as tbl2','tbl2.id','=','user_ins_formacions.supervisor_id')->select('tbl1.ci','tbl1.name','tbl1.email','tbl2.name as supervisor');*/

            return datatables()->of(User_ins_formacion::where('formacion_id',$id)->join('users as tbl1','tbl1.id','=','user_ins_formacions.user_id')->join('users as tbl2','tbl2.id','=','user_ins_formacions.supervisor_id')->select('tbl1.id','tbl1.ci','tbl1.name','tbl1.email','tbl2.name as supervisor'))
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="btn_edit_p" data-id="'.$data->id.'" class="examinar btn btn-info btn-sm"><i class="fas fa-search"></i></button>';

                        $button .= '<button type="button" name="delete" id ="btn_eliminar_p"    data-id="'.$data->id.'" class="btn-eliminar btn btn-danger btn-sm"><i class="fas fa-trash"  style="margin-right: 0.5rem;" ></i>Borrar</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->toJson();
        }

    }

    public function validar_p_s($value,$row,$evaluado,$em_id){

        if (is_int($value) and $value>0 ) { //valida que el valor sea un numero entero no negativo mayor a 1
            $p=User::find($value);
            if ($p) {//que exista en el sistema
                if ($evaluado=='supervisor') { //condicion especial para supervisor
                   if ( !$p->hasRole('Supervisor')) {
                    return($row.'- El usuario NO tiene el rango de supervisor');
                   }


                }
                $p=$p->empresa->first()->id;//se supone que todo usuario registrado pertenece a una empresa
                if ($p==$em_id) {//el postulado pertence a la empresa
                    return(true);
                }else{
                    return($row.'- El ' .$evaluado. ' NO pertenece a la Empresa');
                }

            }else{
                return($row.'- El ' .$evaluado.' NO esta registrado en la UVC');
            }

        }else{
            return($row.'- valor NO PERMITIDO para el '.$evaluado);
        }


    }

    public function validacion_con_ids($array,$f_id,&$response,&$m){
        $user=Auth::user();
        /** matriz a exportar */
            $i=1;
            $j=0;
            $m[0][0]='  Postulado  ';
            $m[0][1]='  Supervisor  ';
            $m[0][2]='  ';
            $m[0][3]='Mensaje';
        /** */

            $formacion=Formacion::find($f_id);

            $matricula_max=$formacion->max_matricula;
            $matricula_actual=$formacion->actual_matricula;

            $em_id=$user->empresa->first()->id;

            foreach ($array as $key => $value)
            {
                $row=1;
                $j=0;
               foreach ($value as $key2 => $value2)
                {
                    $m[$i][$j]=$value2['postulado'];
                    $m[$i][$j+1]=$value2['supervisor'];
                    $m[$i][$j+2]=' ';
                    $row++;

                   /* if ($matricula_max>$matricula_actual) esta forma es mas eficiente tecnicamente pero... menos bonita ene le excel
                    {*/

                        if (!((strcmp($value2['postulado'],'')==0)and(strcmp($value2['supervisor'],'')==0))) //validacion especial para evitar algunos caso donde los vacios... se tomaban en cuenta
                        {
                            //dump('row: '.$row.'p: '.$value2['postulado'].' s: '.$value2['supervisor']);
                            $p_v=$this->validar_p_s($value2['postulado'],$row,'postulado',$em_id);
                            $s_v=$this->validar_p_s($value2['supervisor'],$row,'supervisor',$em_id);
                            if (is_bool($p_v)) {
                                if (is_bool($s_v)) {
                                    if ($value2['postulado']!=$value2['supervisor']) { //caso postulado y supervisor =les
                                        $t=User_ins_formacion::where('user_id',$value2['postulado'])->where('formacion_id',$f_id)->get(); //valida repetidos estudiante-formacion
                                        if ($t->count()==0) {
                                            if ($matricula_max>$matricula_actual) {


                                                User_ins_formacion::create([ //se inserta
                                                    'user_id' => $value2['postulado'],
                                                    'formacion_id' =>$f_id,
                                                    'supervisor_id' => $value2['supervisor'],
                                                    'rp_id' => $user->id,
                                                ]);

                                                $response[0]['status']=777;
                                                $m[$i][$j+2]=' ';
                                                $m[$i][$j+3]='Guardardo Correctamente';

                                                $matricula_actual++;
                                                $formacion->actual_matricula=$matricula_actual;
                                                $formacion->status='con postulados'; //forma ineficiente
                                                $formacion->save();
                                            }else{
                                                $response[0]['status']=300;
                                                $response[2]['cont_e']++;
                                                array_push ( $response[1]['errores'] ,$row. '- Formacion llena' );
                                                $m[$i][$j+3]='Formacion llena: Se alcanzo el numero maximo de postulados permitido en la formacion';
                                            }

                                        }else{
                                            $response[0]['status']=300;
                                            $response[2]['cont_e']++;
                                            array_push ( $response[1]['errores'] , $row.'- El Postulado ya se encuentra registrado en la formacion' );

                                            $m[$i][$j+3]='El Postulado ya se encuentra registrado en la formacion';
                                        }

                                    }else{
                                        $response[0]['status']=300;
                                            $response[2]['cont_e']++;
                                            array_push ( $response[1]['errores'] , $row.'- El Postulado NO puede ser su propio Supervisor' );

                                            $m[$i][$j+3]='El Postulado NO puede ser su propio Supervisor';
                                    }
                                }else{
                                        $response[0]['status']=300;
                                        $response[2]['cont_e']++;
                                        array_push ( $response[1]['errores'] , $s_v );
                                        $s = substr($s_v,strpos($s_v, "-")+1);

                                        $m[$i][$j+3]=$s;
                                }
                            }else{
                                $response[0]['status']=300;
                                $response[2]['cont_e']++;
                                array_push ( $response[1]['errores'] , $p_v );


                                $s = substr($p_v,strpos($p_v, "-")+1);

                                $m[$i][$j+3]=$s;
                            }


                        }


                    $i++;

                }

            }
    }

    public function comprobar_valor_ci($value){

        $band=false;
        $n=strtoupper($value[0]);
        $ci= substr($value, 1);

        if ($n=='V') {

            if ( ctype_digit($ci)) {
                $band=true;
            }
        }else{
            if ($n=='E') {
                if ( ctype_digit($ci)) {
                    $band=true;
                }
            }

        }
        return($band);

    }

    public function validar_con_cedula($value,$row,$evaluado,$em_id){


        if ($this->comprobar_valor_ci($value) ) { //valida que el valor sea un numero entero

            $p=User::firstWhere('ci',$value);

            if ($p) {//que exista en el sistema
                if ($evaluado=='supervisor') { //condicion especial para supervisor
                    if ( !$p->hasRole('Supervisor')) {
                     return($row.'- El usuario NO tiene el rango de supervisor');
                    }
                 }
                $p=$p->empresa->first()->id;//se supone que todo usuario registrado pertenece a una empresa
                if ($p==$em_id) {//el postulado pertence a la empresa
                    return(true);
                }else{
                    return($row.'- El ' .$evaluado. ' NO pertenece a la Empresa');
                }

            }else{
                return($row.'- El ' .$evaluado.' NO esta registrado en la UVC');
            }

        }else{
            return($row.'- valor NO PERMITIDO para el '.$evaluado);
        }


    }

    public function validacion_con_ci($array,$f_id,&$response,&$m){

        $user=Auth::user();

         /** matriz a exportar */
         $i=1;
         $j=0;
         $m[0][0]='  Postulado  ';
         $m[0][1]='  Supervisor  ';
         $m[0][2]='  ';
         $m[0][3]='Error';
        /** */
        $formacion=Formacion::find($f_id);

        $matricula_max=$formacion->max_matricula;
        $matricula_actual=$formacion->actual_matricula;

        $cont_error=0;
        $em_id=$user->empresa->first()->id;
        //dump($em_id);
        foreach ($array as $key => $value)
        {
            $row=1;
            $j=0;
            foreach ($value as $key2 => $value2)
            {
                $m[$i][$j]=$value2['postulado'];
                $m[$i][$j+1]=$value2['supervisor'];
                $m[$i][$j+2]=' ';

                $row++;
                if (!((strcmp($value2['postulado'],'')==0)and(strcmp($value2['supervisor'],'')==0))) //validacion especial para evitar algunos caso donde los vacios consecutivos... se tomaban en cuenta
                {
                    $p_v=$this->validar_con_cedula($value2['postulado'],$row,'postulado',$em_id);
                    $s_v=$this->validar_con_cedula($value2['supervisor'],$row,'supervisor',$em_id);
                    if (is_bool($p_v)) {
                        if (is_bool($s_v)) {
                            if ($value2['postulado']!=$value2['supervisor']) { //caso postulado y supervisor =les
                                $id_user=User::firstWhere('ci',$value2['postulado'])->id;
                                $t=User_ins_formacion::where('user_id',$id_user)->where('formacion_id',$f_id)->get();
                                $id_superv=User::firstWhere('ci',$value2['supervisor'])->id;
                                if ($t->count()===0) { //ojo
                                    if ($matricula_max>$matricula_actual) {


                                        User_ins_formacion::create([ //se inserta
                                            'user_id' => $id_user,
                                            'formacion_id' =>$f_id,
                                            'supervisor_id' => $id_superv,
                                            'rp_id' => $user->id,
                                        ]);

                                        $response[0]['status']=777;
                                        $m[$i][$j+2]=' ';
                                        $m[$i][$j+3]='Guardardo Correctamente';

                                        $matricula_actual++;
                                        $formacion->actual_matricula=$matricula_actual;
                                        $formacion->status='con postulados';
                                        $formacion->save();
                                    }else{
                                        $response[0]['status']=300;
                                        $response[2]['cont_e']++;
                                        array_push ( $response[1]['errores'] ,$row. '- Formacion llena' );
                                        $m[$i][$j+3]='Formacion llena: Se alcanzo el numero maximo de postulados permitido en la formacion';
                                    }

                                }else{
                                    $response[0]['status']=300;
                                    $response[2]['cont_e']++;
                                    array_push ( $response[1]['errores'] , $row.'- El Postulado ya se encuentra registrado en la formacion' );

                                    $m[$i][$j+3]='El Postulado ya se encuentra registrado en la formacion';
                                }
                            }else{
                                $response[0]['status']=300;
                                    $response[2]['cont_e']++;
                                    array_push ( $response[1]['errores'] , $row.'- El Postulado NO puede ser su propio Supervisor' );

                                    $m[$i][$j+3]='El Postulado NO puede ser su propio Supervisor';
                            }
                        }else{
                            $response[0]['status']=300;
                            $response[2]['cont_e']++;
                            array_push ( $response[1]['errores'] , $s_v );
                            $s = substr($s_v,strpos($s_v, "-")+1);
                            $m[$i][$j+3]=$s;
                        }
                    }else{
                        $response[0]['status']=300;
                        $response[2]['cont_e']++;
                        array_push ( $response[1]['errores'] , $p_v );
                        $s = substr($p_v,strpos($p_v, "-")+1);
                        $m[$i][$j+3]=$s;
                    }
                }
                $i++;
            }

        }

    }





    public function expediente_estudiante_all(Request $request)
    {
        $q= User_ins_formacion::where('formacion_id',$request->f_id_ev)->join('users as tbl1','tbl1.id','=','user_ins_formacions.user_id')->select('tbl1.id','tbl1.ci','tbl1.name');

        $formacion=$request->f_id_ev;

        $result=[];
        foreach ($q->get() as $key => $user) {
            $user_exp=Expediente_usuario::where('user_id',$user->id);
            if ($user_exp->exists()) {
                $t_c=Expediente_usuario::where('user_id',$user->id)->count();
                $c_a=Expediente_usuario::where('user_id',$user->id)->where('status','Finalizada')->count();
                $c_ab=Expediente_usuario::where('user_id',$user->id)->where('status','Abandonada')->count();
                $l_c=Expediente_usuario::where('user_id',$user->id)->orderBy('created_at', 'desc')->selectRaw('DATE(created_at) AS Fecha')->first();

                $result[]=['id'=>$user->id,'ci'=>$user->ci,'nombre'=>$user->name,'total_cursos'=>$t_c,'cursos_ap'=>$c_a,'cursos_ab'=>$c_ab,'ult_curso'=>$l_c->Fecha];

            }else{
                $result[]=['id'=>$user->id,'ci'=>$user->ci,'nombre'=>$user->name,'total_cursos'=>0,'cursos_ap'=>0,'cursos_ab'=>0,'ult_curso'=>''];
            }
        }
        return view('responsable_de_personal.evaluar_expediente')->with('results', $result)->with('formacion',$formacion);
        //return view('responsable_de_personal.evaluar_expediente',['results'=>$result]);
       // return view('responsable_de_personal.evaluar_expediente',compact('result'));
    }

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
                            //dump('aprobado '.$ci_est);
                        }

                        if (($nota_est>5)AND($nota_est<9.5)) {
                            Expediente_usuario::where('user_id',$id_est)->where('formacion_id',$form_id) ->update(['status' => 'Finalizada','calificacion_obtenida'=>$nota_est]);
                            //dump('reprobado '.$ci_est);
                        }

                    }

            }else{
                $errores[0]['status']=404;
                //dd($array_e);
                array_push ( $errores[1]['errores'] , 'El estudiante  CI: '.$ci_est .' NO pertenece a la formacion selecionada, verifique el documento'  );
                //dd($array_e);
                //return response()->json( $array_e);
            }

        }else{
            $errores[0]['status']=403;
            array_push ( $errores[1]['errores'] , 'La CI: '.$ci_est .' NO existe en el sistema verifique el documento'  );
            dump($array_e);
            //return response()->json( $array_e);
        }

    }

    public function pruebas(Request $request)
    {



        $array_e=[];
        $array_e[]=['status'=>0];
        $array_e[]= ['errores'=>[]];
        $array_e[]=['cont_e'=>0];
        dump($array_e);


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
                        if (is_numeric($value2[3])) {
                            dump($value2[3]);
                            $notas[]=['ci'=>$value2[0],'nota' => (float)$value2[3]];
                        }else{
                            dump('ayyy');
                        }
                    }
                }else{
                    dump('error  formato incorrecto');
                }


                $i++;

            }

        }
        //dump($encabezado);
        if ($encabezado!=null) {
            # code...

        if (($encabezado[0]=='CI')AND($encabezado[1]=='Nombre')AND($encabezado[2]=='Correo')AND ($encabezado[3]=='Calificacion')) {
            dump($acta);
            dump($encabezado);
            dump($notas);
            foreach ($notas as $key => $value) {
                if ($value!='') {
                    $this->validacion_est($value,2,$array_e);
                }

            }
        }else{
            $array_e[0]['status']=402;
            array_push ( $array_e[1]['errores'] , 'El documento no presenta el formato adecuado (formato de matricula)'  );

            //return response()->json( $array_e);
        }
    }




        //dump($p);

        //dump($encabezados);
       //$p=User::firstWhere('ci',$value);

       //dump($p);
        /*foreach ($postulados as $key => $value)
      {
          $row=1;
          $j=0;
          foreach ($value as $key2 => $value2)
          {
               dump($value2['postulado']);
               dump($value2['supervisor']);
               $p=User::firstWhere('ci',$value2['postulado']);
               dump($p);
          }
       }

        if (strcasecmp('postulado',$encabezados[0])!=0) {

            dump(array_search('postulado',$encabezados,true));
            dump('gg');
        }else{
            if (strcasecmp('supervisor',$encabezados[1])!=0) {
                dump(array_search('supervisor',$encabezados,true));
                dump('gg2');


            }
        }*/














        /*$id=[1,100];
        //dump($id);
        $postulados=User_ins_formacion::where('formacion_id',2)->get();
            foreach ($postulados as $key => $value) {

                $existe=DB::table('mdl_inscripcions')->where('user_id',$value->user_id)->where('formacion_id',$value->formacion_id)->exists();

                $r=DB::table('mdl_inscripcions')->where('user_id',$value->user_id)->where('formacion_id',$value->formacion_id)->get();
                    dump($existe);
                    dump($r);

            }
        $supervisores=User::join('user_ins_formacions','user_ins_formacions.user_id','=','id')->select('user_id','formacion_id')->where('formacion_id',2)->get();
        $facilitadores=User::whereIn('id', $id)->get();
        dump($postulados);
        dump($supervisores);
        dump($facilitadores);*/



    /*
       $q= User_ins_formacion::where('formacion_id',2)->join('users as tbl1','tbl1.id','=','user_ins_formacions.user_id')->select('tbl1.id','tbl1.ci','tbl1.name');
       $q2=User_ins_formacion::join('expediente_usuarios','expediente_usuarios.user_id','=','user_ins_formacions.user_id')->where('user_ins_formacions.formacion_id',2);

       $q3=User_ins_formacion::where('user_ins_formacions.formacion_id',2)->join('users as tbl1','tbl1.id','=','user_ins_formacions.user_id')->select('tbl1.id','tbl1.ci','tbl1.name')->join('expediente_usuarios','expediente_usuarios.user_id','=','user_ins_formacions.user_id');
        dump($q->get());*/
      //dump($q2->get());
      //dump($q3->get());


      //$q4=User::where('prioridad','media')->count();
      //dump($q4);

            /**api para que usa url del cne para las cedulas


            $resp=[];
            $data = CedulaVE::get('V', '27131298', false);
            dump($data);
            if ($data["status"]==200) {
                $resp[]=$data['response'];
                dump($resp);
            }*/


        }







    public function destroy_all(Request $request) //vacia la lista de postulados
    {
        if ($request->ajax()) {

            try {
                User_ins_formacion::where('formacion_id',$request->f_id_dall)->delete();
                $formacion=Formacion::find($request->f_id_dall);

                $formacion->actual_matricula=0;
                $formacion->status='sin postulados';
                $formacion->save();
            } catch (\Throwable $th) {
                return "algo salio mal";
            }

        }

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




    public function destroy(Request $request)
    {

        if ($request->ajax()) {

            try {
                $postulado = User_ins_formacion::where('user_id',$request->user_id_bp)->where('formacion_id',$request->f_id_bp);
                $postulado->delete();
                $formacion=Formacion::find($request->f_id_bp);
                $matricula_actual=$formacion->actual_matricula;
                $formacion->actual_matricula=--$matricula_actual;
                if ($formacion->actual_matricula===0) {
                    $formacion->status='sin postulados';
                }
                $formacion->save();

            } catch (\Throwable $th) {
                return "algo salio mal";
            }

        }else{
            return 'nada';
        }
    }

   /* public function destroy(Request $request,$id,$id_f)
    {

        if ($request->ajax()) {

            try {
                $postulado = User_ins_formacion::where('user_id',$id)->where('formacion_id',$id_f);
                $postulado->delete();
            } catch (\Throwable $th) {
                return "algo salio mal";
            }

        }else{
            return 'nada';
        }
    }*/
}
