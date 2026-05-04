<?php
/**
 * @var \App\View\AppView $this
 * @var array $countries
 */
?>
<?php /**
 * @var \App\View\AppView $this
 */
echo $this->Form->create(null, ['valueSources' => 'query']); ?>
<?php echo __d('data', 'Country');?>:&nbsp;&nbsp;
<?php echo $this->Form->control('country_id', [
	'class' => 'filter',
	'label' => false,
	'div' => false,
	'type' => 'select',
	'empty' => ['' => '- [ ' . __d('data', 'noRestriction') . ' ] -'],
	'options' => $countries]
); ?>
<?php echo $this->Form->control('search', ['placeholder' => __d('data', 'wildcardSearch {0} and {1}', '*', '?')]); ?>

<?php echo $this->Form->button(__d('data', 'Search'), ['div' => false]); ?>
<?php if ($this->Search->isSearch()) {
	echo $this->Search->resetLink(null, ['class' => 'btn btn-secondary']);
} ?>
<?php echo $this->Form->end(); ?>
