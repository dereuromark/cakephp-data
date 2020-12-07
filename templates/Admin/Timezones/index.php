<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $timezones
 */
?>
<nav class="actions large-3 medium-4 columns col-sm-4 col-xs-12" id="actions-sidebar">
    <ul class="side-nav nav nav-pills flex-column">
        <li class="nav-item heading"><?= __('Actions') ?></li>
        <li class="nav-item">
            <?= $this->Html->link(__('New {0}', __('Timezone')), ['action' => 'add'], ['class' => 'nav-link']) ?>
        </li>
    </ul>
</nav>
<div class="timezones index content large-9 medium-8 columns col-sm-8 col-12">

    <h2><?= __('Timezones') ?></h2>

    <div class="">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('country_code') ?></th>
                    <th><?= $this->Paginator->sort('offset') ?></th>
                    <th><?= $this->Paginator->sort('offset_dst') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('active') ?></th>
                    <th><?= $this->Paginator->sort('lat') ?></th>
                    <th><?= $this->Paginator->sort('lng') ?></th>
                    <th><?= $this->Paginator->sort('covered') ?></th>
                    <th><?= $this->Paginator->sort('notes') ?></th>
                    <th><?= $this->Paginator->sort('created', null, ['direction' => 'desc']) ?></th>
                    <th><?= $this->Paginator->sort('modified', null, ['direction' => 'desc']) ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($timezones as $timezone): ?>
                <tr>
                    <td><?= h($timezone->name) ?></td>
                    <td><?= h($timezone->country_code) ?></td>
                    <td><?= h($timezone->offset) ?></td>
                    <td><?= h($timezone->offset_dst) ?></td>
                    <td><?= h($timezone->type) ?></td>
                    <td><?= $this->Format->yesNo($timezone->active) ?></td>
                    <td><?= h($timezone->lat) ?></td>
                    <td><?= h($timezone->lng) ?></td>
                    <td><?= h($timezone->covered) ?></td>
                    <td><?= h($timezone->notes) ?></td>
                    <td><?= $this->Time->nice($timezone->created) ?></td>
                    <td><?= $this->Time->nice($timezone->modified) ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link($this->Format->icon('view'), ['action' => 'view', $timezone->id], ['escapeTitle' => false]); ?>
                        <?php echo $this->Html->link($this->Format->icon('edit'), ['action' => 'edit', $timezone->id], ['escapeTitle' => false]); ?>
                        <?php echo $this->Form->postLink($this->Format->icon('delete'), ['action' => 'delete', $timezone->id], ['escapeTitle' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $timezone->id)]); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php echo $this->element('Tools.pagination'); ?>
</div>
