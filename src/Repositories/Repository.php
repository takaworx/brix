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
