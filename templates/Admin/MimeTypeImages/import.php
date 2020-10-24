<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $alreadyIn
 * @var mixed $fileExtensions
 * @var \Data\Model\Entity\MimeTypeImage $mimeTypeImage
 */
?>
<div class="page form">
<?php echo $this->Form->create($mimeTypeImage);?>

<?php if (!empty($alreadyIn) || !empty($fileExtensions)) { ?>
	<fieldset>
		<legend><?php echo __('Confirm and Save');?></legend>
	<?php echo count($alreadyIn)?> bereits vorhanden: <ul style="margin-left:160px"><?php echo implode(',', $alreadyIn)?>
	<?php if (empty($alreadyIn)) { ?>
		- - -
	 <?php } ?></ul>
	 <br/>

		<?php echo count($fileExtensions)?> neue:
	<?php
		if (!empty($fileExtensions)) {
			echo $this->Form->control('extensions', ['type' => 'select', 'multiple' => 'checkbox', 'options' => $fileExtensions, 'label' => false]);
		} else {
			echo '- - -';
		}
	?>

	</fieldset>

<br/>

<?php } ?>

	<fieldset>
		<legend><?php echo __('Add {0}', __('Extensions'));?></legend>
	<?php
		echo $this->Form->control('import', ['type' => 'textarea']);
	?>
	Eine mit Komma, Leerzeichen, NewLine, etc. separierte Liste, die nur Endungen (exe, jpg, ...) oder Dateien (1.jpg, 2.gif) enthält, deren Endungen dann importiert werden.
	</fieldset>
<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Mime Type Images'), ['action' => 'index']);?></li>
	</ul>
</div>
