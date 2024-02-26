<?php

declare(strict_types=1);

namespace CakeLteTools\Utility;

class Css
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
     * @param string|array $classes The CSS classes to be returned.
     * @return string The string of CSS classes.
     */
    public static function classToString(string|array $classes): string
    {
        if (is_string($classes)) {
            $classes = [$classes];
        }

        return implode(' ', self::flattenArray($classes));
    }
}
