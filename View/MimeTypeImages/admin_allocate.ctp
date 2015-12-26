<div class="page form">
<?php echo $this->Form->create('MimeTypeImage');?>
	<fieldset>
		<legend><?php echo __('Add Mime Type Image');?></legend>
	<?php
		if (!empty($images)) {
			//echo $this->Form->input('images', array('type'=>'select','multiple'=>'checkbox','options'=>$images,'label'=>false));
			foreach ($images as $id => $image) {
				echo $this->Form->input('MimeTypeImage.imgs.' . $id, ['type' => 'checkbox', 'label' => false, 'div' => false]);

				echo ' ';
				$imageName = extractPathInfo('file', $image);
				$imageName = mb_strtolower(Sanitize::paranoid($imageName));

				echo $this->Form->input('MimeTypeImage.names.' . $id, ['value' => $imageName, 'after' => '', 'div' => false, 'label' => false]);
				echo $this->Form->input('MimeTypeImage.filenames.' . $id, ['value' => $image, 'type' => 'hidden']);
				echo ' ';
				echo $this->Html->image(IMG_MIMETYPES . 'import/' . $image, ['title' => $image]);
				echo ' ' . $image;

				echo BR;
			}

		} else {
			echo '- [ keine Dateien zum Importieren gefunden ] -';
		}
	?>

	</fieldset>
<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Mime Type Images'), ['action' => 'index']);?></li>
	</ul>
</div>
