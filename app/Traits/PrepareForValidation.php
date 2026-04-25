<?php

namespace App\Traits;

trait PrepareForValidation
{
    protected $lineBreakFields = ['description'];

    public function beforeValidation($excepts=[])
    {
        foreach ($this->rules() as $field => $rule) {
            if (property_exists($this, $field) && !in_array($field, $excepts)) {
                $this->{$field} = sanitizeTextField($this->{$field}, keep_linebreak: in_array($field, $this->lineBreakFields));
            }
        }
    }
}
