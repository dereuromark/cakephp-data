<div class="page form">
<h2><?php echo __('Edit %s', __('City')); ?></h2>

<?php echo $this->Form->create('City');?>
	<fieldset>
		<legend><?php echo __('Edit %s', __('City')); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('country_id');
		echo $this->Form->input('official_id', array('type' => 'text'));

		if (Configure::read('City.County') !== false) {
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('City.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('City.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List %s', __('Cities')), array('action' => 'index'));?></li>
	</ul>
</div>