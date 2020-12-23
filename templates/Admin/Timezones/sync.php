<?php
/**
 * @var \App\View\AppView $this
 * @var array $diff
 * @var \Data\Model\Entity\Timezone[] $storedTimezones
 */

?>
<div class="page form">
<h2>Sync Timezones</h2>
	<p><?php echo count($storedTimezones) ?> timezones currently stored.</p>

	<?php echo $this->Form->create(); ?>
	<fieldset>
		<legend><?php echo __('Sync Timezones');?></legend>

		<?php
		foreach ($diff as $action => $rows) {
			echo '<fieldset>';
			echo '<legend>' . h($action) . '</legend>';

			foreach ($rows as $key => $row) {
				if (!empty($row['fields'])) {
					echo json_encode($row['fields']);
				}
				echo $this->Form->control('Form.' . $action . '.' . $key . '.execute', ['default' => true, 'type' => 'checkbox', 'label' => $row['label']]);
			}

			echo '</fieldset>';
		}
	?>
	</fieldset>
	<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>

</div>
