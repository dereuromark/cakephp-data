<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page view">
<h2><?php echo __('Address');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Country'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($address['Country']['name'], ['controller' => 'countries', 'action' => 'view', $address['Country']['id']]); ?>
			&nbsp;
		</dd>
<?php if (Configure::read('Data.Address.State')) { ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Country Province'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($address['State']['name'], ['controller' => 'States', 'action' => 'view', $address['State']['id']]); ?>
			&nbsp;
		</dd>
<?php } ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('First Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($address['Address']['first_name']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Last Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($address['Address']['last_name']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Street'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($address['Address']['street']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Postal Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($address['Address']['postal_code']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('City'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($address['Address']['city']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Lat'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($address['Address']['lat']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Lng'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($address['Address']['lng']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Last Used'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Time->niceDate($address['Address']['last_used']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Formatted Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($address['Address']['formatted_address']); ?>
			&nbsp;
		</dd>
<?php if (Configure::read('Data.Address.debug')) { ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Debug'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo pre($address['Address']['geocoder_result']); ?>
			&nbsp;
		</dd>
<?php } ?>
	</dl>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit {0}', __('Address')), ['action' => 'edit', $address['Address']['id']]); ?> </li>
		<li><?php echo $this->Html->link(__('Mark as {0}', __('Used')), ['action' => 'mark_as_used', $address['Address']['id']]); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete {0}', __('Address')), ['action' => 'delete', $address['Address']['id']], null, __('Are you sure you want to delete # {0}?', $address['Address']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List {0}', __('Addresses')), ['action' => 'index']); ?> </li>
	</ul>
</div>
