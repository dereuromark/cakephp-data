<?php
/**
 * @var \App\View\AppView $this
 * @var array $countries
 */
?>
<?php /**
 * @var \App\View\AppView $this
 */
echo $this->Form->create(); ?>
<?php echo __('Country');?>:&nbsp;&nbsp;
<?php echo $this->Form->control('country_id', [
	'class' => 'filter',
	'label' => false,
	'div' => false,
	'type' => 'select',
	'empty' => ['' => '- [ ' . __('noRestriction') . ' ] -'],
	'options' => $countries]
); ?>
<?php echo $this->Form->control('search', ['placeholder' => __('wildcardSearch {0} and {1}', '*', '?')]); ?>

<?php echo $this->Form->button(__('Search'), ['div' => false]); ?>
<?php if ($this->Search->isSearch()) {
	echo $this->Search->resetLink(null, ['class' => 'btn btn-secondary']);
} ?>
<?php echo $this->Form->end(); ?>
