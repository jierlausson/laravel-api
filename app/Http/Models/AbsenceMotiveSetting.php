<?php

namespace App\Http\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


/**
 * App\Http\Models\AbsenceMotiveSetting
 *
 * @property int $id
 * @property String $nome
 * @property String $situacao
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
class AbsenceMotiveSetting extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'configuracao_ausencia_motivo';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'situacao',

        'log_cadastro_data', 'log_cadastro_usuario_id',
        'log_alterado_data', 'log_alterado_usuario_id',
        'log_excluido_data', 'log_excluido_usuario_id'
    ];
}
