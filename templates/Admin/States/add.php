<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page form">
<?php echo $this->Form->create();?>
	<fieldset>
		<legend><?php echo __d('data', 'Add {0}', __d('data', 'State'));?></legend>
	<?php
		echo $this->Form->control('country_id', ['empty' => ' - [ ' . __d('data', 'pleaseSelect') . ' ] - ', 'required' => 1]);
		echo $this->Form->control('name', ['required' => 1]);
		echo $this->Form->control('ori_name');
		echo $this->Form->control('code');
	?>
	</fieldset>
<?php echo $this->Form->submit(__d('data', 'Submit')); echo $this->Form->end();?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'States')), ['action' => 'index']);?></li>
		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'Countries')), ['controller' => 'Countries', 'action' => 'index']); ?> </li>
	</ul>
</div>
