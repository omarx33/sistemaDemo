
@extends("layouts.plantilla")

@section("titulo")
Roles
@endsection

@section("style")
<style>

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  td, th{
    /* border-bottom: 1px solid #dddddd; */
    text-align: left;
    padding: 8px;
  }
</style>
  @endsection

@section("contenido")


  <div class="card">
    <div class="card-header">

      <button type="button" class="btn btn-primary btn-agregar"><i class="fa fa-plus"></i> Agregar</button>
    </div>
    <!-- /.card-header -->
    <div class="card-body" >
      <table id="consulta"  class="table table-bordered table-striped">

      </table>
    </div>
    <!-- /.card-body -->
  </div>

	<!-- Modal Agregar/Actualizar -->
	<form id="registro" autocomplete="off">
             <div class="modal fade" id="modal-registro">
                <div class="modal-dialog">
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



			     	<div class="form-group col-md-12">
			     		<label>NOMBRE ROL</label>
			     		<input type="text" name="rol" class="rol form-control" required>
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


    <!-- Modal Permisos -->
	<form id="permisos" autocomplete="off">
        <div class="modal fade" id="modal-permisos">
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
           <h5 class="modal-title-rol" id="exampleModalLabel">Modal title</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">

             @csrf
                <input type="hidden" name="id-rol" class="id-rol">
             <div class="form-row"  >
                <div class="form-group col-md-12">
                    <div class="table-responsive">
                        <table id="listaroles" >

                        </table>


                    </div>
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


        loadData();

        checks ();



    });

    function checks (){ // dar formato a los check
        $("input[data-bootstrap-switch]").each(function(){
         $(this).bootstrapSwitch('state', $(this).prop('checked'));
         })
    }


    function loadData() {
      var t =  $("#consulta").DataTable({
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
    url: '{{ route('rol.index') }}',
    type: 'GET'
  },

  columns: [
    { title: "ID", data: "id" },
    { title: "ROL", data: "roles" },
    { title: "USOS", data: "user" },
    {title: "ACCIONES",data:null,render:function(data){
         return `
         <div class="btn-group" role="group" aria-label="Basic example">
         <button
   			  data-idrol="${data.id}" data-nombrerol="${data.roles}"
   			  class="btn btn-success btn-sm btn-permisos">
                 <i class="fas fa-lock"></i>
   			  </button>

   			  <button
   			  data-id="${data.id}" data-namerol="${data.roles}"
   			  class="btn btn-primary btn-sm btn-actualizar">
                 <i class="fas fa-edit"></i>
   			  </button>
   			  <button
   			   data-id="${data.id}"
   			  class="btn btn-danger btn-sm btn-delete">
   			  <i class="fa fa-trash"></i>
   			  </button>
                 </div>
   	 	  	 `;
          }}
  ],
    "columnDefs":[
			{
				"targets":[2],
				"data":"user",
				"render":function(data,type,row){
					if(row.user!=0){
						return `<span class="badge badge-success ">${row.user}</span>`;
					}else {
            		return ` <span class="badge badge-danger ">${row.user}</span>`;
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


    }

	$(document).on('click','.btn-agregar',function(){
		$('#registro')[0].reset();
		$('.id').val('');
		$('.modal-title').html('Agregar Rol');
		$('.btn-submit').html('Agregar');
		$('#modal-registro').modal('show');
	});

	$(document).on('click','.btn-actualizar',function(){

        $('#modal-registro').modal('show');
        $('.modal-title').html('Editar Rol');
		$('.btn-submit').html('Editar');
        $('.id').val($(this).data('id'));
        $('.rol').val($(this).data('namerol'));
    });

    $(document).on('click','.btn-permisos ',function(){
        $("#listaroles").html( "");
        $('#modal-permisos').modal('show');
        $('.id-rol').val($(this).data('idrol'));
         $('.modal-title-rol').html('Rol: '+ $(this).data('nombrerol'));
		 $('.btn-submit').html('Guardar');


        $.ajax({
                  url:'{{ route('roles.listadoPermisos') }}',
                  type:'POST',
                  data:{'_token':'{{ csrf_token() }}',idrol:$(this).data('idrol')},
                  dataType:'JSON',

                  success:function(data){

        var html ="";

                 data.permisos.map((permiso) => {
            // Buscar el rol correspondiente para el permiso actual
            const rol = data.roles.find((r) => r.permission_id === permiso.id);
            html += `<tr>
                    <td>${permiso.name}</td>
                    <td class="float-right" >`

                html +=   rol ?
                            `<input type="checkbox" value="${permiso.id}" checked name="checkPermiso[]" data-bootstrap-switch data-off-color="danger" data-off-text="NO" data-on-color="success" data-on-text="SI">`
                            :
                            `<input type="checkbox" value="${permiso.id}" name="checkPermiso[]" data-bootstrap-switch data-off-color="danger" data-off-text="NO" data-on-color="success" data-on-text="SI">`;
                 html += `</td>
                            </tr>`;

            });

                $("#listaroles").html( html );
                   checks();

                  }
                });

    });

     $(document).on('submit','#permisos',function(e){
        // formPermisos = $(this).serialize();
      let idrol = $('.id-rol').val();


        let permisosCheck = [];
    $('[name="checkPermiso[]"]:checked').each(function(){

        estados = this.value;
        permisosCheck.push(estados);

    });

    $.ajax({
        url:'{{ route('roles.registroRol') }}',
     type:'POST',
     data:{'_token':'{{ csrf_token() }}',permisosCheck,idrol},
      dataType:'JSON',

     success:function(data){
        if (data.icon == 'success') {
            loadData();
        };
        $('#modal-permisos').modal('hide');
        Swal.fire({
   title : data.title,
   text : data.text,
   icon : data.icon,
   timer : 2000,
   showConfirmButton : false
                });



     }
   });


        e.preventDefault();
    });

    //agregar
$(document).on('submit','#registro',function(e){
    parametros = $(this).serialize();

   $.ajax({
     url:'{{route('rol.store')}}',
     type:'POST',
     data:parametros,
      dataType:'JSON',
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




	//Cargar Modal Eliminar
	$(document).on('click','.btn-delete',function(){
		id =  $(this).data('id');

		Swal.fire({
		  title: 'Eliminar',
		  text: "Está opción eliminará el Rol",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Confirmar',
		  cancelButtonText : 'Cancelar',
		}).then((result) => {
		  if (result.isConfirmed) {
			var url_destroy = '{{ route("rol.destroy", ":id") }}';
			url_destroy 	= url_destroy.replace(':id', id);
		  	$.ajax({
		  		url:url_destroy,
		  		type:'DELETE',
		  		data:{'id':id,'_token':'{{ csrf_token() }}'},
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
