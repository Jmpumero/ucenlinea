<?php

namespace App\Http\Livewire;

use App\User;
use Validator;
use App\Empresa;
use App\Formacion;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SelectFormaciones extends Component
{
    public $selectedFormation=null;
    public $user=null;
    public function render()
    {
        $now=Carbon::now('-4:00');
        $now->addDays(2); //fecha limite 3 dias antes del inicio
        $em_id=$this->user->empresa->first()->id; //un problema aqui es si el usuario no esta asociado a ninguna empresa, se supone que ese caso no deberia ocurrir ya que todo usuario dentro del sistema pertenece a una empresa
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

        $formaciones_list=Formacion::whereIn('id',$idf)->get();

        return view('livewire.select-formaciones',
            ['formaciones'=>$formaciones_list]
    );
    }

    public function updatedSelectedFormation($formacion_id){
        $this->selectedFormation=$formacion_id;
    }
}
