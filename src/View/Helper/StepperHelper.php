<?php

declare(strict_types=1);

namespace CakeLteTools\View\Helper;

use Cake\Utility\Hash;
use Cake\Utility\Text;
use Cake\View\Helper;

/**
 * @property \Cake\View\Helper\HtmlHelper $Helper
 * 
 * Stepper helper
 */
class StepperHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
        'previousButton' => null,
        'nextButton' => null,
        'finishButton' => null,
        'element' => 'CakeLteTools.stepper',
        'activeStep' => 0,
        'linear' => true,
        'vertical' => false,
        'form' => [ // null to remove globalForm
            'context' => null,
            'options' => [],
        ],

        // html formats
        'stepHeaderFormat' => null,
        'stepContentFormat' => null,
        'generalFormat' => null,
        'scriptFormat' => null,

        'selector' => 'bs-stepper',
        'cssPath' => '/adminlte/plugins/bs-stepper/css/bs-stepper.min.css',
        'jsPath' => '/adminlte/plugins/bs-stepper/js/bs-stepper.min.js',
    ];

    protected $_steps = [];

    public $helpers = ['Html', 'Form'];

    public function initialize(array $config): void
    {
        $this->setConfig([
            'previousButton' => $config['previousButton'] ?? __('Previous'),
            'nextButton' => $config['nextButton'] ?? __('Next'),
            'finishButton' => $config['finishButton'] ?? __('Finish'),
        ]);
    }

    public function addStep(array $options = [])
    {
        $count = count($this->_steps) + 1;

        if (empty($options['id'])) {
            $options['id'] = 'step-' . $count;
        }

        if (empty($options['title'])) {
            $options['title'] = __('Step {0}', $count);
        }

        if (empty($options['content'])) {
            $options['content'] = $this->Html->tag('div', __('Content {0} not found!', $options['title']), ['class' => 'alert alert-warning']);
        }

        if (empty($options['form']) || !empty($this->getConfig('form'))) {
            $options['form'] = null;
        }

        $this->_steps[] = $options;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return $this->getView()->element($this->getConfig('element', 'stepper'), [
            'selector' => $this->getConfig('selector', 'bs-stepper'),
            'config' => $this->getConfig(),
            'steps' => $this->_steps,
            'stepper' => $this,
        ]);
    }

    protected $_defaultStepContentFormat = <<<STEP_CONTENT_FORMAT
        <div id=":id" class="content" role="tabpanel" aria-labelledby=":idTrigger">
            :formCreate
            :contentTab
            <hr />
            :footerStep
            :formEnd
        </div>
    STEP_CONTENT_FORMAT;

    public function getBodyItems(): array
    {
        $output = [];
        foreach ($this->_steps as $key => $step) {
            $id = $step['id'];
            $idTrigger = $id . '-trigger';

            if (is_callable($step['content'] ?? null)) {
                $contentTab = $this->_getObData($step['content']);
            } else {
                $contentTab = $step['content'] ?? '';
            }

            if (empty($this->getConfig('form')) && !empty($step['form'])) {
                $formCreate = $this->Form->create(Hash::get($step, 'form.context', null), Hash::get($step, 'form.options', []));
                $formEnd = $this->Form->end();
            }

            $output[] = Text::insert($this->getConfig('stepContentFormat') ?? $this->_defaultStepContentFormat, [
                'id' => $id,
                'idTrigger' => $idTrigger,
                'formCreate' => $formCreate ?? null,
                'formEnd' => $formEnd ?? null,
                'contentTab' => $contentTab,
                'footerStep' => $this->renderFooter($key),
            ]);
        }

        return $output;
    }

    public function button(string $label, array $options = []): string
    {
        $options += [
            'type' => 'button',
            'class' => 'btn btn-info',
            'escapeTitle' => false,
        ];

        return $this->Form->button($label, $options);
    }

    protected function renderFooter($currentKey): string
    {
        $left = $this->button($this->getConfig('previousButton'), ['onclick' => 'stepper.previous()']);
        $right = $this->button($this->getConfig('nextButton'), ['onclick' => 'stepper.next()']);

        $customFooter = !empty($this->_steps[$currentKey]['footerLeft']) || !empty($this->_steps[$currentKey]['footerRight']);
        if ($customFooter) {
            if (is_callable($this->_steps[$currentKey]['footerLeft'] ?? null)) {
                $left = $this->_getObData($this->_steps[$currentKey]['footerLeft']);
            } else {
                $left = $this->_steps[$currentKey]['footerLeft'] ?? $left;
            }

            if (is_callable($this->_steps[$currentKey]['footerRight'] ?? null)) {
                $right = $this->_getObData($this->_steps[$currentKey]['footerRight']);
            } else {
                $right = $this->_steps[$currentKey]['footerRight'] ?? $right;
            }
        } else if (array_key_first($this->_steps) === $currentKey) {
            $left = null;
        } elseif (array_key_last($this->_steps) === $currentKey) {
            $right = $this->button($this->getConfig('finishButton'), ['type' => 'submit', 'class' => 'btn btn-primary']);
        }

        $left = !empty($left) ? $this->Html->tag('div', $left, ['class' => 'mr-auto']) : null;
        $right = !empty($right) ? $this->Html->tag('div', $right, ['class' => 'ml-auto']) : null;

        return $this->Html->tag('div', $left . $right, ['class' => 'd-flex']);
    }

    protected function _getObData(callable $function): string|false
    {
        ob_start();
        echo $function($this->getView());
        return ob_get_clean();
    }
}
