<?php

namespace App\Http\Controllers;

use App\Models\ProgramaSocial;
use App\Http\Requests\StoreProgramaSocialRequest;
use App\Http\Requests\UpdateProgramaSocialRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProgramaSocialController extends Controller
{
    /**
     * Muestra el listado de programas sociales con filtro de búsqueda y paginación.
     */
    public function index(Request $request): View
    {
        $search = trim($request->get('search', ''));

        $programas = ProgramaSocial::query()
            ->when($search, function ($query, $search) {
                $query->where('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('codigo', 'LIKE', "%{$search}%")
                      ->orWhere('categoria', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('programas.index', compact('programas', 'search'));
    }

    /**
     * Muestra el formulario para crear un nuevo programa social.
     */
    public function create(): View
    {
        return view('programas.create');
    }

    /**
     * Almacena un programa social recién creado en la base de datos.
     */
    public function store(StoreProgramaSocialRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Filtrar elementos vacíos dentro del arreglo de requisitos
        if (isset($validated['requisitos']) && is_array($validated['requisitos'])) {
            $validated['requisitos'] = array_values(array_filter($validated['requisitos'], function ($item) {
                return !is_null($item) && trim($item) !== '';
            }));
        }

        ProgramaSocial::create($validated);

        return redirect()
            ->route('programas-sociales.index')
            ->with('success', 'El Programa Social fue registrado correctamente.');
    }

    /**
     * Muestra el detalle de un programa social específico.
     */
    public function show(ProgramaSocial $programaSocial): View
    {
        return view('programas.show', [
            'programa' => $programaSocial
        ]);
    }

    /**
     * Muestra el formulario para editar un programa social existente.
     */
    public function edit(ProgramaSocial $programaSocial): View
    {
        return view('programas.edit', [
            'programa' => $programaSocial
        ]);
    }

    /**
     * Actualiza el programa social especificado en la base de datos.
     */
    public function update(UpdateProgramaSocialRequest $request, ProgramaSocial $programaSocial): RedirectResponse
    {
        $validated = $request->validated();

        // Filtrar elementos vacíos dentro del arreglo de requisitos
        if (isset($validated['requisitos']) && is_array($validated['requisitos'])) {
            $validated['requisitos'] = array_values(array_filter($validated['requisitos'], function ($item) {
                return !is_null($item) && trim($item) !== '';
            }));
        }

        $programaSocial->update($validated);

        return redirect()
            ->route('programas-sociales.index')
            ->with('success', 'El Programa Social fue actualizado correctamente.');
    }

    /**
     * Cambia el estado del programa social (Borrado Lógico SIGAM).
     */
    public function destroy(ProgramaSocial $programaSocial): RedirectResponse
    {
        $nuevoEstado = !$programaSocial->activo;
        $programaSocial->update(['activo' => $nuevoEstado]);

        $mensaje = $nuevoEstado 
            ? 'El Programa Social ha sido reactivado exitosamente.' 
            : 'El Programa Social ha sido deshabilitado correctamente.';

        return redirect()
            ->route('programas-sociales.index')
            ->with('success', $mensaje);
    }
}