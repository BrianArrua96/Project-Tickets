<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = ['esdeveniment_id', 'nom', 'emocio', 'puntuacio', 'titol', 'comentari'];

    /**
     * Define la relación con el modelo Esdeveniment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function esdeveniment()
    {
        return $this->belongsTo(Esdeveniment::class);
    }
}