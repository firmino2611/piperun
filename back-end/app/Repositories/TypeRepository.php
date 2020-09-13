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

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById(int $id)
    {
        // TODO: Implement getById() method.
    }

    public function getBy(string $name, string $value)
    {
        // TODO: Implement getBy() method.
    }

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
