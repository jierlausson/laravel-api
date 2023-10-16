<?php

namespace App\Http\Responses\Transformers;

use App\Http\Models\ObserveDetourMotive;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;


class ObserveDetourMotiveTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'observation', 'deviationTypeSetting', 'motiveAllegedSetting'
    ];

    public function transform(ObserveDetourMotive $observeDetourMotive): array
    {
        return [
            'id' => (string)$observeDetourMotive->id,
            'observar_id' => $observeDetourMotive->observar_id,
            'tipo_desvio_id' => $observeDetourMotive->tipo_desvio_id,
            'motivo_alegado_id' => $observeDetourMotive->motivo_alegado_id,

            'links' => [
                'self' => '/observes/' . $observeDetourMotive->observar_id . '/deviations-motive/' . $observeDetourMotive->id,
            ]
        ];
    }

    /**
     * Include observation
     *
     * @param ObserveDetourMotive $observeDetourMotive
     *
     * @return Item
     */
    public function includeObservation(ObserveDetourMotive $observeDetourMotive): Item
    {
        return $this->item($observeDetourMotive->observation, new ObserveTransformer(), 'observe');
    }

    /**
     * Include deviationTypeSetting
     *
     * @param ObserveDetourMotive $observeDetourMotive
     *
     * @return Item
     */
    public function includeDeviationTypeSetting(ObserveDetourMotive $observeDetourMotive): Item
    {
        return $this->item($observeDetourMotive->deviationTypeSetting, new DeviationTypeSettingTransformer(), 'deviationTypeSetting');
    }

    /**
     * Include motiveAllegedSetting
     *
     * @param ObserveDetourMotive $observeDetourMotive
     *
     * @return Item
     */
    public function includeMotiveAllegedSetting(ObserveDetourMotive $observeDetourMotive): Item
    {
        return $this->item($observeDetourMotive->motiveAllegedSetting, new MotiveAllegedSettingTransformer(), 'motiveAllegedSetting');
    }
}
