
@extends("layouts.plantilla")

@section("titulo")
Usuarios
@endsection

@section("style")
<style>

/* estylos css */

</style>
@endsection

@section("contenido")


  <div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-primary btn-agregar"><i class="fa fa-plus"></i> Agregar</button>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="consulta" class="table table-bordered table-striped">

      </table>
    </div>
    <!-- /.card-body -->
  </div>



<!-- Modal Agregar/Actualizar -->
<form id="registro" autocomplete="off">
    <div class="modal fade" id="modal-registro">
        <div class="modal-dialog modal-lg">
         <div class="modal-content">
           <div class="modal-header">
       <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body">

         @csrf

         <input type="hidden" name="id" class="id">

         <div class="form-row">
            <div class="form-group col-md-6">
                <label>NOMBRE </label>
                <input type="text" name="nombres" class="nombres form-control" placeholder="Ingrese Nombre" required>
            </div>
            <div class="form-group col-md-6">
                <label>APELLIDO </label>
                <input type="text" name="apellidos" class="apellidos form-control" placeholder="Ingrese Apellido" required>
            </div>
            <div class="form-group col-md-6">
                <label>EMAIL </label>
                <input type="email" name="email" class="email form-control" placeholder="Ingrese Email" required>
            </div>
            <div class="form-group col-md-6">
                <label>ROL </label>
                <select name="rol" class="rol form-control"></select>
            </div>

            <div class="form-group col-md-6 div_password">
                <label>CONTRASEÑA </label>
                <input type="password" name="password" class=" form-control" placeholder="Ingrese Contraseña" >
            </div>
            <div class="form-group col-md-6 div_password">
                <label>CONFIRME CONTRASEÑA </label>
                <input type="password" name="confirm_password" placeholder="Repita Contraseña" class=" form-control" >
            </div>
         </div>



     </div>
     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
       <button type="submit" class="btn btn-primary btn-submit">Save changes</button>
     </div>
   </div>
 </div>
</div>
</form>



@endsection

@section("script")
  <!-- Page specific script -->
  <script>

$(document).ready(function(){
    loadData ();


    $.ajax({ //carga los roles
            url:'{{ route('user.listaRoles') }}',
            type:'POST',
            data:{'_token':'{{ csrf_token() }}'},
           // dataType:'JSON',
            success:function(data){
                var html ="<option value=''>Seleccione...</option>";  //
              data.forEach((item, i) => {

  html += "<option value='"+item.id+"'>"+item.name+"</option>";

              });
  $(".rol").html( html );

            }
          });


});


    //agregar
    $(document).on('submit','#registro',function(e){
    parametros = $(this).serialize();

   $.ajax({
     url:'{{route('user.store')}}',
     type:'POST',
     data:parametros,

        beforeSend:function(){
            Swal.fire({
                title : "Cargando ... !",
                text : "Espere",
                showConfirmButton : false
                 })
        },
     success:function(data){
         if (data.icon == 'success') {
             loadData();
         }

          $('#modal-registro').modal('hide');
                 Swal.fire({
                title : data.title,
                text : data.text,
                icon : data.icon,
                timer : 3000,
                showConfirmButton : false
                            });

     }
   });

 e.preventDefault();
});


$(document).on('click','.btn-agregar',function(){
    $('.div_password').show();
		$('#registro')[0].reset();
		$('.id').val('');
		$('.modal-title').html('Registrar Usuario');
		$('.btn-submit').html('Registrar');
		$('#modal-registro').modal('show');
	});


    function loadData () {

        $("#consulta").DataTable({
            "language":{
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
},
iDisplayLength: 10, //cambiar la cantidad de filas a mostrar
        deferRender:true,
        bProcessing: true,//para que carge en paralelo se aga mas rapida
        bAutoWidth: false, //para que funcione el responsive
        destroy:true,
        "order": [[ 0, "desc" ]],
  ajax: {
    url: '{{ route('user.index') }}',
    type: 'GET'
  },

  columns: [
    { title: "ID", data: "id" },
    { title: "NOMBRES", data: "nombres" },
    { title: "APELLIDOS", data: "apellidos" },
    { title: "ROL", data: "rol" },
    { title: "CORREO", data: "email" },
    { title: "ESTADO", data: "estado" },
    { title: "ACCIONES", data:null,render:function(data){
					if( data.estado == 1 ){
						btn_active = `<button
						data-id = "${data.id}"
                        data-active = "${data.estado}";
						class="btn btn-success btn-sm btn-delete"><i class="fa fa-thumbs-up"></i></button>`;
					}else{
						btn_active = `<button
						data-id = "${data.id}"
                        data-active = "${data.estado}";
						class="btn btn-danger btn-sm btn-delete"><i class="fa fa-thumbs-down"></i></button>`;
					}
					return `
                    <div class="btn-group" role="group" aria-label="Basic example">
                    <button
						data-id = "${data.id}"
						class="btn btn-primary btn-sm btn-edit"><i class="fas fa-pencil-alt"></i></button>
						${btn_active}
                    </div>
					`;
				}}
  ],
  "columnDefs":[
			{
				"targets":[5],
				"data":"estado",
				"render":function(data,type,row){
					if(row.estado!=0){
						return `<span class="badge badge-success ">ACTIVO</span>`;
					}else {
            		return ` <span class="badge badge-danger ">INACTIVO</span>`;
          }

				}
			}

		],
  responsive: {
    details: {
      type: 'column'
    }
  }
});


 };
 //btn editar
 $(document).on('click','.btn-edit',function(){
    $('.div_password').hide();

        $('#modal-registro').modal('show');
        $('.modal-title').html('Editar Usuario');
		$('.btn-submit').html('Editar');


        id =  $(this).data('id');

        var url_edit = '{{ route("user.edit", ":id") }}';
		url_edit 	 = url_edit.replace(':id', id);
        	//Cargar Datos
		$.ajax({
			url:url_edit,
			type:'GET',
			data:{},
			dataType:'JSON',
			success:function(result){
				$('.nombres').val( result.nombres );
                $('.apellidos').val( result.apellidos );
                $('.email').val( result.email );
                $('.rol').val( result.role_id );
                $('.id').val( result.id );
			}
		});


    });


	//Cargar Modal Eliminar
	$(document).on('click','.btn-delete',function(){
		id =  $(this).data('id');
		active = $(this).data('active');
		Swal.fire({
		  title: 'Activar/Desactivar',
		  text: "Está opción cambiará el estado del Usuario ",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Confirmar',
		  cancelButtonText : 'Cancelar',
		}).then((result) => {
		  if (result.isConfirmed) {
			var url_destroy = '{{ route("user.destroy", ":id") }}';
			url_destroy 	= url_destroy.replace(':id', id);
		  	$.ajax({
		  		url:url_destroy,
		  		type:'DELETE',
		  		data:{'id':id,'active':active,'_token':'{{ csrf_token() }}'},
		  		dataType:'JSON',
		  		beforeSend:function(){
					Swal.fire({
						title:'Cargando',
						text :'Espere un momento...',
                        imageUrl:'{{ asset('public/img/loader.gif') }}',
						showConfirmButton:false
					});
		  		},
		  		success:function(result){
				 if( result.icon == 'success' ){
				  loadData();
				 }
				Swal.fire({
					title : result.title,
					text  : result.text,
					icon  : result.icon,
					timer : 3000,
					showConfirmButton:false
				});
		  		}
		  	});
		  }
		});
	});

  </script>
@endsection
