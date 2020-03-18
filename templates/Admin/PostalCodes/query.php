<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $results
 */
?>
<div class="page form">
<h2><?php echo __('Query {0}', __('Geo Data')); ?></h2>

<?php echo $this->Form->create($postalCode);?>
	<fieldset>
		<legend><?php echo __('Enter Postal Code, City, Address or other Geo Data'); ?></legend>
	<?php
		echo $this->Form->control('address');
		echo $this->Form->control('allow_inconclusive', ['type' => 'checkbox']);
		echo $this->Form->control('min_accuracy', []);
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

		<li><?php echo $this->Html->link(__('List {0}', __('Postal Codes')), ['action' => 'index']);?></li>
	</ul>
</div>
