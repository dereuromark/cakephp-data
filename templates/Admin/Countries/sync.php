<?php
/**
 * @var \App\View\AppView $this
 * @var array $diff
 * @var \Data\Model\Entity\Country[] $storedCountries
 */

?>
<div class="page form">
<h2>Sync Countries</h2>
	<p><?php echo count($storedCountries) ?> countries currently stored.</p>

	<?php echo $this->Form->create(); ?>
	<fieldset>
		<legend><?php echo __('Sync Countries');?></legend>

		<?php
		foreach ($diff as $action => $rows) {
			echo '<fieldset>';
			echo '<legend>' . h($action) . '</legend>';

			foreach ($rows as $key => $row) {
				if (!empty($row['fields'])) {
					echo json_encode($row['fields']);
				}

				$label = $row['label'];
				if (!empty($row['entity'])) {
					$label .= ' (' . $row['entity']->iso3 . ')';
				} elseif (!empty($row['data']['iso3'])) {
					$label .= ' (' . $row['data']['iso3'] . ')';
				}
				echo $this->Form->control('Form.' . $action . '.' . $key . '.execute', ['default' => true, 'type' => 'checkbox', 'label' => $label]);
			}

			echo '</fieldset>';
		}
	?>
	</fieldset>
	<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>

</div>
