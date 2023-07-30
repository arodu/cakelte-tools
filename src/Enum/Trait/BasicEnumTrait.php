<?php

declare(strict_types=1);

namespace CakeLteTools\Enum\Trait;

use Cake\Utility\Inflector;

trait BasicEnumTrait
{
    /**
     * @return string
     */
    public function label(): string
    {
        return Inflector::humanize($this->value);
    }

    /**
     * @param self|string|array $item
     * @return bool
     */
    public function is(self|string|array $item): bool
    {
        if (is_string($item)) {
            return $this->value === $item;
        }

        if (is_array($item)) {
            return in_array($this, $item, true);
        }

        if (is_array($item) && !empty($this?->value)) {
            return in_array($this->value, $item, true);
        }

        if ($item instanceof self) {
            return $this === $item;
        }

        return false;
    }

    /**
     * @param mixed $value
     * @return self
     */
    public static function get(mixed $value): self
    {
        return self::tryFrom($value);
    }
}
