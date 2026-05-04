<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Currency $currency
 */
?>
<div class="page form">
<?php echo $this->Form->create($currency);?>
	<fieldset>
		<legend><?php echo __d('data', 'Edit {0}', __d('data', 'Currency'));?></legend>
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
<?php echo $this->Form->submit(__d('data', 'Submit')); echo $this->Form->end();?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Form->postButton(__d('data', 'Delete'), ['action' => 'delete', $currency->id], [
			'escapeTitle' => false,
			'class' => 'btn btn-link p-0 align-baseline',
			'form' => [
				'class' => 'd-inline',
				'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $currency->id),
			],
		]); ?></li>
		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'Currencies')), ['action' => 'index']);?></li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
