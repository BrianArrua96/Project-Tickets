<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Esdeveniment extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = ['nom', 'descripcio', 'ocult', 'recinte_id', 'categoria_id', 'user_id'];

    /**
     * Obtiene el recinto asociado al evento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recinte()
    {
        return $this->belongsTo(Recinte::class);
    }

    /**
     * Obtiene la categoría asociada al evento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Obtiene el usuario asociado al evento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene las sesiones asociadas al evento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sesions()
    {
        return $this->hasMany(Sessio::class, 'esdeveniments_id');
    }

    /**
     * Obtiene las opiniones asociadas al evento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opinions()
    {
        return $this->hasMany(Opinion::class, 'esdeveniments_id');
    }

    /**
     * Obtiene las imágenes asociadas al evento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function imatge()
    {
        return $this->hasMany(EsdevenimentImatge::class, 'esdeveniments_id');
    }

    /**
     * Obtiene los eventos administrados por un usuario.
     *
     * @param int $userId
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getAdminEvents($userId)
    {
        return self::with(['recinte'])
            ->join(
                DB::raw('(SELECT esdeveniments_id, MIN(data) as min_data FROM sessios GROUP BY esdeveniments_id) as min_dates'),
                function ($join) {
                    $join->on('esdeveniments.id', '=', 'min_dates.esdeveniments_id');
                }
            )
            ->leftJoin('sessios', function ($join) {
                $join->on('esdeveniments.id', '=', 'sessios.esdeveniments_id')
                    ->on('sessios.data', '=', 'min_dates.min_data');
            })
            ->select('esdeveniments.*', 'min_dates.min_data as min_data')
            ->where('min_dates.min_data', '>', now())
            ->where('user_id', $userId) // Filter events by user_id
            ->orderBy('min_data', 'asc')
            ->paginate(6);
    }

    /**
     * Obtiene todos los eventos paginados.
     *
     * @param int $pag
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getAllEvents($pag)
    {
        return self::with(['recinte'])
            ->join(
                DB::raw('(SELECT esdeveniments_id, MIN(data) as min_data FROM sessios GROUP BY esdeveniments_id) as min_dates'),
                function ($join) {
                    $join->on('esdeveniments.id', '=', 'min_dates.esdeveniments_id');
                }
            )
            ->leftJoin('sessios', function ($join) {
                $join->on('esdeveniments.id', '=', 'sessios.esdeveniments_id')
                    ->on('sessios.data', '=', 'min_dates.min_data');
            })
            ->select('esdeveniments.*', 'min_dates.min_data as min_data')
            ->where('min_dates.min_data', '>', now())
            ->orderBy('min_data', 'asc')
            ->paginate($pag);
    }

    /**
     * Obtiene los eventos ordenados por categoría.
     *
     * @param int $categoryId
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getOrderedEvents($categoryId)
    {
        return self::join(
            DB::raw('(SELECT esdeveniments_id, MIN(data) as min_data 
                    FROM sessios 
                    GROUP BY esdeveniments_id) as min_dates'),
            function ($join) {
                $join->on('esdeveniments.id', '=', 'min_dates.esdeveniments_id');
            }
        )
            ->join('sessios', function ($join) {
                $join->on('sessios.esdeveniments_id', '=', 'min_dates.esdeveniments_id')
                    ->on('sessios.data', '=', 'min_dates.min_data');
            })
            ->join(
                DB::raw('(SELECT sessios_id, MIN(preu) as min_preu 
                            FROM entradas 
                            GROUP BY sessios_id) as min_preus'),
                function ($join) {
                    $join->on('sessios.id', '=', 'min_preus.sessios_id');
                }
            )
            ->join('entradas', function ($join) {
                $join->on('entradas.sessios_id', '=', 'min_preus.sessios_id')
                    ->on('entradas.preu', '=', 'min_preus.min_preu');
            })
            ->join('categories', 'categories.id', '=', 'esdeveniments.categoria_id')
            ->select('esdeveniments.*', 'sessios.data as data_sessio', 'entradas.preu as entradas_preu')
            ->where('categories.id', '=', $categoryId)
            ->orderBy('data_sessio', 'asc')
            ->groupBy('esdeveniments.id', 'sessios.data', 'entradas.preu')
            ->paginate(config('app.items_per_page', 6));
    }

    /**
     * Obtiene un evento por su ID.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public static function getEventById($id)
    {
        return DB::table('esdeveniments')->where('id', '=', $id)->first();
    }

    /**
     * Obtiene el primer evento local por su ID.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public static function getFirstEventLocal($id)
    {
        return self::join('recintes', 'recintes.id', '=', 'esdeveniments.recinte_id')
            ->select('recintes.*')
            ->where('esdeveniments.id', '=', $id)
            ->first();
    }

    /**
     * Obtiene las sesiones de un evento por su ID.
     *
     * @param int $id
     * @return \Illuminate\Support\Collection
     */
    public static function getSessiosEvent($id)
    {
        return self::join('sessios', 'sessios.esdeveniments_id', '=', 'esdeveniments.id')
            ->select('sessios.*')
            ->where('esdeveniments.id', '=', $id)
            ->get();
    }

    /**
     * Obtiene las entradas de un evento por su ID.
     *
     * @param int $id
     * @return \Illuminate\Support\Collection
     */
    public static function getEntradesEvent($id)
    {
        return self::join('sessios', 'sessios.esdeveniments_id', '=', 'esdeveniments.id')
            ->join('entradas', 'entradas.sessios_id', '=', 'sessios.id')
            ->select('entradas.*')
            ->where('esdeveniments.id', '=', $id)
            ->get();
    }
}
