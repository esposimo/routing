<?php

namespace smn\routing\logic;

class Assert
{
    public static function Equal(array $values, string $field) : bool
    {
        $instance = new Equal($values);
        return $instance->assert($field);
    }


}