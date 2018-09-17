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
     * @param string|array $param1 - The field to be checked or an array of conditions
     * @param string $param2 - The value to be checked against param1 or an operator
     * @param string $param3 - The value to be checked against param1 according to the operator param2
     * @return self
     */
    public function where($param1, $param2=null, $param3=null)
    {
        try {
            if (! is_array($param1) && is_null($param2)) {
                throw new \Exception("A value must be passed if first parameter is not an array!");
            }

            if (is_array($param1)) {
                $this->query = $this->query->where($param1);
            } elseif (is_null($param3)) {
                $this->query = $this->query->where($param1, $param2);
            } else {
                $this->query = $this->query->where($param1, $param2, $param3);
            }
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
            $result = $this->query->find($id);
        } catch (\Exception $e) {
            return ApiException::serverError($e->getMessage());
        }

        $this->resetQuery();

        return $result;
    }

    /**
     * Find the first matching record of the query
     *
     * @return mixed
     */
    public function first()
    {
        try {
            $result = $this->query->first();
        } catch (\Exception $e) {
            return $e;
            return ApiException::serverError($e->getMessage());
        }

        $this->resetQuery();

        return $result;
    }

    /**
     * Find all of the matching records of the query
     *
     * @return mixed
     */
    public function get()
    {
        try {
            $result = $this->query->get();
        } catch (\Exception $e) {
            return ApiException::serverError($e->getMessage());
        }
        
        $this->resetQuery();
    
        return $result;
    }

    /**
     * Return the number of matching records
     *
     * @return int
     */
    public function count()
    {
        try {
            $result = $this->query->count();
        } catch (\Exception $e) {
            return ApiException::serverError($e->getMessage());
        }

        $this->resetQuery();

        return $result;
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

        $this->resetQuery();

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

        $this->resetQuery();

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

        $this->resetQuery();

        return true;
    }

    /**
     * Return the generated sql from the query
     */
    public function toSql()
    {
        return $this->query->toSql();
    }

    /**
     * Get query bindings
     */
    public function getBindings()
    {
        return $this->query->getBindings();
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

    /**
     * Return query instance
     *
     * @return self::query
     */
    public function query()
    {
        return $this->query;
    }

    /**
     * Reset the model property
     *
     * @return void
     */
    public function resetQuery()
    {
        $this->query = $this->model;
    }
}
