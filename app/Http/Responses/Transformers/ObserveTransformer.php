<?php

namespace App\Http\Responses\Transformers;

use App\Http\Models\Observe;
use Carbon\Carbon;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;


class ObserveTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'user', 'userSector', 'sector'
    ];

    public function transform(Observe $observe): array
    {
        return [
            'id' => (string)$observe->id,
            'numero' => $observe->numero,
            'usuario_id' => $observe->usuario_id,
            'usuario_setor_id' => $observe->usuario_setor_id,
            'setor_id' => $observe->setor_id,
            'local' => $observe->local,
            'data' => $observe->data ? Carbon::parse($observe->data)->toISOString() : null,
            'tipo' => $observe->tipo,
            'observado' => $observe->observado,
            'observado_setor_id' => $observe->observado_setor_id,
            'observacao' => $observe->observacao,
            'log_cadastro_por' => $observe->log_cadastro_por,
            'log_sincronizado_data' => $observe->log_sincronizado_data,

            'log_cadastro_data' => $observe->log_cadastro_data ? Carbon::parse($observe->log_cadastro_data)->toISOString() : null,
            'log_cadastro_usuario_id' => $observe->log_cadastro_usuario_id ?? null,
            'log_alterado_data' => $observe->log_alterado_data ? Carbon::parse($observe->log_alterado_data)->toISOString() : null,
            'log_alterado_usuario_id' => $observe->log_alterado_usuario_id ?? null,
            'log_excluido_data' => $observe->log_excluido_data ? Carbon::parse($observe->log_excluido_data)->toISOString() : null,
            'log_excluido_usuario_id' => $observe->log_excluido_usuario_id ?? null,

            'links' => [
                'self' => '/observes/' . $observe->id,
            ]
        ];
    }

    /**
     * Include user
     *
     * @param Observe $observe
     *
     * @return Item
     */
    public function includeUser(Observe $observe): Item
    {
        return $this->item($observe->user, new UserTransformer(), 'user');
    }

    /**
     * Include userSector
     *
     * @param Observe $observe
     *
     * @return Item
     */
    public function includeUserSector(Observe $observe): Item
    {
        return $this->item($observe->userSector, new SectorTransformer(), 'sector');
    }

    /**
     * Include sector
     *
     * @param Observe $observe
     *
     * @return Item
     */
    public function includeSector(Observe $observe): Item
    {
        return $this->item($observe->sector, new SectorTransformer(), 'sector');
    }
}
