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
        /*$user=Auth::user();
        $em_id=$user->empresa->first()->id;

        $n_retiro= DB::table('retiro_formacion_est_rps as tbl_ret')->where('tbl_ret.empresa_del_postulado_id',$em_id)->where('tbl_ret.status_solicitud','NO PROCESADA')->join('users as tbl_us','tbl_ret.postulado_id','=','tbl_us.id')->count();*/
        //return view('home')->with('n_rp_retiro',$n_retiro);
        return view('home');
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



            $path=$request->file('archivo')->storeAs('marco_regulatorio', $nombre);//lo guardo en el disco especificado con el nombre dado y se guarada el path
            $url = Storage::url($nombre);
            $user=Auth::user();
            $this->guardar_doc_DB($user->id,$nombre,$path,$url,$request->rol);

                return response()->json( $array_e);

        }

    }

    //responsable de control de estudio
    public function guardar_doc_DB($user_id,$nombre,$path,$url,$rol){

       $band=Marco_regulatorio::where('mr_nombre',$nombre)->where('mr_rol',$rol)->exists();
       if (!$band) {
            $marco_r= new Marco_regulatorio;
            $marco_r->mr_usuario_id=$user_id;
            $marco_r->mr_nombre=$nombre;
            $marco_r->mr_ruta=$path;
            $marco_r->mr_url=$url;
            $marco_r->mr_rol=$rol;
            $marco_r->save();
       }else{
            $marco_r=Marco_regulatorio::where('mr_nombre',$nombre)->where('mr_rol',$rol)->first()->touch();
       }



    }

    //responsable de control de estudio? (no terminada)
    public function tabla_index_documentos(Request $request){
        if(request()->ajax())
         {
            $idf=[];
            $user=Auth::user();

            $qw = Marcao_regulatorio::all();

            //$q=Formacion::whereIn('id',$idf)->get();

             return datatables()->of($qw)
             ->addColumn('action', function($data){
                 $button = '<button type="button"  id ="btn_ver_m" name="btn_ver"    data-id="'.$data->id.'" class="examinar btn btn-danger btn-sm"><i class="fas fa-trash" style="margin-right: 0.5rem;"></i>borrar</button>';

                 return $button;


             })
             ->rawColumns(['action'])
             ->toJson();

         }

         return view('facilitador.fac_download_matricula');

    }


    //responable de control de estudio
    public function index_formaciones_no_publicadas(){
        if(request()->ajax())
         {
            $idf=[];
            $user=Auth::user();

            $qw = Formacion::where('publicar',0)->where('disponibilidad',1)->select('id','nombre','imagen','fecha_de_inicio')->get();

            //$q=Formacion::whereIn('id',$idf)->get();

             return datatables()->of($qw)
             ->addColumn('action', function($data){
                 $button = '<button type="button"  id ="btn_publicar" name="btn_ver"    data-id="'.$data->id.'" class="examinar btn btn-outline-success btn"><i class="fas fa-check" "></i></button>';

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
            $formacion->publicar=true;
            $formacion->save();

         }

         return view('responsable_control_de_estudio.rce_formaciones_no_publicadas');

    }


    public function index_formaciones_publicadas(){

        $now=Carbon::now();
        $qw = DB::table('formacions as tbl_f')->where('tbl_f.publicar',1)->where('tbl_f.fecha_de_inicio','>=',$now)->join('empresas as tbl_em','tbl_em.id','=','tbl_f.empresa_proveedora_id')->select('tbl_f.id','tbl_f.nombre','tbl_f.imagen','tbl_f.f_resumen','tbl_f.formacion_libre','tbl_f.precio','tbl_f.fecha_de_inicio','tbl_em.nombre as nombre_empresa')->get();

         return view('formaciones_publicadas')->with('results', $qw);

    }
}
