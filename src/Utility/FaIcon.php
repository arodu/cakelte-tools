<?php

declare(strict_types=1);

namespace CakeLteTools\Utility;

use Cake\Utility\Inflector;

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

    static protected array $default_icons = [
        'default' => ['fas', 'flag'],
        'download' => ['fas', 'download'],
        'in-progress' => ['fas', 'cogs'],
        'waiting' => ['fas', 'pause'],
        'success' => ['fas', 'check'],
        'failed' => ['fas', 'exclamation-triangle'],
        'review' => ['fas', 'eye'],
        'star' => ['fas', 'star'],
        'search' => ['fas', 'search'],
        'view' => ['fas', 'search'],
        'filter' => ['fas', 'filter'],
        'error' => ['fas', 'bug'],
        'edit' => ['fas', 'edit'],
        'locked' => ['fas', 'lock'],
        'delete' => ['fas', 'trash'],
        'remove' => ['fas', 'times'],
        'add' => ['fas', 'plus'],
        'add-circle' => ['fas', 'plus-circle'],
        'refresh' => ['fas', 'sync'],
        'refresh-spin' => ['fas', 'sync', 'fa-spin'],
        'spinner-spin' => ['fas', 'spinner', 'fa-spin'],
        'cog-spin' => ['fas', 'cog', 'fa-spin'],
        'spinner-pulse' => ['fas', 'spinner', 'fa-pulse'],
        'telegram' => ['fab', 'telegram-plane'],
        'home' => ['fas', 'home'],
        'university' => ['fas', 'university'],
        'copyrigth' => ['fas', 'copyrigth'],
        'add' => ['fas', 'plus'],
        'file-csv' => ['fas', 'file-csv'],
        'validate' => ['fas', 'check'],
        'save' => ['fas', 'save'],
        'back' => ['fas', 'arrow-left'],
        'link' => ['fas', 'external-link-alt'],
        'openModal' => ['fas', 'external-link-alt'],
        'report' => ['fas', 'file-alt'],
        'tasks' => ['fas', 'tasks'],
        'user' => ['fas', 'user-circle'],
        'close' => ['fas', 'window-close'],
        'check' => ['fas', 'check-circle'],
        'chart-bar' => ['fas', 'chart-bar'],
    ];

    public static function getIcon(string $key = null): array
    {
        if (empty($key)) {
            return static::$default_icons;
        }

        return static::$default_icons[$key];
    }

    public static function setIcon(string|array $key, array $options = []): void
    {
        if (is_string($key)) {
            static::$default_icons[$key] = $options;
            return;
        }

        if (is_array($key)) {
            static::$default_icons = array_merge(static::$default_icons, $key);
            return;
        }

        throw new \InvalidArgumentException("Icon {$key} not found");
    }

    /**
     * @param string $key
     * @param array|string $extraCssClass
     * @return static
     */
    public static function get(array|string $key = 'default', array|string $extraCssClass = [], array $options = []): self
    {
        if (is_string($key) && !array_key_exists($key, static::getIcon())) {
            throw new \InvalidArgumentException("Icon {$key} not found");
        }

        if (is_array($key)) {
            [$type, $name, $extraCssClassDefault] = $key + [null, null, null];
        } elseif (is_string($key)) {
            [$type, $name, $extraCssClassDefault] = static::getIcon($key) + [null, null, null];
        } else {
            throw new \InvalidArgumentException("Icon {$key} not found");
        }

        $icon = (new static($name, $type))
            ->withExtraCssClass($extraCssClassDefault)
            ->withExtraCssClass($extraCssClass);

        if (isset($options['size'])) {
            $icon->withSize($options['size']);
        }

        if (isset($options['fixedWidth']) && $options['fixedWidth']) {
            $icon->withFixedWidth();
        }

        return $icon;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return static
     */
    public static function __callStatic(string $name, array $arguments = []): self
    {
        $name = substr($name, 3);
        $name = strtolower(Inflector::dasherize($name));

        return static::get($name, ...$arguments);
    }
}
