<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Address $address
 */

use Cake\Core\Configure;

?>
<h2><?php echo __d('data', 'Edit {0}', __d('data', 'Address')); ?></h2>

<div class="page form">
<?php echo $this->Form->create($address);?>
	<fieldset>
		<legend><?php echo __d('data', 'Edit {0}', __d('data', 'Address')); ?></legend>
	<?php
		//echo $this->Form->control('id');
		echo $this->Form->control('country_id', ['empty' => ' - [ ' . __d('data', 'noSelection') . ' ] - ']);
	if (Configure::read('Data.Address.State')) {
		echo $this->Form->control('state_id', ['id' => 'country-states', 'empty' => ' - [ ' . __d('data', 'noSelection') . ' ] - ']);
	}
		echo $this->Form->control('first_name');
		echo $this->Form->control('last_name');
		echo $this->Form->control('street');
		echo $this->Form->control('postal_code');
		echo $this->Form->control('city');
	?>
	</fieldset>
	<fieldset>
		<legend><?php echo __d('data', 'Relations'); ?></legend>
	<?php
		echo $this->Form->control('model');
		echo $this->Form->control('foreign_id', ['type' => 'text', 'empty' => [0 => ' - [ ' . __d('data', 'noSelection') . ' ] - ']]);
	?>
	</fieldset>
<?php echo $this->Form->submit(__d('data', 'Submit')); echo $this->Form->end();?>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Form->postButton(__d('data', 'Delete'), ['action' => 'delete', $this->Form->getSourceValue('Address.id')], [
			'class' => 'btn btn-link p-0 align-baseline',
			'form' => [
				'class' => 'd-inline',
				'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $this->Form->getSourceValue('Address.id')),
			],
		]); ?></li>
		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'Addresses')), ['action' => 'index']);?></li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
