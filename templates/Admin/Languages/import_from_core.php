<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2><?php echo __('Import {0}', __('Languages')); ?></h2>

<div class="page form">
<?php echo $this->Form->create('Language');?>
	<fieldset>
		<legend><?php echo __('Add {0}', __('Language')); ?></legend>
	<?php
		//echo $this->Form->control('name');
		//echo $this->Form->control('ori_name');
		//echo $this->Form->control('code');

		//echo $this->Form->control('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List {0}', __('Languages')), ['action' => 'index']);?></li>
	</ul>
</div>
