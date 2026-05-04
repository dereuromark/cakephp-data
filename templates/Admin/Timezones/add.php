<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Timezone $timezone
 */
?>
<div class="row">
    <aside class="column large-3 medium-4 columns col-sm-4 col-12">
        <ul class="side-nav nav nav-pills flex-column">
            <li class="nav-item heading"><?= __d('data', 'Actions') ?></li>
            <li class="nav-item"><?= $this->Html->link(__d('data', 'List Timezones'), ['action' => 'index'], ['class' => 'side-nav-item']) ?></li>
        </ul>
    </aside>
    <div class="column-responsive column-80 form large-9 medium-8 columns col-sm-8 col-12">
        <div class="timezones form content">
            <h2><?= __d('data', 'Timezones') ?></h2>

            <?= $this->Form->create($timezone) ?>
            <fieldset>
                <legend><?= __d('data', 'Add Timezone') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('country_code');
                    echo $this->Form->control('offset');
                    echo $this->Form->control('offset_dst');
                    echo $this->Form->control('type');
                    echo $this->Form->control('active');
                    echo $this->Form->control('lat');
                    echo $this->Form->control('lng');
					echo $this->Form->control('covered', ['type' => 'textarea']);
					echo $this->Form->control('notes', ['type' => 'textarea']);
                ?>
            </fieldset>
            <?= $this->Form->button(__d('data', 'Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
