<div class="page index">
<h2><?php echo __('Mime Type Detection');?></h2>
<?php
foreach ($extensions as $extension) {
	echo 'test.' . $extension . ', ';
}
?>

<br /><br />

<div class="MimeTypes">
<?php echo $this->Form->create('MimeType', array('type' => 'file', 'action' => 'detectByExtension'));?>

	<fieldset>
		<legend><?php echo __('Test');?></legend>
	<?php
		echo $this->Form->input('file', array('type' => 'file'));
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>

</div>