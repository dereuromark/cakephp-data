<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page form">
<?php echo $this->Form->create($currency);?>
	<fieldset>
		<legend><?php echo __('Edit {0}', __('Currency'));?></legend>
	<?php
		//echo $this->Form->control('id');
		echo $this->Form->control('name');
		echo $this->Form->control('code');
		echo $this->Form->control('symbol_left');
		echo $this->Form->control('symbol_right');
		echo $this->Form->control('decimal_places');
		echo $this->Form->control('value');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $this->Form->getSourceValue('Currency.id')], ['escape' => false], __('Are you sure you want to delete # {0}?', $this->Form->getSourceValue('Currency.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Currencies')), ['action' => 'index']);?></li>
	</ul>
</div>
