<div class="page index">
<h2><?php echo __('Addresses');?></h2>

<table class="list">
<tr>
	<th><?php echo $this->Paginator->sort('foreign_id');?></th>
	<th><?php echo $this->Paginator->sort('model');?></th>
	<th><?php echo $this->Paginator->sort('country_id');?></th>
	<th><?php echo $this->Paginator->sort('country_province_id');?></th>
	<th><?php echo $this->Paginator->sort('first_name');?></th>
	<th><?php echo $this->Paginator->sort('last_name');?></th>
	<th><?php echo $this->Paginator->sort('street');?></th>
	<th><?php echo $this->Paginator->sort('postal_code');?></th>
	<th><?php echo $this->Paginator->sort('city');?></th>
	<th><?php echo $this->Paginator->sort('lat');?></th>
	<th><?php echo $this->Paginator->sort('lng');?></th>
	<th><?php echo $this->Paginator->sort('last_used');?></th>
	<th><?php echo $this->Paginator->sort('formatted_address');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($addresses as $address):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $this->Html->link($address['User']['id'], array('controller' => 'users', 'action' => 'view', $address['User']['id'])); ?>
		</td>
		<td>
			<?php echo h($address['Address']['model']); ?>
		</td>
		<td>
			<?php echo $this->Html->link($address['Country']['name'], array('controller' => 'countries', 'action' => 'view', $address['Country']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($address['CountryProvince']['name'], array('controller' => 'country_provinces', 'action' => 'view', $address['CountryProvince']['id'])); ?>
		</td>
		<td>
			<?php echo h($address['Address']['first_name']); ?>
		</td>
		<td>
			<?php echo h($address['Address']['last_name']); ?>
		</td>
		<td>
			<?php echo h($address['Address']['street']); ?>
		</td>
		<td>
			<?php echo h($address['Address']['postal_code']); ?>
		</td>
		<td>
			<?php echo h($address['Address']['city']); ?>
		</td>
		<td>
			<?php echo h($address['Address']['lat']); ?>
		</td>
		<td>
			<?php echo h($address['Address']['lng']); ?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($address['Address']['last_used']); ?>
		</td>
		<td>
			<?php echo h($address['Address']['formatted_address']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Format->icon('view'), array('action' => 'view', $address['Address']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), array('action' => 'edit', $address['Address']['id']), array('escape' => false)); ?>
			<?php echo $this->Form->postLink($this->Format->icon('delete'), array('action' => 'delete', $address['Address']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $address['Address']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<div class="pagination-container">
<?php echo $this->element('Tools.pagination'); ?></div>

</div>

<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add %s', __('Address')), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List %s', __('Countries')), array('controller' => 'countries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Country Provinces')), array('controller' => 'country_provinces', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Users')), array('controller' => 'users', 'action' => 'index')); ?> </li>
	</ul>
</div>