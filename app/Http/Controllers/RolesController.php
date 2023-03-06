<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;



class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){

            $result =  DB::select("SELECT r.id, r.name roles, COUNT(mhr.model_id) AS user
            FROM roles r
            left join model_has_roles mhr on r.id = mhr.role_id
            GROUP BY r.id, r.name ");

            return ['data' => $result];
         }
         return view("roles.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($request->id) {
            $role = Role::where('id',$request->id)->update(['name'=>$request->rol]);
            return [

                'title' => 'Editado',
                'text'  => "Se edito el rol",
                'icon'  => 'success'

                  ];

        }else{

                $validacion_rol = Roles::where('name',$request->rol)->first();
                if( $validacion_rol ){

                    return [

                        'title' => 'Error',
                        'text'  => "El rol ya existe",
                        'icon'  => 'error'

                    ];

                    return false; // false detendra el evento
                }

                $role = Role::create(['name' => $request->rol]);

                return [

                    'title' => 'Registrado',
                    'text'  => "Se registro el rol",
                    'icon'  => 'success'

                      ];

      }
    }

    /**
     * Display the specified resource.
     */
    public function show(Roles $roles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Roles $roles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Roles $roles)
    {
        return "ok";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Roles $roles,$id)
    {
        $rol_user = DB::table('model_has_roles')
        ->where('role_id','=', $id)
        ->first();

        if( $rol_user ){

            return [

                'title' => 'El rol tiene usuarios',
                'text'  => "Retire los usuarios asignados para eliminar",
                'icon'  => 'error'

            ];

            return false; // false detendra el evento
        }


        $rol_permiso = DB::table('role_has_permissions')
        ->where('role_id','=', $id)
        ->first();

        if( $rol_permiso ){

            return [

                'title' => 'El rol tiene permisos',
                'text'  => "Retire los permisos asignados para eliminar",
                'icon'  => 'error'

            ];

            return false; // false detendra el evento
        }


        Role::where('id',$id)->delete();

        return [

            'title' => 'Eliminado',
            'text'  => "Se elimino el rol",
            'icon'  => "success"

              ];
    }



    public function listadoPermisos(Request $request)
    {
       $permisos = Permission::all();

       $roles = DB::select("SELECT * from role_has_permissions where role_id = $request->idrol ");

     return [
        "permisos" => $permisos,
        "roles" => $roles
     ];

      }

      public function registroRol(Request $request)
      {

        try {
            $rol = Role::where("id",$request->idrol)->first();
            $rol->syncPermissions($request->permisosCheck); //recibe el array de checks y registra
            return [

                'title' => 'Rigistrado',
                'text'  => "Se actualizaron los roles.",
                'icon'  => 'success'

            ];
        } catch (\Throwable $th) {
            return [

                'title' => 'Error',
                'text'  => "Ocurrió un error inesperado consulte con soporte",
                'icon'  => 'error'

            ];
        }


      }

}


