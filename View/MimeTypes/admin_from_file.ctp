<h2>Import MimeTypes from File etc</h2>

<?php if (isset($mimeTypes)) { ?>

The imported data has <b><?php echo count($mimeTypes)?> MimeTypes</b> listed<br /><br />

<?php echo count($report['success'])?> wurden neu hingefügt, <?php echo count($report['in'])?> sind schon enthalten (<?php echo count($manualRes)?> davon bedürfen einer manuellen Klärung) sowie <?php echo count($report['error'])?> Fehler.

<div class="page form">
<?php echo $this->Form->create('MimeType');?>
	<fieldset>
		<legend><?php echo __('Add Mime Type');?></legend>
	<?php
		pr($report);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<?php } ?>


<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Mime Types'), array('action' => 'index'));?></li>
	</ul>
</div>