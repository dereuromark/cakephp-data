<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page form">
<?php echo $this->Form->create('MimeTypeImage', ['type' => 'file']);?>
	<fieldset>
		<legend><?php echo __('Add Mime Type Image');?></legend>
	<?php
		echo $this->Form->input('name');
		echo '<br/>';

		echo $this->Form->input('file', ['type' => 'file', 'after' => ' Wird automatisch auf 16px Höhe verkleinert']);
		echo $this->Form->input('image', ['type' => 'select', 'options' => $availableImages, 'empty' => '- [ n/a ] -']);
		echo $this->Form->input('ext', ['options' => \Data\Model\Table\MimeTypeImagesTable::extensions(), 'empty' => '- [ n/a ] -']);

		echo '<br/>';
		echo $this->Form->input('active');
		echo $this->Form->input('details', ['type' => 'textarea']);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Mime Type Images'), ['action' => 'index']);?></li>
	</ul>
</div>
