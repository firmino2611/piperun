<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Repositories;

use App\Models\Task;
use App\Models\User;
use App\Repositories\Contracts\RepositoryInterface;
use Carbon\Traits\Date;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Carbon\Carbon;
use TaskValidation;

class TaskRepository implements RepositoryInterface
{
    protected Task $model;

    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    /**
     * Recupera as atividades dentro do intervalo definido
     * para o inicio da atividade
     * @param $start
     * @param $end
     * @return array
     * @throws Exception
     */
    public function getAllStartDate($start, $end)
    {
        if (dateEndIsValid($start, $end))
            return array(
                'error' => 'O prazo deve ser em uma data acima da data de inicio',
            );

        $tasks = auth()->user()->tasks()->with('type')
            ->whereDate('start_at', '>=', getOnlyDate($start))
            ->whereDate('start_at', '<=', getOnlyDate($end))
            ->paginate(10);

        return $tasks;
    }

    /**
     * Recupera as atividades dentro do intervalo definido
     * para o prazo da atividade
     * @param $start
     * @param $end
     * @return array
     * @throws Exception
     */
    public function getAllEndDate($start, $end)
    {
        if (dateEndIsValid($start, $end))
            return array(
                'error' => 'A data final deve ser em uma data acima da data de inicio',
            );
        $tasks = auth()->user()->tasks()->with('type')
            ->whereDate('end_at', '>=', getOnlyDate($start))
            ->whereDate('end_at', '<=', getOnlyDate($end))
            ->paginate(10);

        return $tasks;
    }

    public function getAll()
    {
        $tasks = $this->model
            ->with('type')->orderBy('start_at', 'desc')
            ->paginate(10);

        return $tasks;
    }


    /**
     * Cria uma nova tarefa no banco de dados
     * @param array $data
     * @return array
     */
    public function create(array $data)
    {
        $conflicts = $this->checkConflictDates($data['startAt'], $data['endAt']);

        if (count($conflicts)) {
            return array(
                'error' => 'Conflito de datas',
                'data' => $conflicts,
                'success' => false
            );
        }
        // Caso não exista conflito de datas prossegue o cadastro no banco
        // Verificar se data não caiu em um final de semana
        try {
            $validation = TaskValidation::validate($data);
            if ($validation['success']) {
                $task = $this->model->newQuery()
                    ->create(array(
                        'description' => $data['description'],
                        'responsible' => $data['responsible'],
                        'start_at' => $data['startAt'],
                        'end_at' => $data['endAt'],
                        'status' => $data['status'],
                        'type_id' => $data['type'],
                        'user_id' => auth()->id(),
                    ));

                return array(
                    'data' => $task,
                    'success' => true
                );
            }
            return $validation;

        } catch (Exception $e) {
            return array(
                'error' => $e->getMessage(),
                'success' => false
            );
        }
    }

    public function updateById(int $task, array $data)
    {
        // Caso não exista conflito de datas prossegue o cadastro no banco
        // Verificar se data não caiu em um final de semana
        try {
            $task = $this->model->newQuery()->find($task);
            if ($task) {

                if (TaskValidation::hasChangeDates($task, $data)) {
                    $validation = TaskValidation::validate($data);

                    if (!$validation['success']) {
                        return $validation;
                    }

                    $conflicts = $this->checkConflictDates(
                        $data['startAt'],
                        $data['endAt'],
                        $task->id
                    );

                    if (count($conflicts)) {
                        return array(
                            'error' => 'Conflito de datas',
                            'data' => $conflicts
                        );
                    }
                }
                $task->update(array(
                    'description' => $data['description'],
                    'responsible' => $data['responsible'],
                    'start_at' => $data['startAt'],
                    'end_at' => $data['endAt'],
                    'finish_at' => $data['finishAt'] ?? $task->finish_at,
                    'status' => $data['status'],
                    'type_id' => $data['type'],
                    'user_id' => auth()->id(),
                ));

                return array(
                    'data' => $task,
                    'validation' => TaskValidation::hasChangeDates($task, $data),
                    'success' => true
                );
            }

            return array(
                'error' => 'Atividade não encontrada',
                'code' => 404
            );
        } catch (Exception $e) {
            return array(
                'error' => $e->getMessage(),
            );
        }
    }

    public function deleteById(int $id)
    {
        try {
            $task = $this->model->newQuery()->find($id)->delete();

            return $task;
        } catch (Exception $e) {
            return array(
                'error' => $e->getMessage(),
            );
        }
    }

    /**
     * Verifica se existem atividades conflitantes
     * com a data de ínicio e prazo final
     * @param String $start
     * @param String $end
     * @param null $taskID
     * @return bool|array
     */
    private function checkConflictDates($start, $end, $taskID = null)
    {
        try {
//            $start = explode('T', $start)[0];
//            $end = explode('T', $end)[0];

            // Tenta recuperar atividades conflitantes com a data de inicio e prazo final
            $taskOfUser = auth()->user()->tasks()
                ->whereDate('start_at', '<=', $start)
                ->whereDate('end_at', '>=', $start)
                ->orWhereDate('start_at', '<=', $end)
                ->whereDate('end_at', '>=', $end)
                ->get();

            if (count($taskOfUser)) {
                foreach ($taskOfUser as $index => $task)
                    if ($taskID == $task->id)
                        unset($taskOfUser[$index]);

                return $taskOfUser;
            }

            return [];
        } catch (Exception $err) {
            return [];
        }
    }

}
