<?php

declare(strict_types=1);

namespace CakeLteTools\Utility;

use Cake\Core\Configure;

class FaIcon
{
    const TYPE_SOLID = 'fas';
    const TYPE_REGULAR = 'far';
    const TYPE_LIGHT = 'fal';
    const TYPE_BRANDS = 'fab';

    const SIZE_2XS = '2xs';
    const SIZE_XS = 'xs';
    const SIZE_SM = 'sm';
    const SIZE_LG = 'lg';
    const SIZE_XL = 'xl';
    const SIZE_2XL = '2xl';

    private string $name;
    private string $type = self::TYPE_SOLID;
    private array $extraCssClass = [];

    /**
     * @param string $name
     * @param string $type
     * @param array|string $extraCssClass
     */
    public function __construct(string $name, string $type = self::TYPE_SOLID, array|string $extraCssClass = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->withExtraCssClass($extraCssClass);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $extraCssClass = trim(implode(' ', $this->extraCssClass));
        $class = trim(implode(' ', [
            $this->type,
            'fa-' . $this->name,
            $extraCssClass,
        ]));

        return "<i class=\"{$class}\"></i>";
    }

    /**
     * @param array|string|null $extraCssClass
     * @return static
     */
    public function withExtraCssClass(array|string|null $extraCssClass = []): self
    {
        if (empty($extraCssClass)) {
            return $this;
        }

        if (is_string($extraCssClass)) {
            $extraCssClass = explode(' ', $extraCssClass);
        }

        $this->extraCssClass = array_unique(array_merge($this->extraCssClass, $extraCssClass));

        return $this;
    }

    /**
     * @return static
     */
    public function cleanExtraCssClass(): self
    {
        $this->extraCssClass = [];

        return $this;
    }

    /**
     * @param string $size
     * @return static
     */
    public function withSize(string $size): self
    {
        return $this->withExtraCssClass("fa-{$size}");
    }

    /**
     * @return static
     */
    public function withFixedWidth(): self
    {
        return $this->withExtraCssClass('fa-fw');
    }

    /**
     * @return array
     */
    public static function getIcons(): array
    {
        return Configure::read('icons', []);
    }

    /**
     * @param string $key
     * @return array
     */
    public static function getIcon(string $key): array
    {
        return self::getIcons()[$key] ?? [];
    }

    /**
     * @param string $key
     * @param array|string $extraCssClass
     * @return static
     */
    public static function get(array|string $key = 'default', array|string $extraCssClass = [], array $options = []): self
    {
        $icon = self::getIcon($key);

        if (empty($icon)) {
            throw new \InvalidArgumentException("Icon {$key} not found");
        }
        
        [$type, $name, $extraCssClassDefault] = $icon + [null, null, null];

        $icon = (new static($name, $type))
            ->withExtraCssClass($extraCssClassDefault)
            ->withExtraCssClass($extraCssClass);

        if (isset($options['size'])) {
            $icon = $icon->withSize($options['size']);
        }

        if (isset($options['fixedWidth']) && $options['fixedWidth']) {
            $icon = $icon->withFixedWidth();
        }

        return $icon;
    }
}
