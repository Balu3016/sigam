<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProgramaSocialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $programaSocialId = $this->route('programa_social') 
            ? $this->route('programa_social')->id 
            : $this->route('programa_social');

        return [
            'codigo' => ['required', 'string', 'max:20', Rule::unique('programas_sociales', 'codigo')->ignore($programaSocialId)],
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'categoria' => ['required', 'string', Rule::in(['alimentario', 'economico', 'educativo', 'salud', 'vivienda', 'infraestructura'])],
            'presupuesto_anual' => ['nullable', 'numeric', 'min:0', 'max:9999999999.99'],
            'tipo_apoyo' => ['required', 'string', Rule::in(['monetario', 'especie', 'servicio'])],
            'periodicidad' => ['required', 'string', Rule::in(['unico', 'mensual', 'bimensual', 'trimestral', 'anual'])],
            'requisitos' => ['nullable', 'array'],
            'requisitos.*' => ['nullable', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'codigo' => 'código institucional',
            'nombre' => 'nombre del programa',
            'descripcion' => 'descripción',
            'categoria' => 'categoría',
            'presupuesto_anual' => 'presupuesto anual',
            'tipo_apoyo' => 'tipo de apoyo',
            'periodicidad' => 'periodicidad',
            'requisitos' => 'requisitos',
            'activo' => 'estado activo',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'codigo.unique' => 'El :attribute ya se encuentra registrado en otro programa social.',
            'categoria.in' => 'La :attribute seleccionada no es válida.',
            'tipo_apoyo.in' => 'El :attribute seleccionado no es válido.',
            'periodicidad.in' => 'La :attribute seleccionada no es válida.',
        ];
    }
}