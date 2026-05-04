<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Country $country
 */

use Cake\Core\Configure;

?>
<div class="page form">
<?php echo $this->Form->create($country);?>
	<fieldset>
		<legend><?php echo __d('data', 'Edit {0}', __d('data', 'Country'));?></legend>
	<?php
		echo $this->Form->control('name');
		echo $this->Form->control('ori_name');
		echo $this->Form->control('iso2');
		echo $this->Form->control('iso3');
		echo $this->Form->control('phone_code');
		echo $this->Form->control('timezone');

		if (Configure::read('Data.City.Continent') !== false) {
			echo $this->Form->control('continent_id');
		}

		echo $this->Form->control('special');
		echo $this->Form->control('address_format', ['type' => 'textarea']);
		echo '<div class="input checkbox">Placeholders are :name :street_address :postcode :city :country</div>';
		echo '<br/>';

		//echo $this->Form->control('sort');
		echo $this->Form->control('status', ['type' => 'checkbox', 'label' => 'Aktiv']);
	?>
	</fieldset>
<?php echo $this->Form->submit(__d('data', 'Submit')); echo $this->Form->end();?>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Form->postButton(__d('data', 'Delete'), ['action' => 'delete', $country->id], [
			'escapeTitle' => false,
			'class' => 'btn btn-link p-0 align-baseline',
			'form' => [
				'class' => 'd-inline',
				'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $country->id),
			],
		]); ?></li>
		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'Countries')), ['action' => 'index']);?></li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
