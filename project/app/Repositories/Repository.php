<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Criterias\Criteria;
use App\Contracts\Repositories\CriteriaContract;
use App\Exceptions\Repositories\RepositoryException;

abstract class Repository implements CriteriaContract
{
    protected $customBaseModel;
    protected $model;
    protected $class;
    protected $criteria;
    protected $skipCriteria = false;

    public function __construct()
    {
        $this->criteria = collect();
        $this->resetScope();
        $this->resetQuery();
    }

    abstract protected function getClass();

    public function setCustomBaseModel(Model $model)
    {
        $this->customBaseModel = $model;
        return $this;
    }

    protected function resetQuery()
    {
        $this->model = $this->makeModel();
    }

    public function returnOrFindModel($element)
    {
        $class = $this->getClass();
        if ($element instanceof $class) {
            return $element;
        }

        if (is_numeric($element)) {
            return $this->makeModel()->findOrFail($element);
        }
    }

    protected function returnOrFindModelWithTrashed($element)
    {
        $class = $this->getClass();
        if ($element instanceof $class) {
            return $element;
        }

        if (is_numeric($element)) {
            return $this->model->withTrashed()->findOrFail($element);
        }
    }

    public function first()
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->first();
    }

    public function all($columns = ['*'])
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->select($columns)->get();
    }

    public function pluck($key, $value = null)
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->pluck($key, $value);
    }

    public function find($id, $columns = ['*'])
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->find($id);
    }

    public function findOrFail($id, $columns = ['*'])
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->findOrFail($id);
    }

    public function findOrNew($id, $columns = ['*'])
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->findOrNew($id);
    }

    public function firstOrCreate($data)
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->firstOrCreate($data);
    }

    public function updateOrCreate(array $conditions, array $data)
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->updateOrCreate($conditions, $data);
    }

    public function findBy(array $fieldOperatorValue, $columns = ['*'])
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model
            ->where($fieldOperatorValue)
            ->addSelect($columns);
    }

    public function whereIn(string $field, array $values, array $columns = ['*'])
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model
            ->whereIn($field, $values)
            ->addSelect($columns)
            ->get();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function request($data)
    {
        $data['is_active'] = false;
        $unit = $this->model->create($data);

        return $unit;
    }

    public function delete($id)
    {
        $this->resetQuery();
        $model = $this->returnOrFindModel($id);
        $model->delete();
        return $model;
    }

    public function purge()
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->delete();
    }

    public function deleteMultiple($ids)
    {
        $this->resetQuery();
        return $this->model->whereIn('id', $ids)->delete();
    }

    public function restore($id)
    {
        $this->resetQuery();
        $model = $this->returnOrFindModelWithTrashed($id);
        $model->restore();
        return $model;
    }

    public function update($id, $data)
    {
        $this->resetQuery();
        $model = $this->returnOrFindModel($id);
        $model->update($data);

        return $model;
    }

    public function updates($data)
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->update($data);
    }

    public function paginate($perPage = 15, $columns = ['*'])
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->paginate($perPage, $columns);
    }

    public function count()
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->count();
    }

    public function exists()
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->exists();
    }

    public function doesntExists()
    {
        return !$this->exists();
    }

    /**
     * Returns an empty model manipulated by the repository
     *
     * @return mixed
     * @throws RepositoryException
     */
    public function getNewModel($options = [])
    {
        $class = $this->getClass();
        $model = new $class($options);

        if (!$model instanceof Model) {
            $illuminate = 'Illuminate\\Database\\Eloquent\\Model';
            $message = "Class {$class} must be an instance of {$illuminate}";
            throw new RepositoryException($message);
        }

        return $model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws RepositoryException
     */
    public function makeModel($options = [])
    {
        if ($this->customBaseModel) {
            return $this->customBaseModel->newQuery();
        }

        return $this->getNewModel($options)->newQuery();
    }

    public function resetScope()
    {
        $this->skipCriteria(false);
        return $this;
    }

    public function skipCriteria($status = true)
    {
        $this->skipCriteria = $status;
        return $this;
    }

    public function getCriteria()
    {
        return $this->criteria;
    }

    public function getByCriteria(Criteria $criteria)
    {
        $this->model = $criteria->apply($this->model, $this);
        return $this;
    }

    public function pushCriteria($criterias)
    {
        if (is_array($criterias) || $criterias instanceof Collection) {
            foreach ($criterias as $criteria) {
                $this->pushCriteria($criteria);
            }
        } else {
            $this->criteria->push($criterias);
        }

        return $this;
    }

    public function applyCriteria()
    {
        if ($this->skipCriteria === true) {
            return $this;
        }

        foreach ($this->getCriteria() as $criteria) {
            if ($criteria instanceof Criteria) {
                $this->model = $criteria->apply($this->model, $this);
            } else {
                $class = get_class($criteria);
                $message = "Class {$class} must be an instance of App\\Base\\Criteria";
                throw new RepositoryException($message);
            }
        }

        return $this;
    }

    public function resetCriteria()
    {
        $this->criteria = collect();
        return $this;
    }

    public function toSql()
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model->toSql();
    }

    public function getQuery(): Builder
    {
        $this->resetQuery();
        $this->applyCriteria();
        return $this->model;
    }

    public function undelete($id)
    {
        $trashedModel = $this->returnOrFindModelWithTrashed($id);

        if ($trashedModel->trashed()) {
            $trashedModel->restore();
        }

        return $trashedModel;
    }
}
