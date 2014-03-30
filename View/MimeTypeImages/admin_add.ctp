<div class="page form">
<?php echo $this->Form->create('MimeTypeImage', array('type' => 'file'));?>
	<fieldset>
		<legend><?php echo __('Add Mime Type Image');?></legend>
	<?php
		echo $this->Form->input('name');
		echo BR;

		echo $this->Form->input('file', array('type' => 'file', 'after' => ' Wird automatisch auf 16px Höhe verkleinert'));
		echo $this->Form->input('image', array('type' => 'select', 'options' => $availableImages, 'empty' => '- [ n/a ] -'));
		echo $this->Form->input('ext', array('options' => MimeTypeImage::extensions(), 'empty' => '- [ n/a ] -'));

		echo BR;
		echo $this->Form->input('active');
		echo $this->Form->input('details', array('type' => 'textarea'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Mime Type Images'), array('action' => 'index'));?></li>
	</ul>
</div>