<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Currency $currency
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
<?php echo $this->Form->submit(__('Submit')); $this->Form->end();?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $currency->id], ['escape' => false, 'confirm'  => __('Are you sure you want to delete # {0}?', $currency->id)]); ?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Currencies')), ['action' => 'index']);?></li>
	</ul>
</div>
