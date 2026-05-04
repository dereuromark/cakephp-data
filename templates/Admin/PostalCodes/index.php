<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Data\Model\Entity\PostalCode> $postalCodes
 */
?>
<div class="page index">

<div class="searchBox" style="float: right;">
<?php
	echo $this->Form->create(null, ['valueSources' => 'query']);
	echo $this->Form->control('code', ['placeholder' => __d('data', 'Placeholder') . ': * und ?']);
	echo $this->Form->control('country_id', ['empty' => ' - egal - ']);
	echo $this->Form->button(__d('data', 'Search'));
	echo $this->Form->end();
?>
</div>

	<h2><?php echo __d('data', 'Postal Codes');?></h2>

	<table class="table">
		<tr>
		<th><?php echo $this->Paginator->sort('code');?></th>
		<th><?php echo $this->Paginator->sort('country_id');?></th>
		<th><?php echo $this->Paginator->sort('lat');?></th>
		<th><?php echo $this->Paginator->sort('lng');?></th>
		<th><?php echo $this->Paginator->sort('official_address');?></th>
		<th><?php echo $this->Paginator->sort('created', null, ['direction' => 'desc']);?></th>
		<th><?php echo $this->Paginator->sort('modified', null, ['direction' => 'desc']);?></th>
		<th class="actions"><?php echo __d('data', 'Actions');?></th>
	</tr>
<?php
$i = 0;
foreach ($postalCodes as $postalCode): ?>
	<tr>
		<td>
			<?php echo h($postalCode['code']); ?>
		</td>
		<td>
			<?php echo h($postalCode['country_id']); ?>
		</td>
		<td>
			<?php echo $this->Number->format($postalCode['lat']); ?>
		</td>
		<td>
			<?php echo $this->Number->format($postalCode['lng']); ?>
		</td>
		<td>
			<?php echo h($postalCode['official_address']); ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($postalCode['created']); ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($postalCode['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Icon->render('view'), ['action' => 'view', $postalCode['id']], ['escapeTitle' => false]); ?>
			<?php echo $this->Html->link($this->Icon->render('edit'), ['action' => 'edit', $postalCode['id']], ['escapeTitle' => false]); ?>
			<?php echo $this->Form->postButton($this->Icon->render('delete'), ['action' => 'delete', $postalCode['id']], [
				'escapeTitle' => false,
				'class' => 'btn btn-link p-0 align-baseline',
				'form' => [
					'class' => 'd-inline',
					'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $postalCode['id']),
				],
			]); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>

	<div class="pagination-container">
<?php echo $this->element('Tools.pagination'); ?>
	</div>

</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('data', 'New {0}', __d('data', 'Postal Code')), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__d('data', 'Query'), ['action' => 'query']); ?></li>
		<li><?php echo $this->Html->link(__d('data', 'Geolocate'), ['action' => 'geolocate']); ?></li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
