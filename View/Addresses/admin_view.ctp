<div class="page view">
<h2><?php echo __('Address');?></h2>
	<dl>

		<dt><?php echo __('Country'); ?></dt>
		<dd>
			<?php echo $this->Html->link($address['Country']['name'], ['controller' => 'countries', 'action' => 'view', $address['Country']['id']]); ?>
			&nbsp;
		</dd>
<?php if (Configure::read('Address.CountryProvince')) { ?>
		<dt><?php echo __('Country Province'); ?></dt>
		<dd>
			<?php echo $this->Html->link($address['CountryProvince']['name'], ['controller' => 'country_provinces', 'action' => 'view', $address['CountryProvince']['id']]); ?>
			&nbsp;
		</dd>
<?php } ?>
		<dt><?php echo __('First Name'); ?></dt>
		<dd>
			<?php echo h($address['Address']['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Name'); ?></dt>
		<dd>
			<?php echo h($address['Address']['last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Street'); ?></dt>
		<dd>
			<?php echo h($address['Address']['street']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Postal Code'); ?></dt>
		<dd>
			<?php echo h($address['Address']['postal_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($address['Address']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lat'); ?></dt>
		<dd>
			<?php echo h($address['Address']['lat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lng'); ?></dt>
		<dd>
			<?php echo h($address['Address']['lng']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Used'); ?></dt>
		<dd>
			<?php echo $this->Datetime->niceDate($address['Address']['last_used']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Formatted Address'); ?></dt>
		<dd>
			<?php echo h($address['Address']['formatted_address']); ?>
			&nbsp;
		</dd>
<?php if (Configure::read('Address.debug')) { ?>
		<dt><?php echo __('Debug'); ?></dt>
		<dd>
			<?php echo pre($address['Address']['geocoder_result']); ?>
			&nbsp;
		</dd>
<?php } ?>
	</dl>
</div>

<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit %s', __('Address')), ['action' => 'edit', $address['Address']['id']]); ?> </li>
		<li><?php echo $this->Html->link(__('Mark as %s', __('Used')), ['action' => 'mark_as_used', $address['Address']['id']]); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete %s', __('Address')), ['action' => 'delete', $address['Address']['id']], ['confirm' => __('Are you sure you want to delete # %s?', $address['Address']['id'])]); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Addresses')), ['action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Countries')), ['controller' => 'countries', 'action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Country Provinces')), ['controller' => 'country_provinces', 'action' => 'index']); ?> </li>
	</ul>
</div>