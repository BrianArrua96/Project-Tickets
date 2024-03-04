<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recinte extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = ['nom', 'provincia', 'lloc', 'codi_postal', 'capacitat', 'carrer', 'numero', 'user_id'];

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'recintes';

    /**
     * Define la relación con el modelo Esdeveniment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function esdeveniments()
    {
        return $this->hasMany(Esdeveniment::class);
    }

    /**
     * Define la relación con el modelo User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
