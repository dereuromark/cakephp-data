<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $availableImages
 * @var \Data\Model\Entity\MimeTypeImage $mimeTypeImage
 */
?>
<div class="page form">
<?php echo $this->Form->create($mimeTypeImage, ['type' => 'file']);?>
	<fieldset>
		<legend><?php echo __('Edit Mime Type Image');?></legend>
	<?php
		//echo $this->Form->control('id');
		echo $this->Form->control('name');
		echo '<br/>';

		echo $this->Form->control('file', ['type' => 'file', 'after' => ' Wird automatisch auf 16px Höhe verkleinert']);
		echo $this->Form->control('image', ['type' => 'select', 'options' => $availableImages, 'empty' => '- [ n/a ] -']);
		echo $this->Form->control('ext', ['options' => \Data\Model\Table\MimeTypeImagesTable::extensions(), 'empty' => '- [ nicht konvertieren ] -', 'label' => 'Konvertieren zu']);

		echo '<br/>';
		echo $this->Form->control('active');
		echo $this->Form->control('details', ['type' => 'textarea']);
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $this->Form->getSourceValue('MimeTypeImage.id')], ['confirm' => __('Are you sure you want to delete # {0}?', $this->Form->getSourceValue('MimeTypeImage.id'))]); ?></li>
		<li><?php echo $this->Html->link(__('List Mime Type Images'), ['action' => 'index']);?></li>
	</ul>
</div>
