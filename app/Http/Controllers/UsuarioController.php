<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function autenticar(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $usuario = Usuario::where('email', $credentials['email'])->first();

        if (!$usuario || !Hash::check($credentials['password'], $usuario->password)) {
            return response()->json([
                'message' => 'Credenciales incorrectas',
            ], 401);
        }

        $token = $usuario->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login exitoso',
            'token' => $token,
            'usuario' => $usuario,
        ], 200);
    }
//Dios es que ni lees el codigo pa DIOSSS
    public function cerrarSesion(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada exitosamente',
        ], 200);
    }
    public function registrarUsuario(Request $request)
    {
         $request->validate([
           'nombres' => 'required|string|max:100',
           'apellidos' => 'required|string|max:100',
           'email' => 'required|email|unique:usuarios,email',
           'password' => 'required|min:6',
           'activo' => 'boolean',
       ]);

         $usuario = Usuario::create([
           'nombres' => $request->nombres,
           'apellidos' => $request->apellidos,
           'email' => $request->email,
           'password' => Hash::make($request->password),
           'activo' => true,
        ]);

         $token = $usuario->createToken('auth_token')->plainTextToken;

         return response()->json([
           'message' => 'Usuario creado correctamente',
            'token' => $token,
            'usuario' => $usuario,
         ], 201);
}
    
}