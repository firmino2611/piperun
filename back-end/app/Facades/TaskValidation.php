<?php

namespace App\Facades;

use App\Models\Task;

/**
 * Class TaskValidation
 * Responsável por fazer as validações necessarias
 * para que uma atividade seja válida
 * @package App\Facades
 */
class TaskValidation
{
    /**
     * Faz as validações referente as datas da tarefa
     * @param $data
     * @return array|bool[]
     */
    static public function validate($data)
    {
        // Caso não exista conflito de datas prossegue o cadastro no banco
        // Verificar se data não caiu em um final de semana
        try {

            if (isWeekend($data['startAt']) or isWeekend($data['endAt']))
                return array(
                    'error' => 'Finais de semana não são permitidos',
                    'success' => false
                );

            if (dateEndIsValid($data['startAt'], $data['endAt']))
                return array(
                    'error' => 'O prazo deve ser em uma data acima da data de inicio',
                    'success' => false
                );

            if (empty($data['description']) or empty($data['responsible']))
                return array(
                    'error' => 'Campos obrigatórios não preenchidos',
                    'success' => false
                );
            return array(
                'success' => true
            );
        } catch (\Exception $e) {
            return array(
                'error' => $e->getMessage(),
            );
        }
    }

    /**
     * Verifica se houve alteração nas data de inicio ou prazo da atividade
     * @param Task $task
     * @param array $data
     * @return bool
     */
    static public function hasChangeDates($task, $data)
    {
        if ($task->start_at != $data['start_at'] . ' 00:00:00'
            || $task->end_at != $data['end_at'] . ' 00:00:00')
            return true;

        return false;
    }
}
