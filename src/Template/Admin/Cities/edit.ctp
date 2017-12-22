<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page form">
<h2><?php echo __('Edit {0}', __('City')); ?></h2>

<?php echo $this->Form->create('City');?>
	<fieldset>
		<legend><?php echo __('Edit {0}', __('City')); ?></legend>
	<?php
		//echo $this->Form->input('id');
		echo $this->Form->input('country_id');
		echo $this->Form->input('official_id', ['type' => 'text']);

		if (Configure::read('Data.City.County') !== false) {
			echo $this->Form->input('county_id');
		}

		echo $this->Form->input('name');

		echo $this->Form->input('postal_code');
		echo $this->Form->input('postal_code_unique');

		echo $this->Form->input('citizens');
		echo $this->Form->input('description');

	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<div class="actions">
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $this->Form->getSourceValue('City.id')], null, __('Are you sure you want to delete # {0}?', $this->Form->getSourceValue('City.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Cities')), ['action' => 'index']);?></li>
	</ul>
</div>
