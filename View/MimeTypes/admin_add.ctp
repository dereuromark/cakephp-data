<?php $this->Html->script('jquery/plugins/jquery.dd.js', false);?>
<script type="text/javascript">
	var imagePath = baseurl + 'img/<?php echo IMG_MIMETYPES?>';
</script>
<?php echo $this->Html->script('specific/mime_types_images.js');?>

<div class="page form">
<?php echo $this->Form->create('MimeType');?>
	<fieldset>
		<legend><?php echo __('Add Mime Type');?></legend>
	<?php
		foreach ($mimeTypeImages as $key => $image) {
			//$mimeTypeImages[$key] = 's'.$this->Html->image(IMG_MIMETYPES.$image).' '.$image;
		}

		echo $this->Form->input('ext', array('after' => ' Z.B. \'exe\' für *.exe Dateien'));
		echo $this->Form->input('name', array('label' => 'Programm/Name', 'after' => ' Bezeichnung'));

		echo $this->Form->input('type', array('label' => 'Mime-Type'));
		echo $this->Form->input('alt_type', array('label' => 'Alternative'));

		echo $this->Form->input('mime_type_image_id', array('empty' => ' - [ n/a ] - ', 'class' => 'customselect', 'style' => 'width:300px'));

		echo $this->Form->input('active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Mime Types'), array('action' => 'index'));?></li>
	</ul>
</div>