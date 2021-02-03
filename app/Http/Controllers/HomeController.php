<?php

namespace App\Http\Controllers;
use App\User;
use Validator;
use App\Formacion;
use Carbon\Carbon;
use Illuminate\Http\File;
use App\Marco_regulatorio;
use Illuminate\Http\Request;
use App\Certificados_f_estudiante;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct() //importaten ya que hay controladores y rutas que  no necesitan estar logueados
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('home');
    }


    public function descarga_documento($nombre){


        $doc=Marco_regulatorio::firstWhere('mr_nombre_rol',$nombre);
        if ($doc!=null) {
            $ruta=$doc->mr_ruta;
            return Storage::response($ruta);
        }
       

    }

    public function ver_marco_regulatorio_index(){

        $user=Auth::user();
        $matriz[]=['Admin'=>[]];
        $matriz[]=['Responsable de Personal'=>[]];
        $matriz[]=['Supervisor'=>[]];
        $matriz[]=['Facilitador'=>[]];
        $matriz[]=['Estudiante'=>[]];
        $matriz[]=['Responsable de Contenido'=>[]];
        $matriz[]=['Responsable de Control de Estudio'=>[]];
        $matriz[]=['Responsable Administrativo'=>[]];
        $matriz[]=['Responsable de TI'=>[]];
        $matriz[]=['Responsable Academico'=>[]];
        $matriz[]=['Proveedor'=>[]];

        $roles=$user->getRoleNames();
        $q=Marco_regulatorio::whereIn('mr_rol',$roles)->select('mr_nombre','mr_nombre_rol','mr_ruta','mr_url','mr_rol')->get();

        foreach ($q as $key => $item) {


            switch ($item->mr_rol) {
                case 'Admin':
                    array_push ( $matriz[0]['Admin'] , ['rol'=>$item->mr_rol,'nombre'=>$item->mr_nombre,'ruta'=>$item->mr_ruta,'nombre_rol'=>$item->mr_nombre_rol]  );
                    break;

                case 'Responsable de Personal':
                    array_push ( $matriz[1]['Responsable de Personal'] , ['rol'=>$item->mr_rol,'nombre'=>$item->mr_nombre,'ruta'=>$item->mr_ruta,'nombre_rol'=>$item->mr_nombre_rol]  );
                    break;

                case 'Supervisor':
                    array_push ( $matriz[2]['Supervisor'] , ['rol'=>$item->mr_rol,'nombre'=>$item->mr_nombre,'ruta'=>$item->mr_ruta,'nombre_rol'=>$item->mr_nombre_rol]  );
                    break;

                case 'Facilitador':
                    array_push ( $matriz[3]['Facilitador'] , ['rol'=>$item->mr_rol,'nombre'=>$item->mr_nombre,'ruta'=>$item->mr_ruta,'nombre_rol'=>$item->mr_nombre_rol]  );
                    break;

                case 'Estudiante':
                    array_push ( $matriz[4]['Estudiante'] , ['rol'=>$item->mr_rol,'nombre'=>$item->mr_nombre,'ruta'=>$item->mr_ruta,'nombre_rol'=>$item->mr_nombre_rol]  );
                    break;

                case 'Responsable de Contenido':
                    array_push ( $matriz[5]['Responsable de Contenido'] , ['rol'=>$item->mr_rol,'nombre'=>$item->mr_nombre,'ruta'=>$item->mr_ruta,'nombre_rol'=>$item->mr_nombre_rol]  );
                    break;

                case 'Responsable de Control de Estudio':
                    array_push ( $matriz[6]['Responsable de Control de Estudio'] , ['rol'=>$item->mr_rol,'nombre'=>$item->mr_nombre,'ruta'=>$item->mr_ruta,'nombre_rol'=>$item->mr_nombre_rol]  );
                    break;


                case 'Responsable Administrativo':
                    array_push ( $matriz[7]['Responsable Administrativo'] , ['rol'=>$item->mr_rol,'nombre'=>$item->mr_nombre,'ruta'=>$item->mr_ruta,'nombre_rol'=>$item->mr_nombre_rol]  );
                    break;


                case 'Responsable de TI':
                    array_push ( $matriz[8]['Responsable de TI'] , ['rol'=>$item->mr_rol,'nombre'=>$item->mr_nombre,'ruta'=>$item->mr_ruta,'nombre_rol'=>$item->mr_nombre_rol]  );
                    break;

                case 'Responsable  Academico':
                    array_push ( $matriz[9]['Responsable Academico'] , ['rol'=>$item->mr_rol,'nombre'=>$item->mr_nombre,'ruta'=>$item->mr_ruta,'nombre_rol'=>$item->mr_nombre_rol]  );
                    break;

                case 'Proveedor':
                    array_push ( $matriz[10]['Proveedor'] , ['rol'=>$item->mr_rol,'nombre'=>$item->mr_nombre,'ruta'=>$item->mr_ruta,'nombre_rol'=>$item->mr_nombre_rol]  );
                    break;
            }



        }

        return view('vista marco regulatorio.ver_documentos')->with('datos',$matriz);

    }


    public function verificar_certificado_index()
    {

        return view('verificar_certificado.verificar_certificado');
    }

    public function verificar_certificado(Request $request)
    {
        if(request()->ajax())
         {
            $a_msj=[];
            $a_msj[]=['status'=>400];
            $a_msj[]= ['msj'=>'Certificado NO encontrado'];
            $error=0;
            $user=User::firstWhere('ci',$request->ci);
            if ($user!=null) {
                if ( Certificados_f_estudiante::where('codigo_certificado',$request->codigo)->where('user_id',$user->id)->exists()) {

                    $a_msj[0]['status']=200;
                    $a_msj[1]['msj']='!Certificado validado!';
                }
            }

            return response()->json( $a_msj);

         }
        return view('verificar_certificado.verificar_certificado');
    }


    //responsable de control de estudio
    public function cargar_marco_regulatorio_index(){

        $roles=Role::all();

        return view('responsable_control_de_estudio.rce_cargar_documento_mr')->with('roles', $roles);

    }

    //responsable de control de estudio
    public function guardar_documento_marco_regulatorio(Request $request){
        if ($request->ajax()) {

            $array_e=[];
            $array_e[]=['status'=>200];
            $array_e[]= ['error'=>''];

            $messages = [  'archivo.extension' => 'El documento debe ser un archivo PDF' ];
            $error= Validator::make(
                [
                    'file'      => $request->file('archivo'),
                    'extension' => strtolower($request->file('archivo')->getClientOriginalExtension()),
                ],
                [
                    'file'          => 'required',
                    'extension'      => 'required|in:pdf',
                ],
                $messages
              );
              if($error->fails())
              {
                $array_e[0]['status']=450;
                 $array_e[1]['error'] = 'El documento debe ser un archivo PDF (.pdf)'  ;
                return response()->json( $array_e);

              }



              //
              //obtenemos el campo file definido en el formulario
            $file = $request->file('archivo');

            //obtenemos el nombre del archivo
            $now=Carbon::now();
            $nombre = $file->getClientOriginalName();
            $t=explode('.',$nombre);
            $nombre_rol =$t[0].'_'.$request->rol.'.'.$t[1];

            $path=$request->file('archivo')->storeAs('marco_regulatorio', $nombre_rol);//lo guardo en el disco especificado con el nombre dado y se guarada el path
            $url = Storage::url($nombre_rol);
            $user=Auth::user();
            $this->guardar_doc_DB($user->id,$nombre,$nombre_rol,$path,$url,$request->rol);

                return response()->json( $array_e);

        }

    }

    //responsable de control de estudio
    public function guardar_doc_DB($user_id,$nombre,$nombre_rol,$path,$url,$rol){

       $band=Marco_regulatorio::where('mr_nombre',$nombre)->where('mr_rol',$rol)->exists();
       if (!$band) {
            $marco_r= new Marco_regulatorio;
            $marco_r->mr_usuario_id=$user_id;
            $marco_r->mr_nombre=$nombre;
            $marco_r->mr_nombre_rol=$nombre_rol;
            $marco_r->mr_ruta=$path;
            $marco_r->mr_url=$url;
            $marco_r->mr_rol=$rol;
            $marco_r->save();
       }else{
            $marco_r=Marco_regulatorio::where('mr_nombre',$nombre)->where('mr_rol',$rol)->first()->touch();
       }



    }




    //responable de control de estudio
    public function index_formaciones_no_publicadas(){
        if(request()->ajax())
         {
            $idf=[];
            $user=Auth::user();
            $now=Carbon::now();
            $qw = Formacion::where('disponibilidad',1)->where('fecha_de_inicio','>=',$now)->select('id','nombre','imagen','fecha_de_inicio','publicar')->get();

            //$q=Formacion::whereIn('id',$idf)->get();

             return datatables()->of($qw)
             ->addColumn('action', function($data){
                 if ($data->publicar===0) {

                    $button = '<button type="button"  id ="btn_publicar" name="btn_ver"    data-id="'.$data->id.'" class="examinar btn btn-publica btn-lg"><i class="fas fa-eye" "></i></button>';
                 }else{

                    $button = '<button type="button"  id ="btn_publicar" name="btn_ver"    data-id="'.$data->id.'" class="examinar btn btn-oculta btn-lg"><i class="fas fa-eye-slash" "></i></button>';

                 }


                 return $button;


             })
             ->rawColumns(['action'])
             ->toJson();

         }

         return view('responsable_control_de_estudio.rce_formaciones_no_publicadas');

    }


    //responable de control de estudio
    public function publica_formacion(Request $request){
        if(request()->ajax())
         {
            $formacion=Formacion::find($request->f_id);
            if ($formacion->publicar) {
                $formacion->publicar=false;
            }else{
                $formacion->publicar=true;
            }

            $formacion->save();

         }

         return view('responsable_control_de_estudio.rce_formaciones_no_publicadas');

    }

    //responable de control de estudio
    public function index_formaciones_publicadas(){

        $now=Carbon::now();
        $qw = DB::table('formacions as tbl_f')->where('tbl_f.publicar',1)->where('tbl_f.fecha_de_inicio','>=',$now)->join('empresas as tbl_em','tbl_em.id','=','tbl_f.empresa_proveedora_id')->select('tbl_f.id','tbl_f.nombre','tbl_f.imagen','tbl_f.f_resumen','tbl_f.formacion_libre','tbl_f.precio','tbl_f.fecha_de_inicio','tbl_em.nombre as nombre_empresa')->get();

         return view('formaciones_publicadas')->with('results', $qw);

    }
}
