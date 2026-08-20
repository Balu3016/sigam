<?php

namespace App\Http\Controllers;

use App\Models\Localidad;
use App\Http\Requests\StoreLocalidadRequest;
use App\Http\Requests\UpdateLocalidadRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class LocalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     * Muestra el listado paginado de localidades con opción de filtro por búsqueda.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $localidades = Localidad::query()
            ->when($search, function ($query, $search) {
                return $query->where('nombre', 'LIKE', "%{$search}%")
                             ->orWhere('codigo_postal', 'LIKE', "%{$search}%");
            })
            ->orderBy('nombre', 'asc')
            ->paginate(15)
            ->withQueryString();

        return view('localidades.index', compact('localidades', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     * Muestra el formulario para registrar una nueva localidad.
     */
    public function create(): View
    {
        return view('localidades.create');
    }

    /**
     * Store a newly created resource in storage.
     * Guarda una nueva localidad utilizando los datos validados del Form Request.
     */
    public function store(StoreLocalidadRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Localidad::create([
            'nombre' => $validated['nombre'],
            'tipo' => $validated['tipo'],
            'codigo_postal' => $validated['codigo_postal'],
            'clasificacion_zonal' => $validated['clasificacion_zonal'],
            'activo' => true,
        ]);

        return redirect()
            ->route('localidades.index')
            ->with('success', 'Localidad registrada exitosamente en el catálogo municipal.');
    }

    /**
     * Display the specified resource.
     * Muestra los detalles de una localidad específica.
     */
    public function show(Localidad $localidad): View
    {
        return view('localidades.show', compact('localidad'));
    }

    /**
     * Show the form for editing the specified resource.
     * Muestra el formulario para editar una localidad existente.
     */
    public function edit(Localidad $localidad): View
    {
        return view('localidades.edit', compact('localidad'));
    }

    /**
     * Update the specified resource in storage.
     * Actualiza la información de una localidad utilizando datos validados.
     */
    public function update(UpdateLocalidadRequest $request, Localidad $localidad): RedirectResponse
    {
        $validated = $request->validated();

        $localidad->update([
            'nombre' => $validated['nombre'],
            'tipo' => $validated['tipo'],
            'codigo_postal' => $validated['codigo_postal'],
            'clasificacion_zonal' => $validated['clasificacion_zonal'],
            'activo' => $request->has('activo') ? (bool) $validated['activo'] : $localidad->activo,
        ]);

        return redirect()
            ->route('localidades.index')
            ->with('success', 'Información de la localidad actualizada correctamente.');
    }

    /**
     * Remove (Deactivate) the specified resource from storage.
     * Borrado lógico SIGAM: Alterna o deshabilita el estado activo sin eliminar el registro.
     */
    public function destroy(Localidad $localidad): RedirectResponse
    {
        // Alternar el estado activo (Borrado lógico SIGAM)
        $nuevoEstado = !$localidad->activo;
        
        $localidad->update([
            'activo' => $nuevoEstado,
        ]);

        $mensaje = $nuevoEstado 
            ? 'La localidad ha sido reactivada correctamente.' 
            : 'La localidad ha sido deshabilitada del catálogo (borrado lógico).';

        return redirect()
            ->route('localidades.index')
            ->with('success', $mensaje);
    }
}