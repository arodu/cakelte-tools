<?php
declare(strict_types=1);

namespace CakeLteTools\Enum;

interface ListInterface
{
    /**
     * @return string
     */
    public function label(): string;

    /**
     * @param array|null $cases
     * @return array
     */
    public static function toListLabel(?array $cases = null): array;

    /**
     * @param array|null $cases
     * @return array
     */
    public static function toListName(?array $cases = null): array;

    /**
     * @param array|null $cases
     * @return array
     */
    public static function names(?array $cases = null): array;

    /**
     * @param array|null $cases
     * @return array
     */
    public static function values(?array $cases = null): array;
}
