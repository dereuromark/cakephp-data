<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Timezone[] $todo
 * @var \Data\Model\Entity\Timezone[] $storedTimezones
 */

?>
<div class="page form">
<h2>Link Timezones</h2>
	<p><?php echo count($storedTimezones) ?> timezones currently stored.</p>

	<?php echo $this->Form->create(); ?>
	<fieldset>
		<legend><?php echo __d('data', 'Link Timezones');?></legend>

		<?php
		foreach ($todo as $key => $timezone) {
			echo '<fieldset>';
			echo '<legend>' . h($timezone->name) . '</legend>';

			$label = 'Link to ' . h($timezone->canonical_timezone->name);
			echo $this->Form->control('Form.link.' . $key . '.execute', ['default' => true, 'type' => 'checkbox', 'label' => $label]);

			echo '</fieldset>';
		}
	?>
	</fieldset>
	<?php echo $this->Form->submit(__d('data', 'Submit')); echo $this->Form->end();?>

</div>
