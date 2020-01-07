<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2><?php echo __('Add {0}', __('Continent')); ?></h2>

<div class="page form">
<?php echo $this->Form->create('Continent');?>
	<fieldset>
		<legend><?php echo __('Add {0}', __('Continent')); ?></legend>
	<?php
		echo $this->Form->control('name');
		//echo $this->Form->control('ori_name');
		echo $this->Form->control('parent_id', ['empty' => ' - [ ' . __('pleaseSelect') . ' ] - ']);
		//echo $this->Form->control('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List {0}', __('Continents')), ['action' => 'index']);?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Continents')), ['controller' => 'continents', 'action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('List {0}', __('Countries')), ['controller' => 'countries', 'action' => 'index']); ?> </li>
	</ul>
</div>
