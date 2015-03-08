<h2><?php echo __('Edit %s', __('Continent')); ?></h2>

<div class="page form">
<?php echo $this->Form->create('Continent');?>
	<fieldset>
		<legend><?php echo __('Edit %s', __('Continent')); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		//echo $this->Form->input('ori_name');
		echo $this->Form->input('parent_id', ['empty' => ' - [ ' . __('pleaseSelect') . ' ] - ']);
		//echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $this->Form->value('Continent.id')], null, __('Are you sure you want to delete # %s?', $this->Form->value('Continent.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List %s', __('Continents')), ['action' => 'index']);?></li>
		<li><?php echo $this->Html->link(__('List %s', __('Continents')), ['controller' => 'continents', 'action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Countries')), ['controller' => 'countries', 'action' => 'index']); ?> </li>
	</ul>
</div>