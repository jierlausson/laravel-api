<?php

namespace App\Http\Responses\Transformers;

use App\Http\Models\LevelSetting;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;


class LevelSettingTransformer extends TransformerAbstract
{
    public function transform(LevelSetting $levelSetting): array
    {
        return [
            'id' => (string)$levelSetting->id,
            'nome' => $levelSetting->nome,
            'meta_periodo' => $levelSetting->meta,
            'quantidade' => $levelSetting->quantidade,
            'situacao' => $levelSetting->situacao,

            'log_cadastro_data' => $levelSetting->log_cadastro_data ? Carbon::parse($levelSetting->log_cadastro_data)->toISOString() : null,
            'log_cadastro_usuario_id' => $levelSetting->log_cadastro_usuario_id ?? null,
            'log_alterado_data' => $levelSetting->log_alterado_data ? Carbon::parse($levelSetting->log_alterado_data)->toISOString() : null,
            'log_alterado_usuario_id' => $levelSetting->log_alterado_usuario_id ?? null,
            'log_excluido_data' => $levelSetting->log_excluido_data ? Carbon::parse($levelSetting->log_excluido_data)->toISOString() : null,
            'log_excluido_usuario_id' => $levelSetting->log_excluido_usuario_id ?? null,

            'links' => [
                'self' => '/level-settings/' . $levelSetting->id,
            ]
        ];
    }
}
