<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $currencies
 * @var \Data\Model\Entity\Currency $currency
 */
?>

<div class="page form">
<?php echo $this->Form->create($currency);?>
	<fieldset>
		<legend><?php echo __('Add {0}', __('Currency'));?></legend>

	<?php
		echo $this->Form->control('name');
		echo $this->Form->control('code', ['datalist' => $currencies]);
		echo $this->Form->control('symbol_left');
		echo $this->Form->control('symbol_right');
		echo $this->Form->control('decimal_places');
		echo $this->Form->control('value');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<br/>

Wird nur der Code angegeben, wird versucht, den Name automatisch dazu zu finden.
Das selbe gilt für den aktuellen Wechselkurs.

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List {0}', __('Currencies')), ['action' => 'index']);?></li>
	</ul>
</div>
