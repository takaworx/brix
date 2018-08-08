<?php

namespace Takaworx\Brix\Repositories;

use Illuminate\Support\Facades\DB;
use Takaworx\Brix\Exceptions\ApiException;

class Repository
{
    /**
     * The model of the repository
     *
     * @var mixed
     */
    protected $model;

    /**
     * The query of the repository
     *
     * @var mixed
     */
    protected $query;

    public function __construct($model)
    {
        $this->model = $model;
        $this->query = $this->model;
    }

    /**
     * Set the conditions for the query
     *
     * @param array $conditions
     * @return self
     */
    public function where($conditions)
    {
        try {
            $this->query = $this->query->where($conditions);
        } catch (\Exception $e) {
            return ApiException::serverError($e->getMessage());
        }

        return $this;
    }

    /**
     * Find the model with the given id
     *
     * @param int $id
     * @return mixed
     */
    public function find($id)
    {
        try {
            return $this->query->find($id);
        } catch (\Exception $e) {
            return ApiException::serverError($e->getMessage());
        }
    }

    /**
     * Find the first matching record of the query
     *
     * @return mixed
     */
    public function first()
    {
        try {
            return $this->query->first();
        } catch (\Exception $e) {
            return ApiException::serverError($e->getMessage());
        }
    }

    /**
     * Find all of the matching records of the query
     *
     * @return mixed
     */
    public function get()
    {
        try {
            return $this->query->get();
        } catch (\Exception $e) {
            return ApiException::serverError($e->getMessage());
        }
    }

    /**
     * Return the number of matching records
     *
     * @return int
     */
    public function count()
    {
        try {
            return $this->query->count();
        } catch (\Exception $e) {
            return ApiException::serverError($e->getMessage());
        }
    }

    /**
     * Create a new record of the model
     *
     * @param array $data
     * @return mixed
     */
    public function store($data)
    {
        try {
            DB::beginTransaction();

            $user = $this->query->create($data);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return ApiException::serverError($e->getMessage());
        }

        return $user;
    }

    /**
     * Update an existing record
     *
     * @param array $data
     * @return mixed
     */
    public function update($data)
    {
        try {
            DB::beginTransaction();

            $user = $this->query->first();

            foreach ($data as $key => $val) {
                if (!in_array($key, $this->model->getFillable())) {
                    continue;
                }

                $user->{$key} = $val;
            }

            $user->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiException::serverError($e->getMessage());
        }

        return $user;
    }

    /**
     * Delete a record
     *
     * @return bool
     */
    public function delete()
    {
        try {
            DB::beginTransaction();

            $this->query->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return ApiException::serverError($e->getMessage());
        }

        return true;
    }

    /**
     * Return model instance
     *
     * @return self::model
     */
    public function model()
    {
        return $this->model;
    }
}
