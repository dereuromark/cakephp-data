<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Address $address
 */

use Cake\Core\Configure;

?>
<h2><?php echo __('Add {0}', __('Address')); ?></h2>

<div class="page form">
<?php echo $this->Form->create($address);?>
	<fieldset>
		<legend><?php echo __('Add {0}', __('Address')); ?></legend>
	<?php
		echo $this->Form->control('country_id', ['empty' => [0 => ' - [ ' . __('noSelection') . ' ] - ']]);
	if (Configure::read('Data.Address.State')) {
		echo $this->Form->control('country_province_id', ['empty' => [0 => ' - [ ' . __('noSelection') . ' ] - ']]);
	}
		echo $this->Form->control('first_name');
		echo $this->Form->control('last_name');
		echo $this->Form->control('street');
		echo $this->Form->control('postal_code');
		echo $this->Form->control('city');
	?>
	</fieldset>
	<fieldset>
		<legend><?php echo __('Relations'); ?></legend>
	<?php
		echo $this->Form->control('model');
		echo $this->Form->control('foreign_id', ['type' => 'text', 'empty' => [0 => ' - [ ' . __('noSelection') . ' ] - ']]);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List {0}', __('Addresses')), ['action' => 'index']);?></li>
	</ul>
</div>
