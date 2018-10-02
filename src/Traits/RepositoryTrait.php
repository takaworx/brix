<?php

namespace Takaworx\Brix\Traits;

trait RepositoryTrait
{
    public function match($field, $value, $boolMode = true)
    {
        $query = "MATCH($field) AGAINST(?". ($boolMode ? " IN BOOLEAN MODE" : null) . ")";

        return $this->whereRaw($query, [
            $value,
        ]);
    }

    public function orMatch($field, $value, $boolMode = true)
    {
        $query = "MATCH($field) AGAINST(?". ($boolMode ? " IN BOOLEAN MODE" : null) . ")";

        return $this->orWhereRaw($query, [
            $value,
        ]);
    }
}