<?php

namespace App\Http\Responses\Transformers;

use App\Http\Models\MotiveAbsenceSetting;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;


class MotiveAbsenceSettingTransformer extends TransformerAbstract
{
    public function transform(MotiveAbsenceSetting $motiveSetting): array
    {
        return [
            'id' => (string)$motiveSetting->id,
            'nome' => $motiveSetting->nome,
            'situacao' => $motiveSetting->situacao,

            'log_cadastro_data' => $motiveSetting->log_cadastro_data ? Carbon::parse($motiveSetting->log_cadastro_data)->toISOString() : null,
            'log_cadastro_usuario_id' => $motiveSetting->log_cadastro_usuario_id ?? null,
            'log_alterado_data' => $motiveSetting->log_alterado_data ? Carbon::parse($motiveSetting->log_alterado_data)->toISOString() : null,
            'log_alterado_usuario_id' => $motiveSetting->log_alterado_usuario_id ?? null,
            'log_excluido_data' => $motiveSetting->log_excluido_data ? Carbon::parse($motiveSetting->log_excluido_data)->toISOString() : null,
            'log_excluido_usuario_id' => $motiveSetting->log_excluido_usuario_id ?? null,

            'links' => [
                'self' => '/motive-settings/' . $motiveSetting->id,
            ]
        ];
    }
}
