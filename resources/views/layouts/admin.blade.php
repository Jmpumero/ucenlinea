<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>UVC-TESIS </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">

  <!-- Ionicons cdn-->
  <!--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
-->
  <!-- jQuery cdn -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
    <script>window.jQuery || document.write('<script src="/adminlte/plugins/jquery/jquery.min.js"><\/script>')</script>

    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!--sweetalert-->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    <!--JQUERY UI CDN-->
  <!--<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">-->


  <!--DATA TABLE-->
    <!--cdn-->
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-scroller/css/scroller.bootstrap4.min.css') }}">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.css') }}">

  <!-- Personalizado style -->
  <link rel="stylesheet" href="{{ asset('adminlte/css/extras.css') }}">

  <!-- overlayScrollbars -->
  <!--<link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">-->
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.css') }}">

  <link href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
  <!-- Google Font: Source Sans Pro -->
  <!--<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">-->
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
          <!-- Left navbar links -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
              <a href="index3.html" class="nav-link ">Inicio</a>
            </li>

          </ul>

          <!-- SEARCH FORM -->
          <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </form>




          <!-- Right navbar links -->
          <ul class="navbar-nav ml-auto"  >
            <!-- Messages Dropdown Menu -->

            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell fa-lg text-white"></i>
                <span class="badge badge-danger navbar-badge">15</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="fas fa-envelope mr-2"></i> 4 nuevas pruebas
                  <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="fas fa-users mr-2"></i> 8 nuevas formaciones
                  <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="fas fa-file mr-2"></i> 3 nuevos etc
                  <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
              </div>
            </li>


            <!--USER-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset(Auth::user()->avatar) }}" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">{{ Auth::user()->name }} </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-white">
                  <img src="{{ asset(Auth::user()->avatar) }}" class="img-circle elevation-2" alt="User Image">
                    <!-- NO ESTA TERMINADO-->
                  <p>
                    Empresa - <strong> </strong>
                    <small>Member since Nov. 2012</small>
                  </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">

                  <!-- /.row -->
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>

                  <a class="btn btn-default btn-flat float-right" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                </li>
              </ul>
            </li>



            <!--interesante
            <li class="nav-item">
              <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                <i class="fas fa-th-large"></i>
              </a>
            </li>
            -->
          </ul>
        </nav>
        <!-- /.navbar -->



        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
          <!-- Brand Logo -->
          <a href="index3.html" class="brand-link">
            <img src="{{ asset('adminlte/img/logos/UC_logo.png') }}" alt="Logo" class="navbar-brand-image  elevation-3"
            width="60" height="70" alt="" style="margin: auto;">
            <span class="brand-text font-weight-light" style="font-size: 1rem;"></span>
          </a>

          <!-- Sidebar -->
          <div class="sidebar">

            <!-- Sidebar Menu -->
            <nav class="mt-2 bg-dark">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                    <!--Notificaciones para todos-->
                     <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                        <i class="far fa-envelope fa-lg text-green"></i>
                        <p>
                          Notificaciones
                          <i class="fas fa-angle-left right"></i>
                          <span class="badge badge-danger right">15</span>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="v_not_rp_est.html" class="nav-link">
                            <i class="fas fa-user-graduate"></i>
                            <p>Estudiantes</p>
                            <span class="badge badge-warning right">10</span>
                          </a>
                        </li>

                      </ul>

                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="v_not_rp_prove.html" class="nav-link">
                            <i class="fas fa-pencil-alt"></i>
                            <p>Inscripciones</p>
                            <span class="badge badge-primary right">5</span>
                          </a>
                        </li>

                      </ul>
                    </li>



                    <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                        <i class="fas fa-user-friends"></i>
                        <p>
                          Formaciones
                          <i class="fas fa-angle-left right"></i>
                        </p>
                      </a>

                      <ul class="nav nav-treeview">
                        @can('inscribir estudiantes en formacion')
                            <li class="nav-item">
                            <a href= "{{ route('inscribir/estudiantes') }}" class="nav-link">
                                <i class="fas fa-clipboard-check"></i>

                                <p>Postular personal</p>
                            </a>
                            </li>
                        @endcan

                        @can('matricular estudiantes en moodle')
                            <li class="nav-item">
                            <a href= "{{ route('matricular/estudiantes') }}" class="nav-link">
                                <i class="fas fa-university"></i>

                                <p>Matricular Formación</p>
                            </a>
                            </li>
                        @endcan


                        @hasrole('Proveedor')
                        <li class="nav-item">
                        <a href= "{{ route('matricula/formacion/externa') }}" class="nav-link">
                            <i class="fas fa-university"></i>

                            <p>Matricular Formación E.</p>
                        </a>

                        <a href= "{{ route('formaciones/m/externa') }}" class="nav-link">
                            <i class="fas fa-cloud-download-alt"></i>

                            <p> Descargar matricula </p>
                        </a>
                        </li>
                        @endhasrole


                        @hasrole('Facilitador')
                        <li class="nav-item">

                        <a href= "{{ route('formaciones/m/facilitador') }}" class="nav-link">
                            <i class="fas fa-cloud-download-alt"></i>

                            <p> Descargar matricula </p>
                        </a>
                        </li>
                        @endhasrole


                        @hasrole('Estudiante')
                        <li class="nav-item">

                        <a href= "{{ route('est/formaciones/certificadas') }}" class="nav-link">
                            <i class="fas fa-award"></i>
                            <i class="fas fa-file-invoice"></i>

                            <p> Certificados </p>
                        </a>
                        </li>
                        @endhasrole

                        <!--<li class="nav-item">
                          <a href="modform.html" class="nav-link">
                            <i class="far fa-edit"></i>
                            <p>Modificar inscripción</p>
                          </a>
                        </li>-->

                      </ul>
                    </li>


                    <li class="nav-item has-treeview">
                      <a href="rpretiro_estudiante.html" class="nav-link">
                        <i class="fas fa-user-minus text-danger-borde2 icon-mg-sm"></i>
                        <p>
                          Retirar estudiante

                        </p>
                      </a>

                    </li>

                    <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                        <i class="far fa-folder-open"></i>
                        <p>
                          Marco regulatorio
                          <i class="fas fa-angle-left right"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="rpinscripcion1.html" class="nav-link">
                            <i class="far fa-file"></i>

                            <p>documento1</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="#" class="nav-link">
                            <i class="far fa-file"></i>
                            <p>etc</p>
                          </a>
                        </li>

                      </ul>
                    </li>

                <li class="nav-header">EXAMPLES</li>
                <li class="nav-item">
                  <a href="pages/calendar.html" class="nav-link">
                    <i class="nav-icon far fa-calendar-alt"></i>
                    <p>
                      Calendar
                      <span class="badge badge-info right">2</span>
                    </p>
                  </a>
                </li>

              </ul>
            </nav>
            <!-- /.sidebar-menu -->
          </div>
          <!-- /.sidebar -->
        </aside>






        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <div class="content-header ">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h3 class="m-0 text-dark"></h3>
                </div><!-- /.col -->
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>

                  </ol>
                </div><!-- /.col -->
              </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </div>
          <!-- /.content-header -->

          <!-- Main content -->
          <div class="content">
            <div class="container-fluid">
                <main class="content">
                    @yield('content')
                </main>

              <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </div>
          <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->






        <footer class="main-footer">
          <strong>Copyright &copy; 2019 <a href="#">Universidad de Carabobo</a>.</strong>
          All rights reserved.
          <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
          </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
          <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
      </div>
      <!-- ./wrapper -->
<!-- ./wrapper -->




<!--datatable jquery-->

<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>

<!--<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>-->



<!-- CDN  para el ranting-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>


<!-- jQuery UI 1.11.4 -->
<!--cdn-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>-->
<script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS adminlte/-->
<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparklinadminlte/e -->
<script src="{{ asset('adminlte/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -adminlte/->
<script src="adminlte/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Kadminlte/nob Chart -->
<script src="{{ asset('adminlte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangadminlte/epicker -->
<script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdoadminlte/minus Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernoadminlte/te -->
<script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars
<script src="{{ ('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>-->

<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>



<script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>-->

<!-- AdminLTE App -->
<script src="{{ asset('adminlte/js/adminlte.js') }}"></script>
<!--para iconos ionic -->
<!--<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>-->



</body>
</html>
