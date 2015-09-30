<div class="page form">
<?php echo $this->Form->create('CountryProvince');?>
	<fieldset>
		<legend><?php echo __('Add {0}', __('CountryProvince'));?></legend>
	<?php
		echo $this->Form->input('country_id', ['empty' => ' - [ ' . __('pleaseSelect') . ' ] - ', 'required' => 1]);
		echo $this->Form->input('name', ['required' => 1]);
		echo $this->Form->input('abbr');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List {0}', __('CountryProvinces')), ['action' => 'index']);?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Countries')), ['controller' => 'countries', 'action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('Add {0}', __('Country')), ['controller' => 'countries', 'action' => 'add']); ?> </li>
	</ul>
</div>