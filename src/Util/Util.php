<?php

namespace App\Util;

class Util
{
    /**
     * @param iterable<mixed>|null $value
     */
    public static function iterableIsNotEmpty(?iterable $value): bool
    {
        if (null === $value) {
            return false;
        }

        foreach ($value as $_) {
            return true;
        }

        return false;
    }

    public static function isNotNull(mixed $value): bool
    {
        return null !== $value;
    }
}
