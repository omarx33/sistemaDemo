
@extends("layouts.plantilla")

@section("contenido")






  <div class="card">
    <div class="card-header">
      <h3 class="card-title">DataTable with default features</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="consulta" class="table table-bordered table-striped">

      </table>
    </div>
    <!-- /.card-body -->
  </div>


@endsection

@section("script")
  <!-- Page specific script -->
  <script>


    $(function () {

        $("#consulta").DataTable({
            "language":{
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
},
iDisplayLength: 10, //cambiar la cantidad de filas a mostrar
        deferRender:true,
        bProcessing: true,//para que carge en paralelo se aga mas rapida
        bAutoWidth: false, //para que funcione el responsive
        destroy:true,

  ajax: {
    url: '{{ route('user.index') }}',
    type: 'GET'
  },

  columns: [
    { title: "ID", data: "id" },
    { title: "NOMBRES", data: "nombres" },
    { title: "APELLIDOS", data: "apellidos" },
    { title: "APELLIDOS", data: "apellidos" },
    { title: "ESTADO", data: "estado" }
  ],
  responsive: {
    details: {
      type: 'column'
    }
  }
});


    });
  </script>
@endsection
