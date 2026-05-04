<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\MimeType $mimeType
 */
$cspNonce = (string)$this->getRequest()->getAttribute('cspNonce', '');
?>
<?php /**
 * @var \App\View\AppView $this
 */
$this->Html->script('jquery/plugins/jquery.dd.js');?>
<script type="text/javascript"<?= $cspNonce !== '' ? ' nonce="' . h($cspNonce) . '"' : '' ?>>
	var imagePath = baseurl + 'img/<?php echo IMG_MIMETYPES?>';
</script>
<?php echo $this->Html->script('specific/mime_types_images.js');?>


<div class="page form">
<?php echo $this->Form->create($mimeType);?>
	<fieldset>
		<legend><?php echo __d('data', 'Edit Mime Type');?></legend>
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
<?php echo $this->Form->submit(__d('data', 'Submit')); echo $this->Form->end();?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Form->postButton(__d('data', 'Delete'), ['action' => 'delete', $this->Form->getSourceValue('MimeType.id')], [
			'class' => 'btn btn-link p-0 align-baseline',
			'form' => [
				'class' => 'd-inline',
				'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $this->Form->getSourceValue('MimeType.id')),
			],
		]); ?></li>
		<li><?php echo $this->Html->link(__d('data', 'List Mime Types'), ['action' => 'index']);?></li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
