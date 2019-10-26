<?php

namespace Takaworx\Brix\Traits;

trait CanFullTextSearch
{
    public function match($query, $field, $value, $boolMode = true)
    {
        $match = "MATCH($field) AGAINST(?". ($boolMode ? " IN BOOLEAN MODE" : null) . ")";

        return $query->whereRaw($match, [
            $value,
        ]);
    }

    public function orMatch($query, $field, $value, $boolMode = true)
    {
        $match = "MATCH($field) AGAINST(?". ($boolMode ? " IN BOOLEAN MODE" : null) . ")";

        return $query->orWhereRaw($match, [
            $value,
        ]);
    }
}
