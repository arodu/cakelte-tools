<?php

declare(strict_types=1);

namespace CakeLteTools\View\Helper;

use Cake\Utility\Text;
use Cake\View\Helper;
use Cake\View\View;

/**
 * BulkAction helper
 */
class BulkActionHelper extends Helper
{
    public $helpers = ['Form', 'Html'];

    public const TYPE_ALL = 'all';
    public const TYPE_ITEM = 'item';

    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
        'fieldNameAll' => 'all',
        'fieldNameItem' => 'item',
        'fieldNameSelectAction' => 'action',
        'url' => ['action' => 'bulkAction'],

        'cssClassAll' => 'bulk-all',
        'cssClassItem' => 'bulk-item',
        'selectAction' => 'bulk-action',
        'checkRow' => 'check-row',
        'form' => 'bulk-form',

        'templates' => [
            'confirm' => '{content}',
        ],
    ];

    protected $scriptTemplate = <<<SCRIPT_TEMPLATE
    $(function () {
        $("{{cssClassAll}}").on("change", function() {
            let items = $("{{cssClassItem}}")
            let all = $("{{cssClassAll}}")
            all.prop("indeterminate", false)
            if ($(this).is(":checked")) {
                items.prop("checked", true)
                all.prop("checked", true)
            } else {
                items.prop("checked", false)
                all.prop("checked", false)
            }
        })

        $("{{cssClassItem}}").on("change", function() {
            let all = $("{{cssClassAll}}")
            all.prop("indeterminate", true)
        })

        $("{{checkRow}}").on("click", function() {
            let item = $(this).find("{{cssClassItem}}");
            item.prop("checked", !item.is(":checked"))
            item.trigger('change')

            //let all = $("{{cssClassAll}}")
            //all.prop("indeterminate", true)
        })
    })
    SCRIPT_TEMPLATE;

    public function scripts()
    {
        $script = Text::insert($this->scriptTemplate, [
            'cssClassAll' => '.' . $this->getConfig('cssClassAll'),
            'cssClassItem' => '.' . $this->getConfig('cssClassItem'),
            'selectAction' => '.' . $this->getConfig('selectAction'),
            'checkRow' => '.' . $this->getConfig('checkRow'),
        ], [
            'before' => '{{',
            'after' => '}}',
        ]);

        return $this->Html->scriptBlock($script, ['block' => true]);
    }

    /**
     * @param string $fieldName
     * @param array $options
     * @return string|null
     */
    public function checkbox(string $fieldName, array $options = []): ?string
    {
        $options += [
            'type' => 'checkbox',
            'label' => false,
            'hiddenField' => false,
        ];

        $options['class'] = implode(' ', [$this->getConfig('cssClassItem'), $options['class'] ?? '']);

        return $this->Form->checkbox($fieldName, $options);
    }

    /**
     * @param string|null $fieldName
     * @param array $options
     * @return string|null
     */
    public function checkboxAll(?string $fieldName = null, array $options = []): ?string
    {
        $fieldName = $fieldName ?? $this->getConfig('fieldNameAll');
        $options += [
            'type' => 'checkbox',
            'label' => false,
            'hiddenField' => false,
            'name' => false,
        ];

        $options['class'] = implode(' ', [$this->getConfig('cssClassAll'), $options['class'] ?? '']);

        return $this->Form->checkbox($fieldName, $options);
    }

    public function selectActions($actions, array $options = [])
    {
        $options = array_merge([
            'label' => false,
            'empty' => true,
            'required' => true,
            'class' => '',
        ], $options);

        $options['class'] .= ' ' . $this->getConfig('selectAction');

        return $this->Form->select($this->getConfig('fieldNameSelectAction'), $actions, $options);
    }
}
