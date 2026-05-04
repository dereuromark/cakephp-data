<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\State $state
 */
?>
<div class="page form">
<?php echo $this->Form->create($state);?>
	<fieldset>
		<legend><?php echo __d('data', 'Edit {0}', __d('data', 'State'));?></legend>
	<?php
		//echo $this->Form->control('id');
		echo $this->Form->control('country_id', ['empty' => ' - [ ' . __d('data', 'pleaseSelect') . ' ]- ', 'required' => 1]);
		echo $this->Form->control('name', ['required' => 1]);
		echo $this->Form->control('ori_name');
		echo $this->Form->control('code');

	?>
	</fieldset>
	<?php echo $this->Form->submit(__d('data', 'Submit')); ?>
<?php echo $this->Form->end();?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Form->postButton(__d('data', 'Delete'), ['action' => 'delete', $state->id], [
			'escapeTitle' => false,
			'class' => 'btn btn-link p-0 align-baseline',
			'form' => [
				'class' => 'd-inline',
				'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $state->id),
			],
		]); ?></li>
		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'States')), ['action' => 'index']);?></li>
		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'Countries')), ['controller' => 'countries', 'action' => 'index']); ?> </li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
