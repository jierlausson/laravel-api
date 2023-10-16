<?php

namespace App\Http\Requests\Absence;


class AbsenceUpdateRequest extends AbsenceRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->getID();

        return [
//            'usuario_id' => 'integer|exists:usuario,id',
//            'usuario_setor_id' => 'integer|exists:setor,id',
//            'setor_id' => 'integer|exists:setor,id',
            'motivo_id' => 'string',
            'data_inicial' => 'date',
            'data_final' => 'date',
            'situacao' => 'string',
            //            'rejeitado_motivo' => 'string',
        ];
    }
}
