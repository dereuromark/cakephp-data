<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Data\Model\Entity\Address> $addresses
 */
?>
<div class="page index">
<h2><?php echo __('Addresses');?></h2>

<table class="table">
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

?>
	<tr>
		<td>
			<?php echo $this->Html->link($address->user['id'], ['plugin' => false, 'controller' => 'Users', 'action' => 'view', $address->user['id']]); ?>
		</td>
		<td>
			<?php echo h($address['model']); ?>
		</td>
		<td>
			<?php echo $this->Html->link($address->country->name, ['controller' => 'Countries', 'action' => 'view', $address->country->id]); ?>
		</td>
		<td>
			<?php echo $this->Html->link($address->state['name'], ['controller' => 'States', 'action' => 'view', $address->state['id']]); ?>
		</td>
		<td>
			<?php echo h($address['first_name']); ?>
		</td>
		<td>
			<?php echo h($address['last_name']); ?>
		</td>
		<td>
			<?php echo h($address['street']); ?>
		</td>
		<td>
			<?php echo h($address['postal_code']); ?>
		</td>
		<td>
			<?php echo h($address['city']); ?>
		</td>
		<td>
			<?php echo h($address->lat); ?>
		</td>
		<td>
			<?php echo h($address->lng); ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($address['last_used']); ?>
		</td>
		<td>
			<?php echo h($address['formatted_address']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Icon->render('view'), ['action' => 'view', $address['id']], ['escape' => false]); ?>
			<?php echo $this->Html->link($this->Icon->render('edit'), ['action' => 'edit', $address['id']], ['escape' => false]); ?>
			<?php echo $this->Form->postLink($this->Icon->render('delete'), ['action' => 'delete', $address['id']], ['escape' => false, 'confirm' => 'Sure?']); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<div class="pagination-container">
<?php echo $this->element('Tools.pagination'); ?></div>

</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add {0}', __('Address')), ['action' => 'add']); ?></li>
	</ul>
</div>
