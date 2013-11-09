<div class="page form">
<h2><?php echo __('Query %s', __('Geo Data')); ?></h2>

<?php echo $this->Form->create('PostalCode');?>
	<fieldset>
		<legend><?php echo __('Enter Postal Code, City, Address or other Geo Data'); ?></legend>
	<?php
		echo $this->Form->input('address');
		echo $this->Form->input('allow_inconclusive', array('type' => 'checkbox'));
		echo $this->Form->input('min_accuracy', array());
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<div>
<?php if ($results) { ?>
<?php
	echo pre($results);
?>
<?php } ?>
</div>


<div class="actions">
	<ul>

		<li><?php echo $this->Html->link(__('List %s', __('Postal Codes')), array('action' => 'index'));?></li>
	</ul>
</div>