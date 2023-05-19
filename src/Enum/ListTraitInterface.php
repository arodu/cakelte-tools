<?php

declare(strict_types=1);

namespace CakeLteTools\Enum;

interface ListInterface
{
    public function label(): string;
    public static function toListLabel(array $cases = null): array;
    public static function toListName(array $cases = null): array;
    public static function names(array $cases = null): array;
    public static function values(array $cases = null): array;
}
