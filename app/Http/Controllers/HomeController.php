<?php

namespace App\Http\Controllers;
use Validator;
use App\Formacion;
use Carbon\Carbon;
use Illuminate\Http\File;
use App\Marco_regulatorio;
use Illuminate\Http\Request;
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
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
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

            $qw = Formacion::where('publicar',0)->select('id','nombre','imagen','fecha_de_inicio')->get();

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


         return view('formaciones_publicadas');

    }
}
