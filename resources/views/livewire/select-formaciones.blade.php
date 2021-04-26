<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day --}}
    <div class="cajacard center-vert center-hori">
        <div class="card card-selectformacion" id="c_formaciones">
            <div class="card-header-f text-center">
                <p> {{ $selectedFormation }}</p>
            </div>
            <div class=" card-body table-responsive-sm" style="text-align:center;">
                <label>Formaciones Disponibles</label>
                <div style="text-align:center;">
                    <div class="form-group">
                        <select wire:model="selectedFormation" class="form-control" id="select_formacion">
                            <option value="" selected>Selecciona una Formación</option>
                            @foreach ($formaciones as $formacion)
                                <option value="{{ $formacion->id }}">{{ $formacion->nombre }}</option>
                            @endforeach

                        </select>
                    </div>


                </div>

            </div>

        </div>
    </div>




</div>
