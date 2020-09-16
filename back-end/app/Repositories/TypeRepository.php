<?php
namespace App\Repositories;

use App\Models\Type;
use App\Repositories\Contracts\RepositoryInterface;

class TypeRepository implements RepositoryInterface
{
    protected Type $model;

    public function __construct(Type $model)
    {
        $this->model = $model;
    }

    /**
     * Recupera todos os registro do banco
     * @return mixed
     */
    public function getAll()
    {
        return auth()->user()->types;
    }

    /**
     * Cria um novo tipo no banco
     * @param array $data
     * @return array|mixed
     */
    public function create(array $data)
    {
        $type = $this->model->newQuery()->create(array(
            'name' => $data['name'],
            'user_id' => auth()->id()
        ));
        return array(
            'data' => $type,
            'success' => true
        );
    }

    /**
     * Atualiza um registro no banco
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateById(int $id, array $data)
    {
        $type = $this->model->newQuery()->find($id);

        if ($type) {
            $type->update(array(
                'name' => $data['name'],
                'user_id' => auth()->id()
            ));
            return array(
                'data' => $type,
                'success' => false
            );
        }

        return array(
            'error' => 'Tipo não encontrado',
            'success' => false
        );
    }

    /**
     * Remove do banco um registro
     * @param int $id
     * @return array
     */
    public function deleteById(int $id)
    {
        $type = $this->model->newQuery()->find($id);

        if ($type) {
            try {
                $response = $type->delete($id);

                return array(
                    'data' => $response,
                    'success' => true
                );
            } catch (\Exception $e) {
                return array(
                    'error' => $e->getMessage(),
                    'success' => false
                );
            }

        }
        return array(
            'error' => 'Tipo não encontrado',
            'success' => false
        );
    }
}
