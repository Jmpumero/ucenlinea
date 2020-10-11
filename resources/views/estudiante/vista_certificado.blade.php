<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <style>
        h1{
        text-align: center;
        text-transform: uppercase;
        }
        .contenido{
        font-size: 20px;
        }

        .card {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #ffffff;
        background-clip: border-box;
        border: 0 solid rgba(0, 0, 0, 0.125);
        border-radius: 0.25rem;
        }

        .card > hr {
        margin-right: 0;
        margin-left: 0;
        }

        .card > .list-group:first-child .list-group-item:first-child {
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
        }

        .card > .list-group:last-child .list-group-item:last-child {
        border-bottom-right-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
        }

        .card-body {
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1.25rem;
        }


        .text-wrap {
        white-space: normal !important;
        }

        .text-nowrap {
        white-space: nowrap !important;
        }

        .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        }

        .text-left {
        text-align: left !important;
        }

        .text-right {
        text-align: right !important;
        }

        .text-center {
        text-align: center !important;
        }


    </style>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>
    <body >
        {{--@php dump($f_inicio); @endphp  --}}
        @foreach ($data as $item)


            <title> Certificado {{ $item->nombre }}</title>
            <div class="text-center" style="margin-bottom: 2%;">
                <h2>Universidad Virtual Corporativa UC</h1>

            </div>
            <div class="text-center" style="margin-bottom: 5%;">

                <img src="{{ asset('adminlte/img/logos/UC_logo.png') }}" width="80" class="img">
            </div>

            <div class="row-cols-lg-12">
                <div class="col-3 card text-left " style="margin-left: 4%;">
                    <p> codigo de certificado :{{  $item->codigo_certificado}}</p>
                </div>

                <div class="col-12 text-center" style="margin-bottom: 3%;">
                    <h2> La Universidad de Carabobo </h2>
                </div>
                <div class="col-6 card text-center ">
                    <strong> OTORGA AL CIUDADANO (A)</strong>
                </div>
            </div>
            <div class="col-12 text-center" style="margin-bottom: 4%;">
                <h2> {{ $item->name }} </h2>
            </div>

            <div class="col-12 text-center">
                <p>Titular de la cedula de identida N°:<strong>{{ $item->ci }}</strong>,certifica que curso y aprobó la formacion <h3>{{ $item->nombre}} </h3> </p>
            </div>

            <div class=" text-left" style="margin-left: 4%; margin-top: 8%;">
                <p> Impartido por: {{ $item->empresa_nombre }}</p>
                <p> Dirección: {{ $item->direccion }}</p>
                <p> Fecha de inicio: {{  $f_inicio }}</p>
                <p> Fecha de culminacion: {{ $f_cul }}</p>
                <p> Duracion:</p>
            </div>
        @endforeach
    </body>
</html>
