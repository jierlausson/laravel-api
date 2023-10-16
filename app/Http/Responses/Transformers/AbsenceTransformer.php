<?php

namespace App\Http\Responses\Transformers;

use App\Http\Models\Absence;
use Carbon\Carbon;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;


class AbsenceTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'user', 'userSector', 'motiveAbsenceSetting', 'approvedBy'
    ];

    public function transform(Absence $absence): array
    {
        return [
            'id' => (string)$absence->id,
            'usuario_id' => $absence->usuario_id,
            'usuario_setor_id' => $absence->usuario_setor_id,
            'motivo_id' => $absence->motivo_id,
            'data_inicial' => $absence->data_inicial,
            'data_final' => $absence->data_final,
            'situacao' => $absence->situacao,
            'rejeitado_motivo' => $absence->rejeitado_motivo,
            'log_aprovado_data' => $absence->log_aprovado_data,
            'log_aprovado_usuario_id' => $absence->log_aprovado_usuario_id,

            'log_cadastro_data' => $absence->log_cadastro_data ? Carbon::parse($absence->log_cadastro_data)->toISOString() : null,
            'log_cadastro_usuario_id' => $absence->log_cadastro_usuario_id ?? null,
            'log_alterado_data' => $absence->log_alterado_data ? Carbon::parse($absence->log_alterado_data)->toISOString() : null,
            'log_alterado_usuario_id' => $absence->log_alterado_usuario_id ?? null,
            'log_excluido_data' => $absence->log_excluido_data ? Carbon::parse($absence->log_excluido_data)->toISOString() : null,
            'log_excluido_usuario_id' => $absence->log_excluido_usuario_id ?? null,

            'links' => [
                'self' => '/absences/' . $absence->id,
            ]
        ];
    }

    /**
     * Include user
     *
     * @param Absence $absence
     *
     * @return Item
     */
    public function includeUser(Absence $absence): Item
    {
        return $this->item($absence->user, new UserTransformer(), 'user');
    }

    /**
     * Include userSector
     *
     * @param Absence $absence
     *
     * @return Item
     */
    public function includeUserSector(Absence $absence): Item
    {
        return $this->item($absence->userSector, new SectorTransformer(), 'sector');
    }

    /**
     * Include motiveSetting
     *
     * @param Absence $absence
     *
     * @return Item
     */
    public function includeMotiveAbsenceSetting(Absence $absence): Item
    {
        return $this->item($absence->motiveAbsenceSetting, new MotiveAbsenceSettingTransformer(), 'motiveAbsenceSetting');
    }

    /**
     * Include approvedBy
     *
     * @param Absence $absence
     *
     * @return void|Item
     */
    public function includeApprovedBy(Absence $absence)
    {
        if ($absence->approvedBy == null) return;

        return $this->item($absence->approvedBy, new UserTransformer(), 'approvedBy');
    }
}
