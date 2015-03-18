<div class="page form">
<?php echo $this->Form->create('Currency');?>
	<fieldset>
		<legend><?php echo __('Edit %s', __('Currency'));?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('code');
		echo $this->Form->input('symbol_left');
		echo $this->Form->input('symbol_right');
		echo $this->Form->input('decimal_places');
		echo $this->Form->input('value');
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $this->Form->value('Currency.id')], ['escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Currency.id'))]); ?></li>
		<li><?php echo $this->Html->link(__('List %s', __('Currencies')), ['action' => 'index']);?></li>
	</ul>
</div>