<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Localidad extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'localidades';

    /**
     * Atributos asignables de forma masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'tipo',
        'codigo_postal',
        'clasificacion_zonal',
        'activo',
    ];

    /**
     * Los atributos que deben ser casteados.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activo' => 'boolean',
    ];

    // =====================================
    // SCOPES (Filtros de Consultas)
    // =====================================

    /**
     * Scope para obtener únicamente localidades activas (Borrado lógico SIGAM).
     */
    public function scopeActivo(Builder $query): Builder
    {
        return $query->where('activo', true);
    }
}