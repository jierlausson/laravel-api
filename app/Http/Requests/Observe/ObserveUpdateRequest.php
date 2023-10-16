<?php

namespace App\Http\Requests\Observe;


class ObserveUpdateRequest extends ObserveRequest
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
            'usuario_id' => 'integer|exists:usuario,id',
            'usuario_setor_id' => 'integer|exists:setor,id',
            'setor_id' => 'integer|exists:setor,id',
            'local' => 'string',
            'data' => 'date',
            'tipo' => 'string',
            //            'observado' => 'string',
//            'observado_setor_id' => 'integer|exists:setor,id',
            'observacao' => 'string',
            'log_cadastro_usuario_id' => 'integer',
            //            'desvio_motivo' => 'array',
            //            'desvio_motivo.*.tipoDesvioId' => 'integer',
            //            'desvio_motivo.*.motivoAlegadoId' => 'integer',
        ];
    }
}
