<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Continent $continent
 */
?>
<h2><?php echo __d('data', 'Add {0}', __d('data', 'Continent')); ?></h2>

<div class="page form">
<?php echo $this->Form->create($continent);?>
	<fieldset>
		<legend><?php echo __d('data', 'Add {0}', __d('data', 'Continent')); ?></legend>
	<?php
		echo $this->Form->control('name');
		//echo $this->Form->control('ori_name');

		echo $this->Form->control('code');

		echo $this->Form->control('parent_id', []);
		//echo $this->Form->control('status');
	?>
	</fieldset>
<?php echo $this->Form->submit(__d('data', 'Submit')); echo $this->Form->end();?>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'Continents')), ['action' => 'index']);?></li>
	</ul>
</div>
