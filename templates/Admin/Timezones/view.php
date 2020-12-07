<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Timezone $timezone
 */
?>
<div class="row">
    <aside class="column actions large-3 medium-4 col-sm-4 col-xs-12">
        <ul class="side-nav nav nav-pills flex-column">
            <li class="nav-item heading"><?= __('Actions') ?></li>
            <li class="nav-item"><?= $this->Html->link(__('Edit {0}', __('Timezone')), ['action' => 'edit', $timezone->id], ['class' => 'side-nav-item']) ?></li>
            <li class="nav-item"><?= $this->Form->postLink(__('Delete {0}', __('Timezone')), ['action' => 'delete', $timezone->id], ['confirm' => __('Are you sure you want to delete # {0}?', $timezone->id), 'class' => 'side-nav-item']) ?></li>
            <li class="nav-item"><?= $this->Html->link(__('List {0}', __('Timezones')), ['action' => 'index'], ['class' => 'side-nav-item']) ?></li>
        </ul>
    </aside>
    <div class="column-responsive column-80 content large-9 medium-8 col-sm-8 col-xs-12">
        <div class="timezones view content">
            <h2><?= h($timezone->name) ?></h2>

            <table class="table table-striped">
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($timezone->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Country Code') ?></th>
                    <td><?= h($timezone->country_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Offset') ?></th>
                    <td><?= h($timezone->offset) ?></td>
                </tr>
                <tr>
                    <th><?= __('Offset Dst') ?></th>
                    <td><?= h($timezone->offset_dst) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($timezone->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Covered') ?></th>
                    <td><?= h($timezone->covered) ?></td>
                </tr>
                <tr>
                    <th><?= __('Notes') ?></th>
                    <td><?= h($timezone->notes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lat') ?></th>
                    <td><?= $this->Number->format($timezone->lat) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lng') ?></th>
                    <td><?= $this->Number->format($timezone->lng) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= $this->Time->nice($timezone->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= $this->Time->nice($timezone->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Active') ?></th>
                    <td><?= $this->Format->yesNo($timezone->active) ?> <?= $timezone->active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
