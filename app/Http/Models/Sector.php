<?php

namespace App\Http\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


/**
 * App\Http\Models\Sector
 *
 * @property int $id
 * @property int $ordem
 * @property int $nivel
 * @property int $setor_pai_id
 * @property string $setor_pai
 * @property string $setor_filho
 * @property string $nome
 * @property string $nome_hierarquico
 * @property int $permite_observacao
 * @property string $situacao
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
class Sector extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'setor';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ordem', 'nivel', 'setor_pai_id',
        'setor_pai', 'setor_filho', 'nome',
        'nome_hierarquico', 'permite_observacao', 'situacao',

        'log_cadastro_data', 'log_cadastro_usuario_id',
        'log_alterado_data', 'log_alterado_usuario_id',
        'log_excluido_data', 'log_excluido_usuario_id'
    ];
}
