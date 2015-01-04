<div class="page form">
<h2><?php echo __('Add %s', __('Postal Code')); ?></h2>

<?php echo $this->Form->create('PostalCode');?>
	<fieldset>
		<legend><?php echo __('Add %s', __('Postal Code')); ?></legend>
	<?php
		echo $this->Form->input('code');
		echo $this->Form->input('country_id');
		echo $this->Form->input('lat');
		echo $this->Form->input('lng');
		echo $this->Form->input('official_address');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<div class="actions">
	<ul>

		<li><?php echo $this->Html->link(__('List %s', __('Postal Codes')), array('action' => 'index'));?></li>
	</ul>
</div>