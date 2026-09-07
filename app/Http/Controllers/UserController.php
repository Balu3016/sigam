<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dependencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios del sistema.
     */
    public function index()
    {
        $usuarios = User::with('dependencia')->latest()->get();

        return view('users.index', compact('usuarios'));
    }

    /**
     * Guarda un usuario vía AJAX desde el Modal del Sidebar.
     */
    public function storeModal(Request $request)
    {
        // 1. Verificación de seguridad en el controlador
        if (!auth()->check()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sesión expirada. Inicie sesión para realizar esta acción.'
            ], 401);
        }

        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'No tiene permisos suficientes para dar de alta usuarios.'
            ], 403);
        }

        // 2. Validar los campos del formulario
        $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'dependencia_id' => ['required', 'exists:dependencias,id'],
            'role'           => ['required', 'string', Rule::in(['capturista', 'supervisor', 'admin'])],
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required'         => 'El nombre completo es obligatorio.',
            'email.required'        => 'El correo electrónico es obligatorio.',
            'email.unique'          => 'El correo electrónico ya se encuentra registrado.',
            'dependencia_id.exists' => 'La dependencia seleccionada no es válida.',
            'role.in'               => 'El rol seleccionado no es válido.',
            'password.required'     => 'La contraseña es obligatoria.',
            'password.confirmed'    => 'Las contraseñas no coinciden.',
        ]);

        // 3. Crear el registro de usuario
        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'dependencia_id' => $request->dependencia_id,
            'role'           => strtolower($request->role),
            'password'       => Hash::make($request->password),
        ]);

        // 4. Responder JSON para AJAX
        return response()->json([
            'status'  => 'success',
            'message' => '¡Usuario "' . $user->name . '" dado de alta exitosamente!',
            'user'    => $user
        ], 201);
    }

    /**
     * Muestra el formulario de edición de un usuario.
     */
    public function edit(User $usuario)
    {
        $dependencias = Dependencia::all();
        return view('users.edit', compact('usuario', 'dependencias'));
    }

    /**
     * Actualiza la información del usuario en la base de datos.
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($usuario->id)],
            'dependencia_id' => ['required', 'exists:dependencias,id'],
            'role'           => ['required', 'string', Rule::in(['capturista', 'supervisor', 'admin'])],
        ], [
            'email.unique'          => 'El correo electrónico ya está en uso por otro usuario.',
            'dependencia_id.exists' => 'La dependencia seleccionada no es válida.',
            'role.in'               => 'El rol seleccionado no es válido.',
        ]);

        $data = [
            'name'           => $request->name,
            'email'          => $request->email,
            'dependencia_id' => $request->dependencia_id,
            'role'           => strtolower($request->role),
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            ], [
                'password.confirmed' => 'Las contraseñas no coinciden.',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status'  => 'success',
                'message' => '¡Usuario "' . $usuario->name . '" actualizado exitosamente!'
            ], 200);
        }

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina a un usuario del sistema.
     */
    public function destroy(User $usuario)
    {
        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}