<div class="page index">
	<h2><?php echo __('Cities');?></h2>

	<table class="list">
		<tr>
		<th><?php echo $this->Paginator->sort('country_id');?></th>
		<th><?php echo $this->Paginator->sort('name');?></th>
		<th><?php echo $this->Paginator->sort('citizens');?></th>
		<th><?php echo $this->Paginator->sort('postal_code');?></th>
		<th><?php echo ('Coordinates');?></th>
		<th><?php echo $this->Paginator->sort('postal_code_unique');?></th>
		<th><?php echo $this->Paginator->sort('modified');?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
<?php
foreach ($cities as $city) { ?>
	<tr>
		<td>
			<?php echo h($city['Country']['name']); ?>
		</td>
		<td>
			<?php echo h($city['City']['name']); ?>
		</td>
		<td>
			<?php echo h($city['City']['citizens']); ?>
		</td>
		<td>
			<?php echo h($city['City']['postal_code']); ?>
		</td>
		<td>
			<?php echo $this->Numeric->format($city['City']['lat']); ?>/<?php echo $this->Numeric->format($city['City']['lng']); ?>
		</td>
		<td>
			<?php echo $this->Format->yesNo($city['City']['postal_code_unique']); ?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($city['City']['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Format->icon('view'), array('action' => 'view', $city['City']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), array('action' => 'edit', $city['City']['id']), array('escape' => false)); ?>
			<?php echo $this->Form->postLink($this->Format->icon('delete'), array('action' => 'delete', $city['City']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $city['City']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New %s', __('City')), array('action' => 'add')); ?></li>
	</ul>
</div>