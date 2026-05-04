<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\City $city
 */

use Cake\Core\Configure;

?>
<div class="page form">
<h2><?php echo __d('data', 'Add {0}', __d('data', 'City')); ?></h2>

<?php echo $this->Form->create($city);?>
	<fieldset>
		<legend><?php echo __d('data', 'Add {0}', __d('data', 'City')); ?></legend>
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
<?php echo $this->Form->submit(__d('data', 'Submit')); echo $this->Form->end();?>
</div>

<div class="actions">
	<ul>

		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'Cities')), ['action' => 'index']);?></li>
	</ul>
</div>
