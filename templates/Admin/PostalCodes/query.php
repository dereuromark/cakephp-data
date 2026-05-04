<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $results
 * @var \Data\Model\Entity\PostalCode $postalCode
 */
?>
<div class="page form">
<h2><?php echo __d('data', 'Query {0}', __d('data', 'Geo Data')); ?></h2>

<?php echo $this->Form->create($postalCode);?>
	<fieldset>
		<legend><?php echo __d('data', 'Enter Postal Code, City, Address or other Geo Data'); ?></legend>
	<?php
		echo $this->Form->control('address');
		echo $this->Form->control('allow_inconclusive', ['type' => 'checkbox']);
		echo $this->Form->control('min_accuracy', []);
	?>
	</fieldset>
<?php echo $this->Form->submit(__d('data', 'Submit')); echo $this->Form->end();?>
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

		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'Postal Codes')), ['action' => 'index']);?></li>
	</ul>
</div>
