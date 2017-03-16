<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\PostalCode[] $postalCodes
 */
?>
<div class="page index">

<div class="searchBox" style="float: right;">
<?php
	echo $this->Form->create('PostalCode');
	echo $this->Form->input('code', ['placeholder' => 'Platzhalter: * und ?']);
	echo $this->Form->input('country_id', ['empty' => ' - egal - ']);
	echo $this->Form->submit(__('Search'), ['div' => false]);
	echo $this->Form->end();
?>
</div>

	<h2><?php echo __('Postal Codes');?></h2>

	<table class="table">
		<tr>
		<th><?php echo $this->Paginator->sort('code');?></th>
		<th><?php echo $this->Paginator->sort('country_id');?></th>
		<th><?php echo $this->Paginator->sort('lat');?></th>
		<th><?php echo $this->Paginator->sort('lng');?></th>
		<th><?php echo $this->Paginator->sort('official_address');?></th>
		<th><?php echo $this->Paginator->sort('created', null, ['direction' => 'desc']);?></th>
		<th><?php echo $this->Paginator->sort('modified', null, ['direction' => 'desc']);?></th>
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
			<?php echo $this->Number->format($postalCode['PostalCode']['lat']); ?>
		</td>
		<td>
			<?php echo $this->Number->format($postalCode['PostalCode']['lng']); ?>
		</td>
		<td>
			<?php echo h($postalCode['PostalCode']['official_address']); ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($postalCode['PostalCode']['created']); ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($postalCode['PostalCode']['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Format->icon('view'), ['action' => 'view', $postalCode['PostalCode']['id']], ['escape' => false]); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), ['action' => 'edit', $postalCode['PostalCode']['id']], ['escape' => false]); ?>
			<?php echo $this->Form->postLink($this->Format->icon('delete'), ['action' => 'delete', $postalCode['PostalCode']['id']], ['escape' => false], __('Are you sure you want to delete # {0}?', $postalCode['PostalCode']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New {0}', __('Postal Code')), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__('Query'), ['action' => 'query']); ?></li>
		<li><?php echo $this->Html->link(__('Geolocate'), ['action' => 'geolocate']); ?></li>
	</ul>
</div>