<!--esto es solo de prueba para ver como se ve no esta terminado-->
<div class="card">

    <div class=" card card-outline card-blue">
        <div class="card-header">
            <h5>Datos del Postulado:</h5>
        </div>
        <div class="row">

            <div class=" col-6">
                <div class="form-row">
                    {{ Form::label('nombre', 'Nombre',['class' => 'col-3 col-form-label']) }}
                    <div class="col-8">
                        {{ Form::text('nombre', null, ['class' => 'form-control','readonly', 'id' => 'user_name']) }}
                    </div>
                </div>
            </div>
            <div class=" col-6">
                <div class="form-group row">
                    {{ Form::label('ci', 'CI',['class' => 'col-3 col-form-label']) }}
                    <div class="col-8">
                        {{ Form::text('ci', null, ['class' => 'form-control','readonly', 'id' => 'user_ci']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" card card-outline card-warning">
        <div class="card-header">
            <h5>Datos del Supervisor:</h5>
        </div>
        <div class="row">

            <div class=" col-6">
                <div class="form-row">
                    {{ Form::label('nombre', 'Nombre',['class' => 'col-3 col-form-label']) }}
                    <div class="col-8">
                        {{ Form::text('nombre', null, ['class' => 'form-control','readonly', 'id' => 's_name']) }}
                    </div>
                </div>
            </div>
            <div class=" col-6">
                <div class="form-group row">
                    {{ Form::label('ci', 'CI',['class' => 'col-3 col-form-label']) }}
                    <div class="col-8">
                        {{ Form::text('ci', null, ['class' => 'form-control','readonly', 'id' => 's_ci']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

