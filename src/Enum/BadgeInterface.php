<?php

declare(strict_types=1);

namespace CakeLteTools\Enum;

use CakeLteTools\Enum\Color;

interface BadgeInterface
{
    public function label(): string;
    public function color(): Color;
}
