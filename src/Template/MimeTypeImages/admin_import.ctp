<div class="page form">
<?php echo $this->Form->create('MimeTypeImage', array('url' => '/' . $this->request->url));?>

<?php if (!empty($alreadyIn) || !empty($fileExtensions)) { ?>
	<fieldset>
		<legend><?php echo __('Confirm and Save');?></legend>
	<?php echo count($alreadyIn)?> bereits vorhanden: <ul style="margin-left:160px"><?php echo implode(',', $alreadyIn)?>
	<?php if (empty($alreadyIn)) { ?>
		- - -
	 <?php } ?></ul>
	 <br />

		<?php echo count($fileExtensions)?> neue:
	<?php
		if (!empty($fileExtensions)) {
			echo $this->Form->input('extensions', array('type' => 'select', 'multiple' => 'checkbox', 'options' => $fileExtensions, 'label' => false));
		} else {
			echo '- - -';
		}
	?>

	</fieldset>

<br />

<?php } ?>

	<fieldset>
		<legend><?php echo __('Add %s', __('Extensions'));?></legend>
	<?php
		echo $this->Form->input('import', array('type' => 'textarea'));
	?>
	Eine mit Komma, Leerzeichen, NewLine, etc. separierte Liste, die nur Endungen (exe, jpg, ...) oder Dateien (1.jpg, 2.gif) enthält, deren Endungen dann importiert werden.
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Mime Type Images'), array('action' => 'index'));?></li>
	</ul>
</div>