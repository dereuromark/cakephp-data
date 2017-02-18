<div class="page form">
<?php echo $this->Form->create();?>
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
		<li><?php echo $this->Html->link(__('List {0}', __('States')), ['action' => 'index']);?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Countries')), ['controller' => 'Countries', 'action' => 'index']); ?> </li>
	</ul>
</div>
