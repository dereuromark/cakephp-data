<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page form">
<h2>Schnell-Import von Ländern</h2>

<?php
	if (!empty($this->request->data['Form'])) { ?>
	<h3>Speichern</h3>
	<?php echo $this->Form->create('Country');?>
	<fieldset>
		<legend><?php echo __('Import Countries');?></legend>

		<?php if (!empty($countries)) { ?>
		<div class="">
		<?php echo pre(h($countries)); ?>
		</div>
		<?php } ?>

	<?php

		foreach ($this->request->data['Form'] as $key => $val) {
			echo $this->Form->control('Form.' . $key . '.name', ['value' => $val['name']]);
			echo $this->Form->control('Form.' . $key . '.iso2', ['value' => $val['iso2']]);
			echo $this->Form->control('Form.' . $key . '.iso3', ['value' => $val['iso3']]);
			echo $this->Form->control('Form.' . $key . '.confirm', ['checked' => $val['confirm'], 'type' => 'checkbox', 'label' => 'Einfügen']);

			//echo $this->Form->error('Error.'.$key.'name', 'First Name Required');
			if (!empty($this->request->data['Error'][$key]['name'])) {
				echo h($this->request->data['Error'][$key]['name']) . BR;

			}
			echo '<br/>';
		}
	?>
	</fieldset>
	<?php echo $this->Form->end(__('Submit'));?>
<?php } ?>


<h3>Import</h3>


<?php if (true) { ?>

<?php echo $this->Form->create('Country');?>
	<fieldset>
		<legend><?php echo __('Import Countries');?></legend>
	<?php
		echo $this->Form->control('import_separator', ['options' => Country::separators(), 'empty' => [0 => 'Eigenen Separator verwenden']]);
		echo $this->Form->control('import_separator_custom', ['label' => 'Eigener Separator']);

		echo $this->Form->control('import_pattern', []);
		echo $this->Form->control('import_record_separator', ['options' => Country::separators(), 'empty' => [0 => 'Eigenen Separator verwenden']]);
		echo $this->Form->control('import_record_separator_custom', ['label' => 'Eigener Separator']);

		echo 'Für Pattern verwendbar: &nbsp;&nbsp; <b>{TAB}</b>, <b>{SPACE}</b>, <b>benutzerdefinierte Trennzeichen</b>, <b>%*s</b> (Überspringen), <b>%s</b> (ohne Leerzeichen), <b>%[^.]s</b> (mit Leerzeichen)<br/>
		Alles, wofür %name zutrifft, verwendet wird, der Rest geht verloren. Was als Separator ausgewählt wurde (zum Trennen der einzelnen Datensätze), kann logischerweise nicht mehr im Pattern verwendet werden (zum Herausfiltern des Namens)!';
		echo '<br/>';
		echo '<br/>';
		echo $this->Form->control('import_content', ['type' => 'textarea', 'rows' => 30]);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>

<?php } else { ?>

<?php echo $this->Html->link('Neuer Import', ['action' => 'import']); ?>

<?php } ?>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List {0}', __('Dances')), ['action' => 'index']);?></li>
	</ul>
</div>
