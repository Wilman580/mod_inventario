<?php

namespace mod_inventario\Http\Controllers;

use Illuminate\Http\Request;
//use mod_inventario\Http\Requests;
use mod_inventario\User;
use Illuminate\Support\Facades\Redirect;
use mod_inventario\Http\Requests\UsuarioFormRequest;
use DB;
class BodegueroController extends Controller
{
   public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {

        if ($request) {
            $query = trim($request->get('searchText'));
        $usuarios = DB::table('users')->where('id_tipoUsu','=','2','and','name', 'LIKE', '%' . $query . '%')
                    ->orderBy('id', 'asc')
                    ->paginate(7);
            return view('inventario.bodeguero.index', ["usuarios" => $usuarios,
                "searchText" => $query]);
//            
        }
    }

    public function create() {
        return view("inventario.usuario.create");
    }

    public function store(UsuarioFormRequest $request) {
        $usuario = new User;
        $usuario->cedula = $request->get('cedula');
        $usuario->id_tipoUsu = $request->get('tipo');
        $usuario->name = $request->get('name');
        $usuario->fechaNac = $request->get('fechaNac');
        $usuario->ciudadNac = $request->get('ciudadNac');
        $usuario->direccion = $request->get('direccion');
        $usuario->telefono = $request->get('telefono');
        $usuario->estado = $request->get('estado');
        $usuario->email = $request->get('email');
        $usuario->password = bcrypt($request->get('password'));
        $usuario->save();
        return Redirect::to("inventario/usuario");
    }

    public function show() {
        
    }

    public function edit($id) {
        return view("inventario.usuario.edit", ["usuario" =>User::findOrFail($id)]);
    }

    public function update(UsuarioFormRequest $request, $id) {
        $usuario = User::findOrFail($id);
        $usuario->cedula = $request->get('cedula');
        $usuario->name = $request->get('name');
        $usuario->fechaNac = $request->get('fechaNac');
        $usuario->ciudadNa = $request->get('ciudadNa');
        $usuario->direccion = $request->get('direccion');
        $usuario->telefono = $request->get('telefono');
        $usuario->tipo = $request->get('tipo');
        $usuario->email = $request->get('email');
        $usuario->password = bcrypt($request->get('password'));
        $usuario->update();
        return Redirect::to('inventario/usuario');
    }

    public function destroy($id) {
        $usuario = DB::table('users')->where('id', '=', $id)->delete();
        return Redirect::to('inventario/usuario');
    }  
}
