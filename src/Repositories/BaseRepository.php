<?php

namespace Takaworx\Brix\Repositories;

class BaseRepository
{
    protected $model;

    public function model()
    {
        return $this->model;
    }
}
