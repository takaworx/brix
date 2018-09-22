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

    public function __construct($model)
    {
        return $this->model = $model;
    }

    /**
     * Full-text Search
     *
     * @param string $field
     * @param string $attribute
     * @return self::model
     */
    public function match($field, $value)
    {
        return $this->model->whereRaw("MATCH($field) AGAINST('?')", [
            $value,
        ]);
    }

    /**
     * Full-text Search with OR operator
     *
     * @param string $field
     * @param string $attribute
     * @return self::model
     */
    public function orMatch($field, $value)
    {
        return $this->model->orWhereRaw("MATCH($field) AGAINST('?')", [
            $value,
        ]);
    }

    /**
     * Get the value of model property
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * Set the value of the new model property
     *
     * @param $model
     * @return self
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }
}
