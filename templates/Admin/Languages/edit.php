<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Language $language
 */
?>
<h2><?php echo __d('data', 'Edit {0}', __d('data', 'Language')); ?></h2>

<div class="page form">
<?php echo $this->Form->create($language);?>
	<fieldset>
		<legend><?php echo __d('data', 'Edit {0}', __d('data', 'Language')); ?></legend>
	<?php
		//echo $this->Form->control('id');
		echo $this->Form->control('name');
		echo $this->Form->control('ori_name');
		echo $this->Form->control('code');
		echo $this->Form->control('locale');
		echo $this->Form->control('locale_fallback');
		echo $this->Form->control('direction', ['options' => $language::directions()]);
		echo $this->Form->control('status');
	?>
	</fieldset>
<?php echo $this->Form->submit(__d('data', 'Submit')); echo $this->Form->end();?>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Form->postButton(__d('data', 'Delete'), ['action' => 'delete', $language->id], [
			'class' => 'btn btn-link p-0 align-baseline',
			'form' => [
				'class' => 'd-inline',
				'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $language->id),
			],
		]); ?></li>
		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'Languages')), ['action' => 'index']);?></li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
