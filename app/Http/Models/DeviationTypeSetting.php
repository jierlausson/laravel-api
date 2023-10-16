<?php

namespace App\Http\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


/**
 * App\Http\Models\DeviationTypeSetting
 *
 * @property int $id
 * @property int $tipo_desvio_pai_id
 * @property string $tipo_desvio_pai
 * @property string $tipo_desvio_filho
 * @property string $nome
 * @property string $nome_hierarquico
 * @property string $situacao
 * @property string $desabilitado
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
class DeviationTypeSetting extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'configuracao_tipo_desvio';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_desvio_pai_id', 'tipo_desvio_pai', 'tipo_desvio_filho',
        'nome', 'nome_hierarquico', 'situacao',

        'log_cadastro_data', 'log_cadastro_usuario_id',
        'log_alterado_data', 'log_alterado_usuario_id',
        'log_excluido_data', 'log_excluido_usuario_id'
    ];
}
