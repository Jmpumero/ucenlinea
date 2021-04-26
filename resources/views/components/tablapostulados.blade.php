<div>
    <!-- Let all your things have their places; let each part of your business have its time. - Benjamin Franklin -->
    <div id="_postulados" class="card table-responsive">
        <div class="card-header">
            <h3 class="card-title" style="margin-bottom: 3%">Lista de Postulados</h3>

            <div class="btn-group  table-responsive" style="margin-left: 10%; " role="group" aria-label="Basic example">
                <a>
                    <button type="button" id="btn_agregar" class="btn   btn-outline-primary" style="width: 100%;"> <i
                            class="fas fa-user-plus" style="margin-right: 0.5rem; "></i>Agregar</button>
                </a>

                <a href="#">
                    <button disabled=true type="button" id="btn_evaluar" class="btn  btn-outline-info"
                        style="width: 100%;" data-toggle="tooltip" title="Examinar">
                        <i class="fas fa-search" style="margin-right: 0.5rem; "></i>Expedientes</button>
                </a>

                <a>
                    <button type="button" id="btn_cargar" class="btn  btn-outline-success" style="width: 100%;"
                        data-toggle="tooltip" title="Examinar"> <i class="fas fa-upload"
                            style="margin-right: 0.5rem;"></i>Cargar Excel </button>
                </a>

                <a href="#">
                    <button disabled=true type="button" id="btn_deleted_all" class="btn  btn-outline-danger"
                        style="width: 100%;" data-toggle="tooltip" title=""> <i class="fas fa-trash"
                            style="margin-right: 0.5rem;"></i>Borrar Lista</button>
                </a>

            </div>



        </div>
        <div class="card-body  ">

            <table id="tabla_postulados" class="table table-striped projects text-center">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 15%">
                            C.I
                        </th>
                        <th style="width: 15%">
                            Nombre
                        </th>

                        <th style="width: 15%" class="text-center">
                            Correo
                        </th>
                        <th style="width: 15%" class="text-center">
                            Supervisor
                        </th>
                        <th style="width: 20%" class="text-center">
                            Acción
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>
