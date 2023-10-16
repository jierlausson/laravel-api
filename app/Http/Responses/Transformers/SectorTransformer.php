<?php

namespace App\Http\Responses\Transformers;

use App\Http\Models\Sector;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;


class SectorTransformer extends TransformerAbstract
{
    public function transform(Sector $sector): array
    {
        return [
            'id' => (string)$sector->id,
            'ordem' => $sector->ordem,
            'nivel' => $sector->nivel,
            'setor_pai_id' => $sector->setor_pai_id,
            'setor_pai' => $sector->setor_pai,
            'setor_filho' => $sector->setor_filho,
            'nome' => $sector->nome,
            'nome_hierarquico' => $sector->nome_hierarquico,
            'permite_observacao' => $sector->permite_observacao,
            'situacao' => $sector->situacao,

            'log_cadastro_data' => $sector->log_cadastro_data ? Carbon::parse($sector->log_cadastro_data)->toISOString() : null,
            'log_cadastro_usuario_id' => $sector->log_cadastro_usuario_id ?? null,
            'log_alterado_data' => $sector->log_alterado_data ? Carbon::parse($sector->log_alterado_data)->toISOString() : null,
            'log_alterado_usuario_id' => $sector->log_alterado_usuario_id ?? null,
            'log_excluido_data' => $sector->log_excluido_data ? Carbon::parse($sector->log_excluido_data)->toISOString() : null,
            'log_excluido_usuario_id' => $sector->log_excluido_usuario_id ?? null,

            'links' => [
                'self' => '/sectors/' . $sector->id,
            ]
        ];
    }
}
