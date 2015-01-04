<div class="page view">
<h2><?php echo __('Address');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Country'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($address['Country']['name'], array('controller' => 'countries', 'action' => 'view', $address['Country']['id'])); ?>
			&nbsp;
		</dd>
<?php if (Configure::read('Address.CountryProvince')) { ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Country Province'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($address['CountryProvince']['name'], array('controller' => 'country_provinces', 'action' => 'view', $address['CountryProvince']['id'])); ?>
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
			<?php echo $this->Datetime->niceDate($address['Address']['last_used']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Formatted Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($address['Address']['formatted_address']); ?>
			&nbsp;
		</dd>
<?php if (Configure::read('Address.debug')) { ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Debug'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo pre($address['Address']['geocoder_result']); ?>
			&nbsp;
		</dd>
<?php } ?>
	</dl>
</div>

<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit %s', __('Address')), array('action' => 'edit', $address['Address']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Mark as %s', __('Used')), array('action' => 'mark_as_used', $address['Address']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete %s', __('Address')), array('action' => 'delete', $address['Address']['id']), null, __('Are you sure you want to delete # %s?', $address['Address']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Addresses')), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Countries')), array('controller' => 'countries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Country Provinces')), array('controller' => 'country_provinces', 'action' => 'index')); ?> </li>
	</ul>
</div>