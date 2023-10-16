<?php

namespace App\Http\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


/**
 * App\Http\Models\GeneralSetting
 *
 * @property int $id
 * @property string $nome
 * @property string $meta
 * @property int $quantidade
 * @property string $situacao
 *
 * @property Carbon|null $log_alterado_data
 * @property int|null $log_alterado_usuario_id
 * @property-read User $logUpdateUser
 *
 * @mixin mixed
 */
class GeneralSetting extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'configuracao_geral';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'observar_permite_multiplo_desvio', 'observar_permite_desvio_igual_na_mesma_observacao', 'observar_informa_observado_para',
        'observar_limite_desvio_por_ciclo_vigente',

        'log_alterado_data', 'log_alterado_usuario_id',
    ];
}
