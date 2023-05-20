<?php

/**
 * @var \App\View\AppView $this
 * @var string $selector
 * @var array $config
 * @var array $steps
 * @var \App\View\Helper\StepperHelper $stepper
 */

use Cake\Utility\Hash;
use Cake\Utility\Text;

$globalForm = !empty(Hash::get($config, 'form'));

$createForm = $globalForm ? $this->Form->create(Hash::get($config, 'form.context', null), Hash::get($config, 'form.options', [])) : null;
$body = implode('', $stepper->getBodyItems());
$endForm = $globalForm ? $this->Form->end() : null;
$vertical = Hash::get($config, 'vertical', false) ? 'vertical' : null;

$headerItemFormat = <<<ITEM_FORMAT
<div class="step" data-target="#:id">
    <button type="button" class="step-trigger" role="tab" aria-controls=":id" id=":idTrigger" aria-selected="true">
        <span class="bs-stepper-circle">:circle</span>
        <span class="bs-stepper-label">:title</span>
    </button>
</div>
ITEM_FORMAT;

$headerLineFormat = '<div class="line"></div>';

?>
<div class="<?= trim(implode(' ', [$selector, $vertical])) ?>">
    <div class="bs-stepper-header" role="tablist">
        <?php $output = [] ?>
        <?php foreach ($steps as $key => $step) : ?>
            <?php
            $circle = $step['circle'] ?? ($key + 1);
            $id = $step['id'];
            $idTrigger = $id . '-trigger';

            $output[] = Text::insert($headerItemFormat, [
                'id' => $id,
                'idTrigger' => $idTrigger,
                'circle' => $circle,
                'title' => $step['title'],
            ]);
            ?>
        <?php endforeach; ?>
        <?= implode($headerLineFormat, $output) ?>
    </div>

    <?= $createForm ?>
    <div class="bs-stepper-content">
        <?= $body ?>
    </div>
    <?= $endForm ?>

</div>

<?= $this->Html->css(Hash::get($config, 'cssPath'), ['block' => true]) ?>
<?= $this->Html->script(Hash::get($config, 'jsPath'), ['block' => true]) ?>
<script>
    <?= $this->Html->scriptStart(['block' => true]) ?>
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector(".<?= Hash::get($config, 'selector', 'bs-stepper') ?>"), {
            linear: <?= Hash::get($config, 'linear', 'true') ?>,
            animation: <?= Hash::get($config, 'linear', 'animation') ?>,
        })
        stepper.to(<?= Hash::get($config, 'activeStep', 0) ?>)
    })
    <?= $this->Html->scriptEnd() ?>
</script>