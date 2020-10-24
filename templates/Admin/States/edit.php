<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\State $state
 */
?>
<div class="page form">
<?php echo $this->Form->create($state);?>
	<fieldset>
		<legend><?php echo __('Edit {0}', __('State'));?></legend>
	<?php
		//echo $this->Form->control('id');
		echo $this->Form->control('country_id', ['empty' => ' - [ ' . __('pleaseSelect') . ' ]- ', 'required' => 1]);
		echo $this->Form->control('name', ['required' => 1]);
		echo $this->Form->control('code');

	?>
	</fieldset>
	<?php echo $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end();?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $state->id], ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $state->id)]); ?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('States')), ['action' => 'index']);?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Countries')), ['controller' => 'countries', 'action' => 'index']); ?> </li>
	</ul>
</div>
