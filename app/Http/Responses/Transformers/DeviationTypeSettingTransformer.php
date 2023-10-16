<?php

namespace App\Http\Responses\Transformers;

use App\Http\Models\DeviationTypeSetting;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;


class DeviationTypeSettingTransformer extends TransformerAbstract
{
    public function transform(DeviationTypeSetting $deviationTypeSetting): array
    {
        return [
            'id' => (string)$deviationTypeSetting->id,
            'tipo_desvio_pai_id' => $deviationTypeSetting->tipo_desvio_pai_id,
            'tipo_desvio_pai' => $deviationTypeSetting->tipo_desvio_pai,
            'tipo_desvio_filho' => $deviationTypeSetting->tipo_desvio_filho,
            'nome' => $deviationTypeSetting->nome,
            'nome_hierarquico' => $deviationTypeSetting->nome_hierarquico,
            'situacao' => $deviationTypeSetting->situacao,
            'desabilitado' => $deviationTypeSetting->desabilitado,

            'log_cadastro_data' => $deviationTypeSetting->log_cadastro_data ? Carbon::parse($deviationTypeSetting->log_cadastro_data)->toISOString() : null,
            'log_cadastro_usuario_id' => $deviationTypeSetting->log_cadastro_usuario_id ?? null,
            'log_alterado_data' => $deviationTypeSetting->log_alterado_data ? Carbon::parse($deviationTypeSetting->log_alterado_data)->toISOString() : null,
            'log_alterado_usuario_id' => $deviationTypeSetting->log_alterado_usuario_id ?? null,
            'log_excluido_data' => $deviationTypeSetting->log_excluido_data ? Carbon::parse($deviationTypeSetting->log_excluido_data)->toISOString() : null,
            'log_excluido_usuario_id' => $deviationTypeSetting->log_excluido_usuario_id ?? null,

            'links' => [
                'self' => '/deviation-types/' . $deviationTypeSetting->id,
            ]
        ];
    }
}
