<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\PostalCode $postalCode
 */
?>
<div class="page form">
<h2><?php echo __d('data', 'Add {0}', __d('data', 'Postal Code')); ?></h2>

<?php echo $this->Form->create($postalCode);?>
	<fieldset>
		<legend><?php echo __d('data', 'Add {0}', __d('data', 'Postal Code')); ?></legend>
	<?php
		echo $this->Form->control('code');
		echo $this->Form->control('country_id');
		echo $this->Form->control('lat');
		echo $this->Form->control('lng');
		echo $this->Form->control('official_address');
	?>
	</fieldset>
<?php echo $this->Form->submit(__d('data', 'Submit')); echo $this->Form->end();?>
</div>

<div class="actions">
	<ul>

		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'Postal Codes')), ['action' => 'index']);?></li>
	</ul>
</div>
