<div class="page form">
<?php echo $this->Form->create('MimeTypeImage', array('url' => '/' . $this->request->url));?>
	<fieldset>
		<legend><?php echo __('Add Mime Type Image');?></legend>
	<?php
		if (!empty($images)) {
			//echo $this->Form->input('images', array('type'=>'select','multiple'=>'checkbox','options'=>$images,'label'=>false));
			foreach ($images as $id => $image) {
				echo $this->Form->input('MimeTypeImage.imgs.' . $id, array('type' => 'checkbox', 'label' => false, 'div' => false));

				echo ' ';
				$imageName = extractPathInfo('file', $image);
				$imageName = mb_strtolower(Sanitize::paranoid($imageName));

				echo $this->Form->input('MimeTypeImage.names.' . $id, array('value' => $imageName, 'after' => '', 'div' => false, 'label' => false));
				echo $this->Form->input('MimeTypeImage.filenames.' . $id, array('value' => $image, 'type' => 'hidden'));
				echo ' ';
				echo $this->Html->image(IMG_MIMETYPES . 'import/' . $image, array('title' => $image));
				echo ' ' . $image;



				echo BR;
			}

		} else {
			echo '- [ keine Dateien zum Importieren gefunden ] -';
		}
	?>

	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Mime Type Images'), array('action' => 'index'));?></li>
	</ul>
</div>