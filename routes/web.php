<?php
use App\Http\Controllers\documentoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use Illuminate\Support\Facades\Route;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', function () {

   // para dar permisos

    //  $user = User::where("id",1)->first();
    //  $user->assignRole('soporte');

     //$user->removeRole('soporte');
    //  $user = Role::where("name","soporte")->first();

    //   $user->givePermissionTo(1);
     // $user->revokePermissionTo(3);

    //  $user = Role::where("name","soporte")->first();
    // return $user->hasPermissionTo(2);

  //  $permission = Permission::create(['name' => 'Roles']);

});


Route::get("/documentos",[documentoController::class,"index"])
                        ->middleware('can:Documentos')
                        ->name("documentos.index");

Auth::routes();

Route::group(['middleware' => ['can:Usuarios']], function () {
    Route::resource('user', UserController::class)->middleware('auth');
});

Route::group(['middleware' => ['can:Roles']], function () {
    Route::resource('rol', RolesController::class)->middleware('auth');
});
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('listaRol', [RolesController::class, 'listadoPermisos'])->middleware('can:Roles')->name('roles.listadoPermisos');

Route::post('registroRol', [RolesController::class, 'registroRol'])->middleware('can:Roles')->name('roles.registroRol');

Route::post('listaRoles', [UserController::class, 'listaRoles'])->middleware('can:Roles')->name('user.listaRoles');
