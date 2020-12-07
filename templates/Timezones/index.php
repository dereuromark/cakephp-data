<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Timezone[]|\Cake\Collection\CollectionInterface $timezones
 */
?>
<div class="timezones index content large-9 medium-8 columns col-12">
    <h1><?= __('Timezones') ?></h1>

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
					<th><?php echo __('Coordinates');?></th>
                    <th><?= $this->Paginator->sort('covered') ?></th>
                    <th><?= $this->Paginator->sort('notes') ?></th>
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
					<td><?php
						$coordinates = '';
						if ($timezone->lat !== null || $timezone->lng) {
							$coordinates = $timezone->lat . ',' . $timezone->lng;
						}
						echo $this->Format->yesNo((int)!empty($coordinates), ['onTitle' => $coordinates, 'offTitle' => 'n/a']);
                    ?></td>
                    <td><?= h($timezone->covered) ?></td>
                    <td><?= h($timezone->notes) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php echo $this->element('Tools.pagination'); ?>
</div>
