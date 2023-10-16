<?php

namespace App\Http\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


/**
 * App\Http\Models\Absence
 *
 * @property int $id
 * @property int $usuario_id
 * @property-read User $user
 * @property int $usuario_setor_id
 * @property-read UserSector $userSector
 * @property int $motivo_id
 * @property-read MotiveAbsenceSetting $motiveAbsenceSetting
 * @property Carbon|null $data_inicial
 * @property Carbon|null $data_final
 * @property string $situacao
 * @property string $rejeitado_motivo
 * @property Carbon|null $log_aprovado_data
 * @property int|null $log_aprovado_usuario_id
 * @property-read User $approvedBy
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
class Absence extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'ausencia';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario_id', 'usuario_setor_id', 'motivo_id',
        'data_inicial', 'data_final', 'situacao',
        'rejeitado_motivo', 'log_aprovado_data', 'log_aprovado_usuario_id',

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
    public function motiveAbsenceSetting(): HasOne
    {
        return $this->hasOne('App\Http\Models\MotiveAbsenceSetting', 'id', 'motivo_id');
    }

    /**
     * @return HasOne
     */
    public function approvedBy(): HasOne
    {
        return $this->hasOne('App\Http\Models\User', 'id', 'log_aprovado_usuario_id');
    }
}
