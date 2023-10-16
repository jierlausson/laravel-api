<?php

namespace App\Http\Responses\Transformers;

use App\Http\Models\AbsenceMotiveSetting;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;


class AbsenceMotiveSettingTransformer extends TransformerAbstract
{
    public function transform(AbsenceMotiveSetting $absenceMotiveSetting): array
    {
        return [
            'id' => (string)$absenceMotiveSetting->id,
            'nome' => $absenceMotiveSetting->nome,

            'log_cadastro_data' => $absenceMotiveSetting->log_cadastro_data ? Carbon::parse($absenceMotiveSetting->log_cadastro_data)->toISOString() : null,
            'log_cadastro_usuario_id' => $absenceMotiveSetting->log_cadastro_usuario_id ?? null,
            'log_alterado_data' => $absenceMotiveSetting->log_alterado_data ? Carbon::parse($absenceMotiveSetting->log_alterado_data)->toISOString() : null,
            'log_alterado_usuario_id' => $absenceMotiveSetting->log_alterado_usuario_id ?? null,
            'log_excluido_data' => $absenceMotiveSetting->log_excluido_data ? Carbon::parse($absenceMotiveSetting->log_excluido_data)->toISOString() : null,
            'log_excluido_usuario_id' => $absenceMotiveSetting->log_excluido_usuario_id ?? null,

            'links' => [
                'self' => '/absence-motive-settings/' . $absenceMotiveSetting->id,
            ]
        ];
    }
}
