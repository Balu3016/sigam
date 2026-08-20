<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLocalidadRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación aplicables a la solicitud.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Se obtiene el ID de la localidad desde la ruta para ignorarla en la regla de unicidad
        $localidadId = $this->route('localidad') ? $this->route('localidad')->id : null;

        return [
            'nombre' => [
                'required',
                'string',
                'max:150',
                Rule::unique('localidades', 'nombre')->ignore($localidadId),
            ],
            'tipo' => [
                'required',
                'string',
                Rule::in(['cabecera', 'barrio', 'delegacion', 'colonia', 'ejido', 'rancheria']),
            ],
            'codigo_postal' => [
                'nullable',
                'string',
                'size:5',
                'regex:/^[0-9]{5}$/',
            ],
            'clasificacion_zonal' => [
                'required',
                'string',
                Rule::in(['urbana', 'semiurbana', 'rural']),
            ],
            'activo' => [
                'sometimes',
                'boolean',
            ],
        ];
    }

    /**
     * Mensajes de error personalizados para las reglas de validación.
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la localidad es obligatorio.',
            'nombre.unique' => 'Ya existe otra localidad registrada con este nombre.',
            'nombre.max' => 'El nombre no debe exceder los 150 caracteres.',
            'tipo.required' => 'Debe seleccionar un tipo de localidad válido.',
            'tipo.in' => 'El tipo de localidad seleccionado no es válido.',
            'codigo_postal.size' => 'El código postal debe contener exactamente 5 dígitos.',
            'codigo_postal.regex' => 'El código postal solo debe contener números.',
            'clasificacion_zonal.required' => 'Debe seleccionar una clasificación zonal.',
            'clasificacion_zonal.in' => 'La clasificación zonal seleccionada no es válida.',
            'activo.boolean' => 'El estado de la localidad debe ser un valor válido.',
        ];
    }

    /**
     * Atributos personalizados para los mensajes de validación.
     */
    public function attributes(): array
    {
        return [
            'nombre' => 'nombre de la localidad',
            'tipo' => 'tipo de localidad',
            'codigo_postal' => 'código postal',
            'clasificacion_zonal' => 'clasificación zonal',
            'activo' => 'estado activo',
        ];
    }
}