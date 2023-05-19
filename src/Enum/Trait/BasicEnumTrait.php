<?php

declare(strict_types=1);

namespace CakeLteTools\Enum\Trait;

trait BasicEnumTrait
{
    /**
     * @param mixed $item
     * @return bool
     */
    public function is(mixed $item): bool
    {
        if (is_string($item)) {
            return $this->value === $item;
        }

        if (is_array($item)) {
            return in_array($this, $item, true);
        }

        return $this === $item;
    }
}
