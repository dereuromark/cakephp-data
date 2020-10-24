<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\City $city
 */

use Cake\Core\Configure;

?>
<div class="page form">
<h2><?php echo __('Add {0}', __('City')); ?></h2>

<?php echo $this->Form->create($city);?>
	<fieldset>
		<legend><?php echo __('Add {0}', __('City')); ?></legend>
	<?php
		echo $this->Form->control('country_id');
		echo $this->Form->control('official_key', ['type' => 'text']);

		if (Configure::read('Data.City.County') !== false) {
			echo $this->Form->control('county_id');
		}

		echo $this->Form->control('name');

		echo $this->Form->control('postal_code');
		echo $this->Form->control('postal_code_unique');

		echo $this->Form->control('citizens');
		echo $this->Form->control('description');
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
</div>

<div class="actions">
	<ul>

		<li><?php echo $this->Html->link(__('List {0}', __('Cities')), ['action' => 'index']);?></li>
	</ul>
</div>
