<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page form">
<h2><?php echo __('Edit {0}', __('Postal Code')); ?></h2>

<?php echo $this->Form->create($postalCode);?>
	<fieldset>
		<legend><?php echo __('Edit {0}', __('Postal Code')); ?></legend>
	<?php
		//echo $this->Form->control('id');
		echo $this->Form->control('code');
		echo $this->Form->control('country_id');
		echo $this->Form->control('lat');
		echo $this->Form->control('lng');
		echo $this->Form->control('official_address');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<div class="actions">
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $this->Form->getSourceValue('PostalCode.id')], null, __('Are you sure you want to delete # {0}?', $this->Form->getSourceValue('PostalCode.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Postal Codes')), ['action' => 'index']);?></li>
	</ul>
</div>
