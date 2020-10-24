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
		<legend><?php echo __('Add Mime Type Image');?></legend>
	<?php
		echo $this->Form->control('name');
		echo '<br/>';

		echo $this->Form->control('file', ['type' => 'file', 'after' => ' Wird automatisch auf 16px Höhe verkleinert']);
		echo $this->Form->control('image', ['type' => 'select', 'options' => $availableImages, 'empty' => '- [ n/a ] -']);
		echo $this->Form->control('ext', ['options' => \Data\Model\Table\MimeTypeImagesTable::extensions(), 'empty' => '- [ n/a ] -']);

		echo '<br/>';
		echo $this->Form->control('active');
		echo $this->Form->control('details', ['type' => 'textarea']);
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Mime Type Images'), ['action' => 'index']);?></li>
	</ul>
</div>
