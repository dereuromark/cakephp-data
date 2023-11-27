<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Data\Model\Entity\City> $cities
 */
?>
<div class="page index">
	<h2><?php echo __('Cities');?></h2>

	<table class="table">
		<tr>
		<th><?php echo $this->Paginator->sort('country_id');?></th>
		<th><?php echo $this->Paginator->sort('name');?></th>
		<th><?php echo $this->Paginator->sort('citizens');?></th>
		<th><?php echo $this->Paginator->sort('postal_code');?></th>
		<th><?php echo ('Coordinates');?></th>
		<th><?php echo $this->Paginator->sort('postal_code_unique');?></th>
		<th><?php echo $this->Paginator->sort('modified', null, ['direction' => 'desc']);?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
<?php
foreach ($cities as $city) { ?>
	<tr>
		<td>
			<?php if ($city->country) {
				echo h($city->country->name);
			} ?>
		</td>
		<td>
			<?php echo h($city['name']); ?>
		</td>
		<td>
			<?php echo h($city['citizens']); ?>
		</td>
		<td>
			<?php echo h($city['postal_code']); ?>
		</td>
		<td>
			<?php echo $this->Number->format($city['lat']); ?>/<?php echo $this->Number->format($city['lng']); ?>
		</td>
		<td>
			<?php echo $this->Format->yesNo($city['postal_code_unique']); ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($city['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Icon->render('view'), ['action' => 'view', $city['id']], ['escape' => false]); ?>
			<?php echo $this->Html->link($this->Icon->render('edit'), ['action' => 'edit', $city['id']], ['escape' => false]); ?>
			<?php echo $this->Form->postLink($this->Icon->render('delete'), ['action' => 'delete', $city['id']], ['escape' => false, 'confirm' => 'Sure?']); ?>
		</td>
	</tr>
<?php } ?>
	</table>

	<div class="pagination-container">
<?php echo $this->element('Tools.pagination'); ?>
	</div>

</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New {0}', __('City')), ['action' => 'add']); ?></li>
	</ul>
</div>
