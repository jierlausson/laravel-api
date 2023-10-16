<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


/**
 * App\Http\Models\UserSector
 *
 * @property int $id
 * @property int $usuario_id
 * @property string $rotina
 * @property int $setor_id
 *
 * @mixin mixed
 */
class UserSector extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'usuario_setor';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario_id', 'rotina', 'setor_id'
    ];

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne('App\Http\Models\User', 'id', 'usuario_id');
    }

    /**
     * @return HasOne
     */
    public function sector(): HasOne
    {
        return $this->hasOne('App\Http\Models\Sector', 'id', 'setor_id');
    }
}
