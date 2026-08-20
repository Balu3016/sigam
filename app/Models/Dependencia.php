<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'siglas',
        'activo',
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }
}