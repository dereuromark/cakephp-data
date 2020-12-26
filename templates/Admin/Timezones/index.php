<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Timezone[]|\Cake\Collection\CollectionInterface $timezones
 */

use Cake\Core\Plugin;

?>
<nav class="actions large-3 medium-4 columns col-sm-4 col-xs-12" id="actions-sidebar">
    <ul class="side-nav nav nav-pills flex-column">
        <li class="nav-item heading"><?= __('Actions') ?></li>
        <li class="nav-item">
            <?= $this->Html->link(__('New {0}', __('Timezone')), ['action' => 'add'], ['class' => 'nav-link']) ?>
        </li>
		<li class="nav-item">
			<?php echo $this->Html->link(__('Sync'), ['action' => 'sync'], ['class' => 'nav-link']); ?>
		</li>
    </ul>
</nav>
<div class="timezones index content large-9 medium-8 columns col-sm-8 col-12">

	<h2><?= __('Timezones') ?></h2>

	<?php if (Plugin::isLoaded('Search')) { ?>
		<div class="search-box">
			<?php
			echo $this->Form->create(null, ['valueSources' => 'query']);
			echo $this->Form->control('search', ['placeholder' => __('wildcardSearch {0} and {1}', '*', '?')]);
			echo $this->Form->button(__('Search'), []);
			echo $this->Form->end();
			?>
		</div>
	<?php } ?>

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
                    <td>
						<?= h($timezone->name) ?>
						<div><small>
								<?php if ($timezone->canonical_timezone) {
									echo ' => ' . $this->Html->link($timezone->canonical_timezone->name, ['action' => 'view', $timezone->linked_id]);
								} ?>
							</small></div>
					</td>
                    <td><?php
						echo $timezone->country ? $this->Html->link($timezone->country_code, ['controller' => 'Countries', 'action' => 'view', $timezone->country->id]) : h($timezone->country_code)
						?></td>
                    <td><?= h($timezone->offset_string) ?></td>
                    <td><?= h($timezone->offset_dst_string) ?></td>
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
