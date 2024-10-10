<?php

namespace smn\routing\logic;

class Equal
{


    protected array $values = [];

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function getValues() : array
    {
        return $this->values;
    }

    public function assert(string $field) : bool
    {
        return (in_array($field, $this->values));
    }

}