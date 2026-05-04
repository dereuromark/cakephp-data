<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Continent $continent
 */
?>
<h2><?php echo __d('data', 'Edit {0}', __d('data', 'Continent')); ?></h2>

<div class="page form">
<?php echo $this->Form->create($continent);?>
	<fieldset>
		<legend><?php echo __d('data', 'Edit {0}', __d('data', 'Continent')); ?></legend>
	<?php
		echo $this->Form->control('name');
		//echo $this->Form->control('ori_name');
		echo $this->Form->control('code');

		echo $this->Form->control('parent_id', []);
		//echo $this->Form->control('status');
	?>
	</fieldset>
<?php echo $this->Form->submit(__d('data', 'Submit')); echo $this->Form->end();?>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Form->postButton(__d('data', 'Delete'), ['action' => 'delete', $this->Form->getSourceValue('Continent.id')], [
			'class' => 'btn btn-link p-0 align-baseline',
			'form' => [
				'class' => 'd-inline',
				'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $this->Form->getSourceValue('Continent.id')),
			],
		]); ?></li>
		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'Continents')), ['action' => 'index']);?></li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
