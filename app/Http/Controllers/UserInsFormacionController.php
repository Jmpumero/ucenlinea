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
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Imports\PostuladosImport;
use Maatwebsite\Excel\Importer;
use Maatwebsite\Excel\Facades\Excel;

use  App\Exports\ErroresExport;
use  App\Exports\ErroresvistaExport;
use App\CustomClass\CedulaVE;


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
            $em_id=$user->empresa->first()->id; //un problema aqui es si el usuario no esta asociado a ninguna empresa, se supone que ese caso no deberia ocurrir ya que todo usuario dentro del sistema pertenece a una empresa

            $r=Requisicion::where('empresa_id',$em_id);
            $formaciones_list=$r->join('formacions','requisicions.id','=','formacions.requisicion_id')->where('status','sin postulados')->where('disponibilidad',1)->where('fecha_de_inicio','>',$now)->get()->pluck('nombre','id');

            return view('responsable_de_personal.inscripcion',['formaciones_list'=>$formaciones_list]);
        }



    }





    public function select_usuarios(Request $request) //select con ajax borrar añ final
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

        $em_id=$user->empresa->first()->id;
        $usuarios=Empresa::find($em_id)->users->dump();


    }


    public function sup_show()
    {
        $user=Auth::user();
        if(request()->ajax())
        {
            $roles = Role::findByName('Supervisor'); //OJO CAMBIAR A SUPERVISOR
            $roles_us=$roles->users;
            $em_id=$user->empresa->first()->id;
            $usuarios=Empresa::find($em_id)->users;
            $q=$roles_us->intersect($usuarios);

            return datatables()->of($q)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="s_up" id="btn_select_sup" data-id="'.$data->id.'" class="inscribir btn  btn-outline-success btn-sm">Seleccionar</button>';


                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->toJson();
        }

        $roles = Role::findByName('Supervisor');
        $roles_us=$roles->users->dump();

        $em_id=$user->empresa->first()->id;
        $usuarios=Empresa::find($em_id)->users->dump();
        $r=$roles_us->intersect($usuarios)->dump();
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
        if ($request->ajax()) {

           /* $formacion=Formacion::where('id',$request->idf)->select('max_matricula');
            $actual=User_ins_formacion::where('user_id', $request->id_user)->count();
            if ($formacion->max_matricula) {
                # code...
            }*/

            if (User_ins_formacion::where('user_id', $request->id_user)->where('formacion_id',$request->idf)->exists()) {

                //$user=User::find($request->id_user);
               // $error[] = ['error' => 'El postulado ya se encuentra registrado en la formacion'];
                //$m= 'El postulado'+'gg'+ 'ya se encuentra registrado en la formacion';
                return response()->json(['error' => 'El postulado ya se encuentra registrado en la formacion']);
            }

            if ($request->id_user==$request->id_sp) {
                return response()->json(['error' => 'El postulado no puede ser su propio supervisor']);
            }


            $nuevo =new User_ins_formacion;
            $nuevo->user_id=$request->id_user;
            $nuevo->formacion_id=$request->idf;
            $nuevo->supervisor_id=$request->id_sp;

            $nuevo->save();



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
            $messages = [

                'archivo.extension' => 'El documento debe ser un archivo Excel'
            ];
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
                 return response()->json(['error' => $error->errors()->all()]);

              }
              ///** */
              $cont_error=0;
              $messages=array('errores'=>array('mensaje'=>'','fila'=>''),'exito'=>array('mensaje'=>''));// de prueba
              $postulados = Excel::toArray(new PostuladosImport,  request()->file('archivo'));
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
            if (array_search('postulado',$encabezados,true)==null) {

                $array_e[0]['status']=250;
                $array_e[2]['cont_e']++;
                array_push ( $array_e[1]['errores'] , 'Error: No se encontro la columna Postulado'  );

            }else{
                if (array_search('supervisor',$encabezados,true)==null) {
                    $array_e[0]['status']=250;
                    $array_e[2]['cont_e']++;
                    array_push ( $array_e[1]['errores'] , 'Error: No se encontro la columna Supervisor'  );


                }

            }
            //** */

            if ( $array_e[0]['status']==250) {
                return response()->json( $array_e);
            }
             $this->validacion_con_ids($postulados,$id,$array_e,$m_e);



            // $export = new ErroresExport( $array_e);

          /// return Excel::download($export, 'errores.xlsx');
            //return (new ErroresExport($m_e))->download('invoices.xlsx');
             return response()->json( $array_e); //fino


           //return response()->json(['error' => 'nope']);
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
                        $button = '<button type="button" name="edit" id="btn_edit_p" data-id="'.$data->id.'" class="inscribir btn btn-success btn-sm">Inscribir</button>';

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
                   if ( !$p->hasRole('Supervisor')) { //OJO CAMBIAR POR supervisor
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

            //$users_array[] = ['id' => $u->id, 'text' => $u->ci.' -> '.$nombre];
        /** matriz a exportar */
            $i=1;
            $j=0;
            $m[0][0]='  Postulado  ';
            $m[0][1]='  Supervisor  ';
            $m[0][2]='  ';
            $m[0][3]='Error';
        /** */

            $em_id=$user->empresa->first()->id;

            foreach ($array as $key => $value) {
                $row=1;
                $j=0;

               foreach ($value as $key2 => $value2) {

                    $m[$i][$j]=$value2['postulado'];
                    $m[$i][$j+1]=$value2['supervisor'];
                    $m[$i][$j+2]=' ';

                    $row++;
                    $p_v=$this->validar_p_s($value2['postulado'],$row,'postulado',$em_id);
                    $s_v=$this->validar_p_s($value2['supervisor'],$row,'supervisor',$em_id);
                    if (is_bool($p_v)) {
                        if (is_bool($s_v)) {
                            if ($value2['postulado']!=$value2['supervisor']) { //caso postulado y supervisor =les
                                $t=User_ins_formacion::where('user_id',$value2['postulado'])->where('formacion_id',$f_id)->get(); //valida repetidos estudiante-formacion
                                if ($t->count()==0) {
                                    User_ins_formacion::create([ //se inserta
                                        'user_id' => $value2['postulado'],
                                        'formacion_id' =>$f_id,
                                        'supervisor_id' => $value2['supervisor'],
                                    ]);

                                    $response[0]['status']=777;

                                   /* $m[$i][$j]=$value2['postulado'];
                                    $m[$i][$j+1]=$value2['supervisor'];*/
                                    $m[$i][$j+2]=' ';
                                    $m[$i][$j+3]='Guardardo Correctamente';

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

            //$id_user=User::where()
            //$h=User::find(1);
            $p=User::firstWhere('ci',$value);
            //dump($p);
            //dd($h);
            //dd($p->get());

            if ($p) {//que exista en el sistema
                if ($evaluado=='supervisor') { //condicion especial para supervisor
                   if ( !$p->hasRole('Supervisor')) { //OJO CAMBIAR POR supervisor
                    return('fila:'.$row.' -->El ' .$evaluado. ' NO tiene el rango de supervisor');
                   }
                }
                $p=$p->empresa->first()->id;//se supone que todo usuario registrado pertenece a una empresa
                if ($p==$em_id) {//el postulado pertence a la empresa
                    return(true);
                }else{
                    return('fila:'.$row.' -->El ' .$evaluado. ' NO pertenece a la Empresa');
                }

            }else{
                return('fila:'.$row.' -->El ' .$evaluado.' NO esta registrado en la UVC');
            }

        }else{
            return('fila:'.$row. '  valor NO PERMITIDO');
        }


    }

    public function validacion_con_ci($array,$f_id){

        $user=Auth::user();
        $cont_error=0;
        $em_id=$user->empresa->first()->id;
        //dump($em_id);
        foreach ($array as $key => $value) {
            $row=1;
            foreach ($value as $key2 => $value2) {
                $row++;
                $p_v=$this->validar_con_cedula($value2['postulado'],$row,'postulado',$em_id);
                $s_v=$this->validar_con_cedula($value2['supervisor'],$row,'supervisor',$em_id);
                if (is_bool($p_v)) {
                    if (is_bool($s_v)) {
                        if ($value2['postulado']!=$value2['supervisor']) { //caso postulado y supervisor =les
                            $id_user=User::firstWhere('ci',$value2['postulado'])->id;

                            $t=User_ins_formacion::where('user_id',$id_user)->where('formacion_id',$f_id)->get();
                            //dump($t->count());
                            if ($t->count()==0) {
                                //dump($value2['postulado'].' --'.$value2['supervisor']);

                                 User_ins_formacion::create([ //se inserta
                                        'user_id' => $id_user,
                                        'formacion_id' =>$f_id,
                                        'supervisor_id' => User::firstWhere('ci',$value2['supervisor'])->id,
                                    ]);
                            }else{
                                dump($row.'  El postulado ya se encuentra registrado en la formacion');
                            }

                        }
                    }else{
                        //dump($value2['supervisor']);
                        //dump($row);
                        //dump('supervisor'.$value2['supervisor'].'->'.$s_v);
                       // $cont_error++;
                    }
                }else{
                    //falta recoge el error
                    //$cont_error++;
                }

            }

        }

    }




    public function pruebas(Request $request)
    {


       $messages = [

        'archivo.extension' => 'El documento debe ser un archivo Excel'
    ];

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
      //dump($error);
      $array = Excel::toArray(new PostuladosImport,  request()->file('archivo'));

      $l=[];
      $l[]=['status'=>0];
      $l[]= ['errores'=>[]];
      $l[]=['cont_e'=>0];
      $m_export;


      $this->validacion_con_ids($array,$request->formacion,$l,$m_export);


     // dump($l);
      //dump($m_export);
      $d[]=[];
      foreach ($l[1]['errores'] as $key => $value) {
          $d[]=['mensaje'=>$value];
      }

      //dump($d);
      //$export = new ErroresExport( $l);
     // $export = new ErroresExport( $l[1]['errores']); funcionan
      //$export = new ErroresExport( $array);
      return Excel::download(new ErroresExport($m_export), 'prueba_export.xlsx');
      //return (new ErroresExport($m_export))->download('invoices.xlsx');
        //return Excel::download(new ErroresExport($m_export), 'prueba_export.xlsx');
       //Excel::download(new ErroresvistaExport($l), 'prueba_export.xlsx');


            //return response()->json($data);
            //return $q3;
            /**api para que usa url del cne para las cedulas


            $resp=[];
            $data = CedulaVE::get('V', '27131298', false);
            dump($data);
            if ($data["status"]==200) {
                $resp[]=$data['response'];
                dump($resp);
            }*/

    }




    public function destroy_all(Request $request,$id) //vacia la lista de postulados
    {
        if ($request->ajax()) {

            try {
                User_ins_formacion::where('formacion_id',$id)->delete();
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User_ins_formacion  $user_ins_formacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if ($request->ajax()) {

            try {
                $postulado = User_ins_formacion::where('user_id',$id);
                $postulado->delete();
            } catch (\Throwable $th) {
                return "algo salio mal";
            }

        }
    }
}
