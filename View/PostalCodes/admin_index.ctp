<div class="page index">

<div class="searchBox" style="float: right;">
<?php
	echo $this->Form->create('PostalCode');
	echo $this->Form->input('code', array('placeholder' => 'Platzhalter: * und ?'));
	echo $this->Form->input('country_id', array('empty' => ' - egal - '));
	echo $this->Form->submit(__('Search'), array('div' => false));
	echo $this->Form->end();
?>
</div>

	<h2><?php echo __('Postal Codes');?></h2>

	<table class="list">
		<tr>
		<th><?php echo $this->Paginator->sort('code');?></th>
		<th><?php echo $this->Paginator->sort('country_id');?></th>
		<th><?php echo $this->Paginator->sort('lat');?></th>
		<th><?php echo $this->Paginator->sort('lng');?></th>
		<th><?php echo $this->Paginator->sort('official_address');?></th>
		<th><?php echo $this->Paginator->sort('created');?></th>
		<th><?php echo $this->Paginator->sort('modified');?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
<?php
$i = 0;
foreach ($postalCodes as $postalCode): ?>
	<tr>
		<td>
			<?php echo h($postalCode['PostalCode']['code']); ?>
		</td>
		<td>
			<?php echo h($postalCode['PostalCode']['country_id']); ?>
		</td>
		<td>
			<?php echo $this->Numeric->format($postalCode['PostalCode']['lat']); ?>
		</td>
		<td>
			<?php echo $this->Numeric->format($postalCode['PostalCode']['lng']); ?>
		</td>
		<td>
			<?php echo h($postalCode['PostalCode']['official_address']); ?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($postalCode['PostalCode']['created']); ?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($postalCode['PostalCode']['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Format->icon('view'), array('action' => 'view', $postalCode['PostalCode']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), array('action' => 'edit', $postalCode['PostalCode']['id']), array('escape' => false)); ?>
			<?php echo $this->Form->postLink($this->Format->icon('delete'), array('action' => 'delete', $postalCode['PostalCode']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $postalCode['PostalCode']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New %s', __('Postal Code')), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Query'), array('action' => 'query')); ?></li>
		<li><?php echo $this->Html->link(__('Geolocate'), array('action' => 'geolocate')); ?></li>
	</ul>
</div>