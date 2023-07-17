<?php

declare(strict_types=1);

namespace CakeLteTools\Enum;

enum Color: string
{
    case DEFAULT = 'default';

    case PRIMARY = 'primary';
    case SECONDARY = 'secondary';
    case INFO = 'info';
    case SUCCESS = 'success';
    case WARNING = 'warning';
    case DANGER = 'danger';

    case BLACK = 'black';
    case GRAY_DARK = 'gray-dark';
    case GRAY = 'gray';
    case LIGHT = 'light';
    case DARK = 'dark';

    case INDIGO = 'indigo';
    case LIGHTBLUE = 'lightblue';
    case NAVY = 'navy';
    case PURPLE = 'purple';
    case FUCHSIA = 'fuchsia';
    case PINK = 'pink';
    case MAROON = 'maroon';
    case ORANGE = 'orange';
    case LIME = 'lime';
    case TEAL = 'teal';
    case OLIVE = 'olive';

    const TAGS = [
        'bg' => ['includeBase' => false],
        'text' => ['includeBase' => false],
        'badge' => ['includeBase' => true],
        'card' => ['includeBase' => true],
        'btn' => ['includeBase' => true],
        'btnOutline' => ['includeBase' => true],
    ];

    public function __call($name, $arguments)
    {
        if (!array_key_exists($name, static::TAGS)) {
            throw new \BadMethodCallException(sprintf('Method %s does not exist', $name));
        }

        $tag = static::TAGS[$name];

        return $this->cssClass($name, $tag['includeBase'], $arguments);
    }

    /**
     * @param string $name
     * @param boolean $includeBase
     * @param string $extraClass
     * @return string
     */
    public function cssClass(string $name, bool $includeBase = true, $arguments = []): string
    {
        ['base' => $base, 'prefix' => $prefix] = $this->mapTag($name);

        $output = implode(' ', [
            $includeBase ? $base : null,
            $prefix . '-' . $this->value,
        ]);

        return trim($output);
    }

    protected function mapTag(string $name): array
    {
        if ($name === 'btnOutline') {
            $base = 'btn';
            $prefix = 'btn-outline';
        } else {
            $prefix = $base = $name;
        }

        return [
            'base' => $base,
            'prefix' => $prefix,
        ];
    }
}
