<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $manualRes
 * @var mixed $mimeTypes
 * @var array $report
 * @var \Data\Model\Entity\MimeType $mimeType
 */
?>
<h2>Import MimeTypes from File etc</h2>

<?php if (isset($mimeTypes)) { ?>

The imported data has <b><?php echo count($mimeTypes)?> MimeTypes</b> listed<br/><br/>

<?php echo count($report['success'])?> wurden neu hingefügt, <?php echo count($report['in'])?> sind schon enthalten (<?php echo count($manualRes)?> davon bedürfen einer manuellen Klärung) sowie <?php echo count($report['error'])?> Fehler.

<div class="page form">
<?php echo $this->Form->create($mimeType);?>
	<fieldset>
		<legend><?php echo __d('data', 'Add Mime Type');?></legend>
	<?php
		pr($report);
	?>
	</fieldset>
<?php echo $this->Form->submit(__d('data', 'Submit')); echo $this->Form->end();?>
</div>

<?php } ?>


<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('data', 'List Mime Types'), ['action' => 'index']);?></li>
	</ul>
</div>
