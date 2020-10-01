<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Formacion;
use App\Mdl_inscripcion;
use App\Usuario_p_empresa;
use App\User_ins_formacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

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

            return datatables()->of(Formacion::where('status','con postulados')->where('t_facilitador',0)->where('disponibilidad',1))->addColumn('action', function($data){
                $button = '<button type="button" name="edit" id="btn_edit_p" data-id="'.$data->id.'" class="examinar btn btn-info btn-sm"><i class="fas fa-search"></i></button>';

                $button .= '<button type="button" name="delete" id ="btn_enroll"    data-id="'.$data->id.'" class="btn-matricular btn btn-success btn-sm"><i class="fas fa-address-book"  style="margin-right: 0.5rem;" ></i>Matricular</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->toJson();

        }

        return view('responsable_control_de_estudio.rce_matricular');
    }



    public function facilitador_show()
    {
        $user=Auth::user();
        if(request()->ajax())
        {


            $users = $user->role('Facilitador')->get();
            return datatables()->of($users)->addColumn('action', function($data){
                $button = '<button type="button" name="edit"  data-id="'.$data->id.'" class="examinar btn btn-info btn-sm"><i class="fas fa-search"></i></button>';

                return $button;
            })
            ->rawColumns(['action'])
            ->toJson();

        }


    }




    public function matricular($postulados,$rol)
    {
        foreach ($postulados as $key => $value) {
            $existe=DB::table('mdl_inscripcions')->where('user_id',$value->user_id)->where('formacion_id',$value->formacion_id)->exists();

            if ($existe) {
                $estu=Mdl_inscripcion::find($value->user_id);
                $n_rol=$estu->rol_shortname;

                $estu->user_id=$value->user_id;
                $estu->formacion_id=$value->formacion_id;
                $estu->rol_shortname=$n_rol.','.$rol;
                $estu->save();

            }else{
                Mdl_inscripcion::create([ //se inserta
                    'user_id' => $value->user_id,
                    'formacion_id' =>$value->formacion_id,
                    'rol_shortname' => $rol,

                ]);
            }

        }
    }

    public function enroll($postulados,$rol,$form_id)
    {
        foreach ($postulados as $key => $value) {
           
                Mdl_inscripcion::create([ //se inserta
                    'user_id' => $value->user_id,
                    'formacion_id' =>$form_id,
                    'rol_shortname' => $rol,

                ]);
                //otorgar permiso de estudiante en la uvc
                //$estu=User::find($value->user_id);



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
                $this->enroll($postulados,'student',$request->f_id);
                $this->enroll($supervisores,'supervisor',$request->f_id);
                $this->enroll($facilitadores,'teacher',$request->f_id);
                $this->enroll($responsable_personal,'rpcurso',$request->f_id);

             }else{
                 return response()->json( $array_e);
             }











            return response()->json( $array_e);
        }

    }




    public function pruebas(Request $request)
    {

        $id=[100];
        dump($id);
        $postulados=User_ins_formacion::where('formacion_id',2)->get();
      /*  dump('******postulados******');
            foreach ($postulados as $key => $value) {

                $existe=DB::table('mdl_inscripcions')->where('user_id',$value->user_id)->where('formacion_id',$value->formacion_id)->exists();

                if ($existe) {
                    $estu=Mdl_inscripcion::firstWhere('user_id',$value->user_id);
                    $n_rol=$estu->rol_shortname;

                    dump('user_id => '. $value->user_id);
                    dump('formacion_id => '. $value->formacion_id);
                    dump('rol_shortname =>'.$n_rol.','.'supervisor');
                    //$estu->user_id=$value->user_id;
                    //$estu->formacion_id=$value->formacion_id;
                    //$estu->rol_shortname=$n_rol.','.$rol;
                   // $estu->save();

                }else{

                    dump('user_id => '. $value->user_id);
                    dump('formacion_id => '. $value->formacion_id);
                    dump('rol_shortname =>  postulados');

                }

            }

            dump('*********');
*/
        $supervisores=User::join('user_ins_formacions','user_ins_formacions.supervisor_id','=','id')->select('id as user_id')->where('formacion_id',2)->distinct()->get();

        /*dump($supervisores);
        dump('******supervisores******');
        foreach ($supervisores as $key => $value) {

            $existe=DB::table('mdl_inscripcions')->where('user_id',$value->user_id)->where('formacion_id',$value->formacion_id)->exists();
            dump($existe);
            if ($existe) {

                $estu=Mdl_inscripcion::firstWhere('user_id',$value->user_id);
                $n_rol=$estu->rol_shortname;

                dump('user_id => '. $value->user_id);
                dump('formacion_id => '. $value->formacion_id);
                dump('rol_shortname =>'.$n_rol.','.'supervisor');


            }else{

                dump('user_id => '. $value->user_id);
                dump('formacion_id => '. $value->formacion_id);
                dump('rol_shortname =>  supervisor');

            }

        }*/

        $facilitadores=User::whereIn('id', $id)->select('id as user_id','name','ci')->get();
       // dump($facilitadores);

       $valor=true;

       foreach ($facilitadores as $key => $fa) {

        foreach ($postulados as $key => $post) {
            if ($post->user_id===$fa->user_id) {
                $valor=false;
            }
        }
        }

        dump($valor);

        $id=User_ins_formacion::where('formacion_id',2)->first();

        dump($id);
        $user=Auth::user()->find($id->rp_id);

        $em_id=$user->empresa->first()->id;


        $rp=Usuario_p_empresa::where('empresa_id',$em_id)->join('model_has_roles','model_id','=','usuario_p_empresas.user_id')->where('model_has_roles.role_id',2)->get();






        //$id=$id->rp_id;

        $facilitadores=User::whereIn('id', $id)->select('id as id_user')->get();

        //dump($postulados);
       // dump($supervisores);







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
