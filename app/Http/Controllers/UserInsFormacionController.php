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

class UserInsFormacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $user=Auth::user();
        if ($user->hasPermissionTo('inscribir estudiantes')) {
            //falta un condicional especial para el rol admin y super-admin
            $now=Carbon::now('-4:00'); // como se cambio la variable  'timezone' =>'America/Caracas' ya no es necesario hacer esta inicializacion bastaria con usar Carbon::now()
            $em_id=$user->empresa->first()->id; //un problema aqui es si el usuario no esta asociado a ninguna empresa, se supone que ese caso no deberia ocurrir ya que todo usuario dentro del sistema pertenece a una empresa

            $r=Requisicion::where('empresa_id',$em_id);
            $formaciones_list=$r->join('formacions','requisicions.id','=','formacions.requisicion_id')->where('status','sin postulados')->where('disponibilidad',1)->where('fecha_de_inicio','>',$now)->get()->pluck('nombre','id');

            return view('responsable_de_personal.inscripcion',['formaciones_list'=>$formaciones_list]);
        }



    }





    public function select_usuarios(Request $request) //select con ajax
    {
        /*$term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }*/

        //$tags = Tag::search($term)->limit(5)->get();
        //falta hacer el search
            $user=Auth::user();

            if ($user->hasPermissionTo('inscribir estudiantes')) {

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
            $roles = Role::findByName('Admin'); //OJO CAMBIAR A SUPERVISOR
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

        $roles = Role::findByName('Admin');
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
              $postulados = Excel::toArray(new PostuladosImport,  request()->file('archivo'));
              $l=[];
              foreach ($postulados as $key => $value) { //ineficiente pero seguro para obtener todas las posibles claves presente
                foreach ($value as $key2 => $value2) {

                    foreach ($value2 as $key3 => $value3) {
                        $l[]=$key3;
                    }
                    break 2;

                }
            }

            array_search('postulado',$l,true);
            array_search('supervisor',$l,true);



              //dd($collection);
              //Excel::Import(new PostuladosImport,  request()->file('archivo')); //funciona
             /* foreach ($collection  as $row)
            {
                User_ins_formacion::create([
                    'user_id' => $row['postulado'],
                    'formacion_id' =>$row['formacion'],
                    'supervisor_id' => $row['supervisor'],
                ]);
            }*/



           if ($collection->isNotEmpty()) {
                //$request->file('archivo')->store('public');
                return response()->json(['success' => 'Es el dia del PLAATANOOO chi cheñol']);
           }





           return response()->json(['error' => 'nope']);
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




    public function pruebas()
    {



        //$collection = Excel::toCollection(new PostuladosImport,  request()->file('archivo'));
        $array = Excel::toArray(new PostuladosImport,  request()->file('archivo'));
        //$sp=Excel::toArray([],  request()->file('archivo'));

        //dump($collection);
       // dump($array);


        //$l=array_change_key_case($array,CASE_UPPER);
        $l=[];
        foreach ($array as $key => $value) {

            foreach ($value as $key2 => $value2) {

                //dump($value2['postulado']);
                //dump($value2['formacion']);
               // dump($value2['supervisor']);
            }
        }

        foreach ($array as $key => $value) { //ineficiente pero seguro para obtener todas las posibles claves presente
            foreach ($value as $key2 => $value2) {

                foreach ($value2 as $key3 => $value3) {
                    $l[]=$key3;
                }
                break 2;

            }
        }

        dump(array_search('postulado',$l,true));
        dump(array_search('supervisor',$l,true));
        dump($l);
        dump($array);
       // dump(array_key_exists('postulado',$l));

        /*

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
