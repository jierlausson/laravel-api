<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


/**
 * App\Http\Models\ObserveDetour
 *
 * @property int $id
 * @property int $observar_id
 * @property-read Observe $observe
 * @property int $tipo_desvio_id
 * @property-read ObserveDetourTypeSetting $observeDetourType
 * @property int $motivo_alegado_id
 * @property-read MotiveAllegedSetting $motive
 *
 * @mixin mixed
 */
class ObserveDetour extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'observar_tipo_desvio_motivo';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'observar_id', 'tipo_desvio_id', 'motivo_alegado_id',
    ];


    /**
     * @return HasOne
     */
    public function observe(): HasOne
    {
        return $this->hasOne('App\Http\Models\Observe', 'id', 'observar_id');
    }

    /**
     * @return HasOne
     */
    public function observeDetourTypeSetting(): HasOne
    {
        return $this->hasOne('App\Http\Models\ObserveDetourTypeSetting', 'id', 'tipo_desvio_id');
    }

    /**
     * @return HasOne
     */
    public function motive(): HasOne
    {
        return $this->hasOne('App\Http\Models\MotiveAllegedSetting', 'id', 'motivo_alegado_id');
    }
}
