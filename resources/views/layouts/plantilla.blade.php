<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Blank Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome v5
    usar la version free
    https://fontawesome.com/v5/search?o=r&m=free
-->
  <link rel="stylesheet" href="public/adminlte/plugins/fontawesome-free/css/all.min.css">

 <!-- SweetAlert2 -->
 <link rel="stylesheet" href="public/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
 <!-- Toastr -->
 <link rel="stylesheet" href="public/adminlte/plugins/toastr/toastr.min.css">

 <!-- Select2 -->
 <link rel="stylesheet" href="public/adminlte/plugins/select2/css/select2.min.css">
 <link rel="stylesheet" href="public/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
 <!-- Bootstrap4 Duallistbox -->
 <link rel="stylesheet" href="public/adminlte/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="public/adminlte/plugins/bs-stepper/css/bs-stepper.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="public/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="public/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="public/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="public/adminlte/dist/css/adminlte.min.css">

  @yield("style")

</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>


    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">


          <li class="nav-item dropdown">

            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->nombres }}
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                @can('Roles')
                <a class="dropdown-item" href="{{route('rol.index')}}"><i class="fas fa-cogs"></i> Roles</a>
                @endcan
                @can('Usuarios')
                <a class="dropdown-item"  href="{{route('user.index')}}"><i class="fas fa-users"></i> Usuarios  </a>
                @endcan

                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();"> <i class="fas fa-power-off"></i>
                   Salir
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>


            </div>
        </li>


    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="public/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar"><br>
      <!-- Sidebar user (optional) -->
      {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="public/adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div> --}}


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Inicio
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>



            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="{{ route('home')  }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inicio</p>
                </a>
              </li>


            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Forms
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">


              @can('Reportes')
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reportes r</p>
                </a>
              </li>
              @endcan

              @can('Usuarios')
              <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Usuarios u</p>
                </a>
              </li>
              @endcan



            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Tables
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
                @can('Documentos')
               <li class="nav-item">
                <a href="{{ route('documentos.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Documentos d</p>
                </a>
              </li>
              @endcan
              @can('Usuarios')
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DataTables u</p>
                </a>
              </li>
              @endcan
            </ul>
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
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
           <div class="col-sm-6">
            <h1>
                @yield("titulo")
            </h1>
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

    @yield("contenido")

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="public/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="public/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="public/adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="public/adminlte/plugins/toastr/toastr.min.js"></script>
<!-- Select2 -->
<script src="public/adminlte/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="public/adminlte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- Bootstrap Switch -->
<script src="public/adminlte/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="public/adminlte/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="public/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="public/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="public/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="public/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="public/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="public/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="public/adminlte/plugins/jszip/jszip.min.js"></script>
<script src="public/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
<script src="public/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
<script src="public/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="public/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="public/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- AdminLTE App -->
<script src="public/adminlte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="public/adminlte/dist/js/demo.js"></script> --}}

@yield("script")
<script>
    /*** add active class and stay opened when selected ***/
var url = window.location;

// for sidebar menu entirely but not cover treeview
$('ul.nav-sidebar a').filter(function() {
    if (this.href) {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }
}).addClass('active');

// for the treeview
$('ul.nav-treeview a').filter(function() {
    if (this.href) {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }
}).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
    </script>

</body>
</html>
