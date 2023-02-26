<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use DB;
use Auth;


class documentoController extends Controller
{
    //
    function index(Request $request){

        //  $users = Auth::user();
        //  dd($users);

            if($request->ajax()){
                  $result = Documento::select(DB::raw("*"))->get();

                  return ['data' => $result];
            }

            return view("documentos.index");
    }

}
