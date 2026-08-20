<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entrega extends Model
{
    use HasFactory;

    protected $table = 'entregas';

    protected $fillable = [
        'beneficiario_id',
        'programa_social_id',
        'localidad_id',
        'fecha_entrega',
        'cantidad',
        'folio_acta',
        'estatus',
        'observaciones',
        'user_id',
    ];

    protected $casts = [
        'fecha_entrega' => 'date',
        'cantidad' => 'integer',
    ];

    // Relación con Beneficiario
    public function beneficiario(): BelongsTo
    {
        return $this->belongsTo(Beneficiario::class, 'beneficiario_id');
    }

    // Relación con Programa Social
    public function programaSocial(): BelongsTo
    {
        return $this->belongsTo(ProgramaSocial::class, 'programa_social_id');
    }

    // Relación con Localidad
    public function localidad(): BelongsTo
    {
        return $this->belongsTo(Localidad::class, 'localidad_id');
    }

    // Relación con el Usuario que capturó
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}