<?php

namespace App\Http\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


/**
 * App\Http\Models\Observe
 *
 * @property int $id
 * @property string $numero
 * @property int $usuario_id
 * @property-read User $user
 * @property int $usuario_setor_id
 * @property-read UserSector $userSector
 * @property int $setor_id
 * @property-read Sector $sector
 * @property string $local
 * @property Carbon|null $data
 * @property string $tipo
 * @property string $observado
 * @property int $observado_setor_id
 * @property string $nome_exibe
 * @property string $observacao
 * @property string $log_cadastro_por
 * @property Carbon|null $log_sincronizado_data
 *
 * @property Carbon|null $log_cadastro_data
 * @property int|null $log_cadastro_usuario_id
 * @property-read User $logStoreUser
 * @property Carbon|null $log_alterado_data
 * @property int|null $log_alterado_usuario_id
 * @property-read User $logUpdateUser
 * @property Carbon|null $log_excluido_data
 * @property int|null $log_excluido_usuario_id
 * @property-read User $logDestroyUser
 *
 * @mixin mixed
 */
class Observe extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'observar';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'numero', 'usuario_id', 'usuario_setor_id', 'setor_id',
        'local', 'data', 'tipo',
        'observado', 'observado_setor_id', 'observacao',
        'log_cadastro_por', 'log_sincronizado_data',

        'log_cadastro_data', 'log_cadastro_usuario_id',
        'log_alterado_data', 'log_alterado_usuario_id',
        'log_excluido_data', 'log_excluido_usuario_id'
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
    public function userSector(): HasOne
    {
        return $this->hasOne('App\Http\Models\Sector', 'id', 'usuario_setor_id');
    }

    /**
     * @return HasOne
     */
    public function sector(): HasOne
    {
        return $this->hasOne('App\Http\Models\Sector', 'id', 'setor_id');
    }
}
