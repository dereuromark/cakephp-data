<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $images
 * @var \Data\Model\Entity\MimeTypeImage $mimeTypeImage
 */
?>
<div class="page form">
<?php echo $this->Form->create($mimeTypeImage);?>
	<fieldset>
		<legend><?php echo __('Add Mime Type Image');?></legend>
	<?php
		if (!empty($images)) {
			//echo $this->Form->control('images', array('type'=>'select','multiple'=>'checkbox','options'=>$images,'label'=>false));
			foreach ($images as $id => $image) {
				echo $this->Form->control('MimeTypeImage.imgs.' . $id, ['type' => 'checkbox', 'label' => false, 'div' => false]);

				echo ' ';
				$imageName = pathinfo($image, PATHINFO_FILENAME);
				$imageName = mb_strtolower($imageName);

				echo $this->Form->control('MimeTypeImage.names.' . $id, ['value' => $imageName, 'after' => '', 'div' => false, 'label' => false]);
				echo $this->Form->control('MimeTypeImage.filenames.' . $id, ['value' => $image, 'type' => 'hidden']);
				echo ' ';
				echo $this->Html->image(IMG_MIMETYPES . 'import/' . $image, ['title' => $image]);
				echo ' ' . $image;



				echo '<br />';
			}

		} else {
			echo '- [ keine Dateien zum Importieren gefunden ] -';
		}
	?>

	</fieldset>
<?php echo $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end();?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Mime Type Images'), ['action' => 'index']);?></li>
	</ul>
</div>
