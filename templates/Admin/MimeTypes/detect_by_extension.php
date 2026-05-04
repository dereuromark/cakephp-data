<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $extensions
 * @var \Data\Model\Entity\MimeType $mimeType
 */
?>
<div class="page index">
<h2><?php echo __d('data', 'Mime Type Detection');?></h2>
<?php
foreach ($extensions as $extension) {
	echo 'test.' . $extension . ', ';
}
?>

<br/><br/>

<div class="MimeTypes">
<?php echo $this->Form->create($mimeType, ['type' => 'file']);?>

	<fieldset>
		<legend><?php echo __d('data', 'Test');?></legend>
	<?php
		echo $this->Form->control('file', ['type' => 'file']);
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>

</div>
