<h2><?php echo __('Edit %s', __('Address')); ?></h2>

<div class="page form">
<?php echo $this->Form->create('Address');?>
	<fieldset>
		<legend><?php echo __('Edit %s', __('Address')); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('country_id', array('empty' => ' - [ ' . __('noSelection') . ' ] - '));
	if (Configure::read('Address.CountryProvince')) {
		echo $this->Form->input('country_province_id', array('empty' => ' - [ ' . __('noSelection') . ' ] - '));
	}
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('street');
		echo $this->Form->input('postal_code');
		echo $this->Form->input('city');
	?>
	</fieldset>
	<fieldset>
		<legend><?php echo __('Relations'); ?></legend>
	<?php
		echo $this->Form->input('model');
		echo $this->Form->input('foreign_id', array('type' => 'text', 'empty' => array(0 => ' - [ ' . __('noSelection') . ' ] - ')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Address.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Address.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List %s', __('Addresses')), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List %s', __('Countries')), array('controller' => 'countries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Country Provinces')), array('controller' => 'country_provinces', 'action' => 'index')); ?> </li>
	</ul>
</div>