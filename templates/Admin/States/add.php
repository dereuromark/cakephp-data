<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page form">
<?php echo $this->Form->create();?>
	<fieldset>
		<legend><?php echo __('Add {0}', __('State'));?></legend>
	<?php
		echo $this->Form->control('country_id', ['empty' => ' - [ ' . __('pleaseSelect') . ' ] - ', 'required' => 1]);
		echo $this->Form->control('name', ['required' => 1]);
		echo $this->Form->control('ori_name');
		echo $this->Form->control('code');
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List {0}', __('States')), ['action' => 'index']);?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Countries')), ['controller' => 'Countries', 'action' => 'index']); ?> </li>
	</ul>
</div>
