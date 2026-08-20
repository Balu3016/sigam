<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Guarda un usuario vía AJAX desde el Modal del Sidebar.
     */
    public function storeModal(Request $request)
    {
        // Validar los campos del formulario
        $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'dependencia_id' => ['required', 'exists:dependencias,id'],
            'role'           => ['required', 'string'],
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.unique'          => 'El correo electrónico ya se encuentra registrado.',
            'dependencia_id.exists' => 'La dependencia seleccionada no es válida.',
            'password.confirmed'   => 'Las contraseñas no coinciden.',
        ]);

        // Crear el registro de usuario
        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'dependencia_id' => $request->dependencia_id,
            'role'           => $request->role,
            'password'       => Hash::make($request->password),
        ]);

        // Responder JSON para AJAX
        return response()->json([
            'status'  => 'success',
            'message' => '¡Usuario "' . $user->name . '" dado de alta exitosamente!'
        ], 200);
    }
}