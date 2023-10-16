<?php

namespace App\Http\Requests\Absence;


class AbsenceCreateRequest extends AbsenceRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'usuario_id' => 'required|integer|exists:usuario,id',
//            'usuario_setor_id' => 'required|integer|exists:setor,id',
//            'motivo_id' => 'required|integer|exists:configuracao_ausencia_motivo,id',
            'data_inicial' => 'required|date',
            'data_final' => 'required|date',
            'situacao' => 'required|string',
            //            'rejeitado_motivo' => 'required|string',
        ];
    }
}
