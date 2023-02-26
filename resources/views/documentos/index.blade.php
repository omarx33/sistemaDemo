
@extends("layouts.plantilla")

@section("contenido")


<div class="card">
    <div class="card-header">
      <h3 class="card-title">DataTable with default features</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Rendering engine</th>
          <th>Browser</th>
          <th>Platform(s)</th>
          <th>Engine version</th>

        </tr>
        </thead>


      </table>
    </div>
    <!-- /.card-body -->
  </div>



@endsection

@section("script")
  <!-- Page specific script -->
  <script>


    $(function () {

    $("#example1").DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print', "colvis"
        ],
    ajax:{
            url:'{{route('documentos.index')}}',
            type:'GET'
        },
        columns:[
            {data:"id"},
            {data:"descripcion"},
            {data:"tipo"},
            {data:"estado"}
        ]
    });

    });
  </script>
@endsection
