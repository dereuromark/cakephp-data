<?php
/**
 * @var \App\View\AppView $this
 * @var array $currencies
 * @var \Data\Model\Entity\Currency $currency
 */
?>

<div class="page form">
<?php echo $this->Form->create($currency);?>
	<fieldset>
		<legend><?php echo __d('data', 'Add {0}', __d('data', 'Currency'));?></legend>

	<?php
		echo $this->Form->control('name');
		echo $this->Form->control('code', ['datalist' => $currencies]);
		echo $this->Form->control('symbol_left');
		echo $this->Form->control('symbol_right');
		echo $this->Form->control('decimal_places');
		echo $this->Form->control('value');
	?>
	</fieldset>
<?php echo $this->Form->submit(__d('data', 'Submit')); echo $this->Form->end();?>
</div>

<br/>

Wird nur der Code angegeben, wird versucht, den Name automatisch dazu zu finden.
Das selbe gilt für den aktuellen Wechselkurs.

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'Currencies')), ['action' => 'index']);?></li>
	</ul>
</div>
