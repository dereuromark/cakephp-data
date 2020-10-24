<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\MimeType $mimeType
 */
?>
<?php /**
 * @var \App\View\AppView $this
 */
$this->Html->script('jquery/plugins/jquery.dd.js');?>
<script type="text/javascript">
	var imagePath = baseurl + 'img/<?php echo IMG_MIMETYPES?>';
</script>
<?php echo $this->Html->script('specific/mime_types_images.js');?>


<div class="page form">
<?php echo $this->Form->create($mimeType);?>
	<fieldset>
		<legend><?php echo __('Edit Mime Type');?></legend>
	<?php
		//echo $this->Form->control('id');

		echo $this->Form->control('ext', ['after' => ' Z.B. \'exe\' für *.exe Dateien']);
		echo $this->Form->control('name', ['label' => 'Programm/Name', 'after' => ' Bezeichnung']);

		echo $this->Form->control('type', ['label' => 'Mime-Type']);
		echo $this->Form->control('alt_type', ['label' => 'Alternative']);

		echo $this->Form->control('mime_type_image_id', ['empty' => ' - [ n/a ] - ', 'class' => 'customselect', 'style' => 'width:300px']);

		echo $this->Form->control('active');
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $this->Form->getSourceValue('MimeType.id')], ['confirm' => __('Are you sure you want to delete # {0}?', $this->Form->getSourceValue('MimeType.id'))]); ?></li>
		<li><?php echo $this->Html->link(__('List Mime Types'), ['action' => 'index']);?></li>
	</ul>
</div>
