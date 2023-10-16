<?php

namespace App\Http\Requests\Observe;


class ObserveCreateRequest extends ObserveRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'usuario_id' => 'required|integer|exists:usuario,id',
            'usuario_setor_id' => 'required|integer|exists:setor,id',
            'setor_id' => 'required|integer|exists:setor,id',
            'local' => 'required|string',
            'data' => 'required|date',
            'tipo' => 'required|string',
            //            'observado' => 'required|string',
//            'observado_setor_id' => 'required|integer|exists:setor,id',
            'log_cadastro_usuario_id' => 'required|integer',
            //            'desvio_motivo' => 'required|array',
            //            'desvio_motivo.*.tipoDesvioId' => 'required|integer',
            //            'desvio_motivo.*.motivoAlegadoId' => 'required|integer',
        ];
    }
}
