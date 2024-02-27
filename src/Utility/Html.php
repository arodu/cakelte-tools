<?php

declare(strict_types=1);

namespace CakeLteTools\Utility;

class Html
{
    /**
     * Flattens a multidimensional array into a single-dimensional array.
     *
     * @param array $array The array to be flattened.
     * @return array The flattened array.
     */
    public static function flattenArray(array $array): array
    {
        $flattened = [];
        array_walk_recursive($array, function ($value) use (&$flattened) {
            if (!is_null($value)) {
                $flattened[] = $value;
            }
        });

        return $flattened;
    }

    /**
     * Returns a string of CSS classes.
     *
     * @param array $classes The CSS classes to be returned.
     * @return string The string of CSS classes.
     */
    public static function classToString(array $arrayClass): string
    {
        return implode(' ', self::flattenArray($arrayClass));
    }
}
