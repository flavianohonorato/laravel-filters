<?php

namespace Wicool\LaraFilter;

trait LaraFilterTrait
{
    /**
     * @param $builder
     * @param $filters array
     * @return mixed
     */
    public function scopeFilter($builder, $filters = [])
    {
        if (!isset($filters)) {
            return $builder;
        }

        $table = $this->getTable();
        $defaultFillableFields = $this->fillable;

        foreach($filters as $field => $value) {
            if (in_array($field, $this->boolFilterFields, true) &&  !is_null($value)) {
                $builder->where($field, (bool)$value);
                continue;
            }

            if (!in_array($field, $defaultFillableFields, true) || is_null($value)) {
                continue;
            }

            if (in_array($field, $this->likeFilterFields, true)) {
                $builder->where($table.'.'.$field, 'LIKE', "%$value%");
            } else if (is_array($value)) {
                $builder->whereIn($field, $value);
            } else {
                $builder->where($field, $value);
            }
        }

        return $builder;
    }
}
