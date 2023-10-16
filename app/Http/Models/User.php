<?php

namespace App\Http\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * App\Http\Models\User
 *
 * @property int $id
 * @property String $uuid
 * @property int $setor_id
 * @property-read Sector $sector
 * @property int $nivel_id
 * @property-read LevelSetting $levelSetting
 * @property string $matricula
 * @property string $email
 * @property string $senha
 * @property string $nome
 * @property string $nome_exibe
 * @property string $foto
 * @property string $nivel
 * @property bool $aprova_ausencia
 * @property Carbon|null $data_inicio
 * @property Carbon|null $data_desligamento
 * @property string $situacao
 * @property int $observar_dispensado_meta
 * @property Carbon|null $versao_lida_em
 * @property string $menu_tipo
 * @property int $administrador
 * @property int $master
 * @property string $app_token_notificacao
 * @property int $quantidade_observacoes_realizadas
 * @property int $quantidade_meta_observacoes
 * @property String $formato_meta
 * @property String $ciclo_inicial
 * @property String $ciclo_final
 * @property Carbon|null $log_ultimo_acesso_data
 * @property string $log_ultimo_acesso_ip
 * @property int $log_quantidade_acesso
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
 * @property GeneralSetting $generalSetting
 *
 * @mixin mixed
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'setor_id', 'nivel_id', 'matricula', 'email', 'senha',
        'nome', 'nome_exibe', 'foto', 'data_inicio', 'data_desligamento',
        'situacao', 'observar_dispensado_meta', 'versao_lida_em',
        'menu_tipo', 'administrador', 'master',
        'app_token_notificacao', 'log_ultimo_acesso_data', 'log_ultimo_acesso_ip', 'log_quantidade_acesso',

        'log_cadastro_data', 'log_cadastro_usuario_id',
        'log_alterado_data', 'log_alterado_usuario_id',
        'log_excluido_data', 'log_excluido_usuario_id'
    ];

    /**
     * @return HasOne
     */
    public function sector(): HasOne
    {
        return $this->hasOne('App\Http\Models\Sector', 'id', 'setor_id');
    }

    /**
     * @return HasOne
     */
    public function levelSetting(): HasOne
    {
        return $this->hasOne('App\Http\Models\LevelSetting', 'id', 'nivel_id');
    }

    /**
     * @param string $password
     */
    public function setPasswordAttribute(string $password)
    {
        if (!empty($password)) {
            //bCrypt hash
            //            $this->attributes['password'] = bcrypt($password);

            //md5 hash
            $this->attributes['senha'] = md5($password);
        }
    }
}
