<?php echo $this->Form->create(); ?>
<?php echo __('Country');?>:&nbsp;&nbsp;
<?php echo $this->Form->input('country_id', [
	'class' => 'filter',
	'label' => false,
	'div' => false,
	'type' => 'select',
	'empty' => ['' => '- [ ' . __('noRestriction') . ' ] -'],
	'options' => $countries]);?>

<?php echo $this->Form->submit(__('Filter'), ['div' => false]); ?>
<?php echo $this->Form->end(); ?>
