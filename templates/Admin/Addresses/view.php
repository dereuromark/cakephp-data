<?php
/**
 * @var \App\View\AppView $this
 * @var array $address
 */
?>
<div class="page view">
<h2><?php echo __('Address');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Country'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($address->country['name'], ['controller' => 'countries', 'action' => 'view', $address->country['id']]); ?>
			&nbsp;
		</dd>
<?php if (Configure::read('Data.Address.State')) { ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Country Province'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($address->state['name'], ['controller' => 'States', 'action' => 'view', $address->state['id']]); ?>
			&nbsp;
		</dd>
<?php } ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('First Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($address['first_name']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Last Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($address['last_name']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Street'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($address['street']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Postal Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($address['postal_code']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('City'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($address['city']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Lat'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($address['lat']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Lng'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($address['lng']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Last Used'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Time->niceDate($address['last_used']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Formatted Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($address['formatted_address']); ?>
			&nbsp;
		</dd>
<?php if (Configure::read('Data.Address.debug')) { ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Debug'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo pre($address['geocoder_result']); ?>
			&nbsp;
		</dd>
<?php } ?>
	</dl>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit {0}', __('Address')), ['action' => 'edit', $address['id']]); ?> </li>
		<li><?php echo $this->Html->link(__('Mark as {0}', __('Used')), ['action' => 'mark_as_used', $address['id']]); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete {0}', __('Address')), ['action' => 'delete', $address['id']], null, __('Are you sure you want to delete # {0}?', $address['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List {0}', __('Addresses')), ['action' => 'index']); ?> </li>
	</ul>
</div>
