
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>UC en línea </title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('adminlte/img/logos/UC_logo_icono.png') }}" rel="icon">
  <link href="{{ asset('mentor/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">


 <!-- Font Awesome -->
 <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">


  <!-- Vendor CSS Files -->
  <link href="{{ asset('mentor/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('mentor/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
  <link href="{{ asset('mentor/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('mentor/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('mentor/vendor/owl.carousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
  <link href="{{ asset('mentor/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
  <link href="{{ asset('mentor/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">


  <!-- Template Main CSS File -->
  <link href="{{ asset('mentor/css/style.css') }}" rel="stylesheet">
    <!-- Personalizado style -->
<link rel="stylesheet" href="{{ asset('adminlte/css/extras.css') }}">
<!-- Theme style adminlte -->
<link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.css') }}">
  <!-- =======================================================
  * Template Name: Mentor - v2.1.0
  * Template URL: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo mr-auto"><a href="#">Universidad de Carabobo</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li><a href="{{ url('/') }}">Inicio</a></li>
          <li><a href="{{ route('formaciones/publicadas') }}">Formaciones</a></li>
          <!--<li class="active"><a href="courses.html">Courses</a></li>
          <li><a href="trainers.html">Trainers</a></li>
          <li><a href="events.html">Events</a></li>
          <li><a href="pricing.html">Pricing</a></li>
          <li class="drop-down"><a href="">Drop Down</a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="drop-down"><a href="#">Deep Drop Down</a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li>
          <li><a href="contact.html">Contact</a></li>
        -->

        </ul>
      </nav><!-- .nav-menu -->

      <!--<a href="courses.html" class="get-started-btn">Get Started</a>-->

    </div>
  </header><!-- End Header -->

  <main id="main" data-aos="fade-in">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
      <div class="container">

      </div>
    </div><!-- End Breadcrumbs -->

    <!-- ======= Courses Section ======= -->
    <section id="courses" class="courses">
      <div class="container" data-aos="fade-up">

        <div  data-aos="zoom-in" data-aos-delay="100">
            <div class="card card-outline card-green" style="width: 80%;">
                <form  id="form_datos"  method="GET" class="text-center">
                    {{ csrf_field() }}


                    <div class="form-row  text-center"   style="margin-top: 3%;">
                        <label for="select_ci" class="col-md-4 col-form-label text-center">Nacionalidad</label>
                        <div class="select2-purple">
                            <select id="select_ci" class="select2" data-placeholder="Seleccione" data-dropdown-css-class="select2-green" style="width: 80%;">
                                <option>V</option>
                                <option>E</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" placeholder="Cedula" type="text" name="ci" id="ci" style="width: 80%;" required>
                        </div>

                    </div>

                    <div class="form-row" style="margin-top: 3%; margin-bottom: 3%;">

                        <label for="codigo" class="col-md-4 col-form-label">Código del Certificado:</label>
                        <div class="col-md-4">
                            <input class="form-control" placeholder="Codigo" type="text" name="codigo" id="codigo" required>
                        </div>


                    </div>



                    <button  class="btn btn-outline-success " id="btn_v" > Verificar</button>

                   <button hidden class="btn btn-outline-success " id="btn_env_datos" type="submit"> Verificar</button>
                </form>
            </div>




        </div>

      </div>
    </section><!-- End Courses Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-8 col-md-6 footer-contact">
            <h3>Universidad de Carabobo</h3>
            <p>
                Av. Bolívar Norte Sede del Rectorado U.C. Valencia Edo. Carabobo.<br>
              <strong>Telefono:</strong> 0241-6004000<br>
              <strong>Email:</strong> secreuc@uc.edu.ve<br>
              <strong>Web:</strong> <a href="http://www.uc.edu.ve" class="">http://www.uc.edu.ve</a><br>
              <a href="http://www.uc.edu.ve" class=""></a>

            </p>
          </div>



        </div>
      </div>
    </div>

    <div class="container d-md-flex py-4">

      <div class="mr-md-auto text-center text-md-left">
        <div class="copyright">
          &copy; Copyright <strong><span>Universidad de Carabobo</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/ -->
          Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
      </div>
      <div class="social-links text-center text-md-right pt-3 pt-md-0">
        <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
        <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="instagram"><i class="fab fa-instagram-square"></i></a>
        <a href="#" class="google-plus"><i class="fab fa-skype"></i></a>
        <a href="#" class="linkedin"><i class="fab fa-linkedin"></i></a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="bx bx-up-arrow-alt"></i></a>
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('mentor/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('mentor/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('mentor/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('mentor/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('mentor/vendor/waypoints/jquery.waypoints.min.js') }}"></script>
  <script src="{{ asset('mentor/vendor/counterup/counterup.min.js') }}"></script>
  <script src="{{ asset('mentor/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('mentor/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
  <!-- Template Main JS File -->
  <script src="{{ asset('mentor/js/main.js') }}"></script>




<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(document).ready(function() {

        $('#select_ci').select2()


    });



// calificacion esta parte es sumamente inifeciente pero por falta tiempo... asi se queda



    $('#btn_v').click(function (e) {
        e.preventDefault();
       // $('#descripcion').val($('#des_retiro').val()); no hace falta
        $('#ci').val($('#select_ci').val()+$('#ci').val());
        $('#btn_env_datos').trigger('click');
        //console.log($('#ci').val())




    });




    $('#form_datos').on('submit', function (event) {

        event.preventDefault();
        $.ajax({

            url: "{{ route('valida/certificado') }}",
            method:"GET",
            data:$(this).serialize(),
            //dataType:"json",
            success:function(data)
            {
                console.log(data);
                $('#ci').val('');
                $('#codigo').val('');

                if(data[0].status==400  ) //Mal/sin encabezado
                {

                    const t= Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-success btn-alert',

                            },
                            buttonsStyling: true
                        })


                    t.fire({
                    title: '<strong>!Datos no validos !</strong>',
                    text: data[1].msj,
                    icon: 'error',

                    confirmButtonText: 'Continuar',
                    width: '35%',
                    timerProgressBar:true,

                    })

                }

            if(data[0].status==200) //Todo perfecto
            {


                const t= Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success btn-alert',

                        },
                        buttonsStyling: false
                    })


                t.fire({
                title: data[1].msj,
                //text: data.success,
                icon: 'success',
                confirmButtonText: 'Continuar',
                width: '35%',
                timerProgressBar:true,
                //timer: 2500
                })


            }


            }
        });

    });


//fin calificacion

//ver certificado
    $('body').on('click', '#btn_ver_c', function (e) {
        e.preventDefault();
        $('#f_id').val($(this).data("id"));
        $('#btn_env_f').trigger('click');
        //console.log($('#f_id').val())
    });

    $('#form_certificado').on('sumit', function () {
        console.log('submit')

    });

//










</script>





</body>




</html>
