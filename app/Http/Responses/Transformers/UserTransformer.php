<?php

namespace App\Http\Responses\Transformers;

use App\Http\Models\User;
use Carbon\Carbon;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;


class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'sector', 'levelSetting'
    ];

    public function transform(User $user): array
    {
        return [
            'id' => (string)$user->id,
            'uuid' => $user->uuid,
            'nivel_id' => $user->nivel_id,
            'setor_id' => $user->setor_id,
            'matricula' => $user->matricula,
            'nivel' => $user->nivel,
            'aprova_ausencia' => $user->aprova_ausencia,
            'email' => $user->email,
            'nome' => $user->nome,
            'nome_exibe' => $user->nome_exibe,
            'foto' => $user->foto,
            'data_inicio' => $user->data_inicio ? Carbon::parse($user->data_inicio)->toISOString() : null,
            'data_desligamento' => $user->data_desligamento ? Carbon::parse($user->data_desligamento)->toISOString() : null,
            'situacao' => $user->situacao,
            'observar_dispensado_meta' => $user->observar_dispensado_meta,
            'versao_lida_em' => $user->versao_lida_em ? Carbon::parse($user->versao_lida_em)->toISOString() : null,
            'menu_tipo' => $user->menu_tipo,
            'administrador' => $user->administrador,
            'master' => $user->master,
            'app_token_notificacao' => $user->app_token_notificacao,
            'quantidade_observacoes_realizadas' => $user->quantidade_observacoes_realizadas,
            'quantidade_meta_observacoes' => $user->quantidade_meta_observacoes,
            'formato_meta' => $user->formato_meta,
            'ciclo_inicial' => $user->ciclo_inicial,
            'ciclo_final' => $user->ciclo_final,
            'log_ultimo_acesso_data' => $user->log_ultimo_acesso_data ? Carbon::parse($user->log_ultimo_acesso_data)->toISOString() : null,
            'log_ultimo_acesso_ip' => $user->log_ultimo_acesso_ip,
            'log_quantidade_acesso' => $user->log_quantidade_acesso,

            'log_cadastro_data' => $user->log_cadastro_data ? Carbon::parse($user->log_cadastro_data)->toISOString() : null,
            'log_cadastro_usuario_id' => $user->log_cadastro_usuario_id ?? null,
            'log_alterado_data' => $user->log_alterado_data ? Carbon::parse($user->log_alterado_data)->toISOString() : null,
            'log_alterado_usuario_id' => $user->log_alterado_usuario_id ?? null,
            'log_excluido_data' => $user->log_excluido_data ? Carbon::parse($user->log_excluido_data)->toISOString() : null,
            'log_excluido_usuario_id' => $user->log_excluido_usuario_id ?? null,

            'configuracao_geral' => $user->generalSetting,

            'links' => [
                'self' => '/users/' . $user->id,
            ]
        ];
    }

    /**
     * Include sector
     *
     * @param User $user
     *
     * @return Item
     */
    public function includeSector(User $user): Item
    {
        return $this->item($user->sector, new SectorTransformer(), 'sector');
    }

    /**
     * Include levelSetting
     *
     * @param User $user
     *
     * @return Item
     */
    public function includeLevelSetting(User $user): Item
    {
        return $this->item($user->levelSetting, new LevelSettingTransformer(), 'levelSetting');
    }
}
