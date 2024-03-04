<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sessio extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = ['data', 'tancament', 'aforament', 'esdeveniments_id', 'estado'];

    /**
     * Define la relación con el modelo Esdeveniment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function esdeveniment()
    {
        return $this->belongsTo(Esdeveniment::class, 'esdeveniments_id');
    }

    /**
     * Define la relación con el modelo Entrada.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entrades()
    {
        return $this->hasMany(Entrada::class, 'sessios_id');
    }

    /**
     * Obtiene las sesiones de eventos de un usuario específico.
     *
     * @param int $userId
     * @return \Illuminate\Pagination\Paginator
     */
    public function getUserSessions($userId)
    {
        return $this->with(['esdeveniment.recinte', 'esdeveniment.user'])
            ->whereHas('esdeveniment', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('data', '>', now()) // Sesiones futuras
            ->orderBy('data', 'asc')
            ->paginate(6);
    }

    /**
     * Obtiene la sesión de evento por su ID.
     *
     * @param int $sessionId
     * @return mixed
     */
    public static function getSessionbyID($SessionId)
    {
        return DB::table('sessios')
            ->where('sessios.id', '=', $SessionId)
            ->first();
    }

    /**
     * Obtiene el recinto asociado a una sesión.
     *
     * @param int $id
     * @return mixed
     */
    public static function getRecinteFromSessio($id)
    {
        return self::join('esdeveniments', 'sessios.esdeveniments_id', '=', 'esdeveniments.id')
            ->join('recintes', 'recintes.id', '=', 'esdeveniments.recinte_id')
            ->select('recintes.*')
            ->where('sessios.id', $id)
            ->first();
    }
}
