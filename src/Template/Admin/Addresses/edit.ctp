<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2><?php echo __('Edit {0}', __('Address')); ?></h2>

<div class="page form">
<?php echo $this->Form->create('Address');?>
	<fieldset>
		<legend><?php echo __('Edit {0}', __('Address')); ?></legend>
	<?php
		//echo $this->Form->input('id');
		echo $this->Form->input('country_id', ['empty' => ' - [ ' . __('noSelection') . ' ] - ']);
	if (Configure::read('Data.Address.State')) {
		echo $this->Form->input('state_id', ['empty' => ' - [ ' . __('noSelection') . ' ] - ']);
	}
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('street');
		echo $this->Form->input('postal_code');
		echo $this->Form->input('city');
	?>
	</fieldset>
	<fieldset>
		<legend><?php echo __('Relations'); ?></legend>
	<?php
		echo $this->Form->input('model');
		echo $this->Form->input('foreign_id', ['type' => 'text', 'empty' => [0 => ' - [ ' . __('noSelection') . ' ] - ']]);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $this->Form->getSourceValue('Address.id')], null, __('Are you sure you want to delete # {0}?', $this->Form->getSourceValue('Address.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Addresses')), ['action' => 'index']);?></li>
	</ul>
</div>
