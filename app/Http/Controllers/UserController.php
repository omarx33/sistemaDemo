<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function __construct(){

    // }

    public function index(Request $request)
    {
        if($request->ajax()){
            $result = DB::select("SELECT u.id,u.nombres,u.apellidos,u.email,u.estado,
             IF(r.name is not null ,r.name, 'Sin rol') rol
            from users u
           left join model_has_roles mhr on u.id = mhr.model_id
           left join roles r on mhr.role_id = r.id");

            return ['data' => $result];
      }
      return view("usuario.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::where('id',$request->id)->first();

        if( $request->password != $request->confirm_password ){
            return [

                'title' => 'Las contraseñas no coinciden',
                'text'  => "Intente nuevamnete",
                'icon'  => 'error'

            ];
            return false; //se detiene el proceso
        }

        if( $user ){ //editar

            $user->update([

                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'email' => $request->email

            ]);
            $user->syncRoles([$request->rol]); //editando rol
            return [

                'title' => 'Registrado',
                'text'  => "El usuario se actualizó con exito",
                'icon'  => 'success'

            ];
        }else{ //registrar

            $validacion_correo = User::where('email',$request->email)->first();

            //dd( $validacion_correo );

            if( $validacion_correo ){
                return [

                    'title' => 'Este correo ya esta registrado',
                    'text'  => "Intente con otro correo",
                    'icon'  => 'error'

                ];
                return false; //se detiene el proceso
            }

          $id =  User::create([

                'nombres' => $request->nombres,
                 'apellidos' => $request->apellidos,
                 'email' => $request->email,
                 'estado' => 1,
                 'password'=> Hash::make( $request->password )

            ])->id; //crea y retorna el id

            $user = User::where("id",$id)->first();
            $user->assignRole($request->rol); //asignando rol

            return [

                'title' => 'Registrado',
                'text'  => "El usuario se registro con exito",
                'icon'  => 'success'

            ];
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $result = DB::table('users')
            ->leftjoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftjoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('users.id', '=', $id)
            ->select('users.nombres','users.apellidos','users.email','users.id',
            'model_has_roles.role_id',
            DB::raw("roles.name rol") )
            ->first();

        return $result;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {

        $active = ( $request->active == 0 ) ? 1 : 0 ;
        User::where('id',$id)->update(['estado'=>$active]);
        return [

            'title' => 'Buen Trabajo',
            'text'  => 'Estado Actualizado',
            'icon'  => 'success'

        ];
    }

    public function listaRoles(Request $request)
    {
        return Role::all();
    }

}
