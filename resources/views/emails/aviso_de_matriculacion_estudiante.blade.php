
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Notificación de Inscripción </title>
</head>
<body>

    <div class="col-md-12 d-flex align-items-stretch">
        <div class="card">
            <h1 > UC en línea</h1> <br>
          <div class="card-img">
            <!--<img src="{{ asset($data['imagen']) }}" class="img-fluid" alt="...">-->
          </div>
          <div class="card-body">
            <h2 class="card-title"> !Saludos Cordiales!</h2>
           <h3> <p class="font-italic text-center">Inicio de la formación,{{ $data['fecha'] }}</p>
            <p class="card-text"> Se le participa a: <strong>{{ $data['name'] }},cedula:  {{ $data['ci'] }}</strong></p>
             <p>UC en linea, le informa que fue inscrito exitosamente en la formación: <strong>{{ $data['nombre_f']}} </strong>, la cual  inicia: <strong> {{ $data['fecha'] }}</strong>.</p>
           </h3>
            </div>
        </div>
      </div>


</body>
</html>
