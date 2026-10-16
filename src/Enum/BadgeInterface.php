<?php
declare(strict_types=1);

namespace CakeLteTools\Enum;

interface BadgeInterface
{
    /**
     * @return string
     */
    public function label(): string;

    /**
     * @return \CakeLteTools\Enum\Color
     */
    public function color(): Color;
}
