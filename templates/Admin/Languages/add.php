<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Language $language
 */
?>
<h2><?php echo __('Add {0}', __('Language')); ?></h2>

<div class="page form">
<?php echo $this->Form->create($language);?>
	<fieldset>
		<legend><?php echo __('Add {0}', __('Language')); ?></legend>
	<?php
		echo $this->Form->control('name');
		echo $this->Form->control('ori_name');
		echo $this->Form->control('code');
		echo $this->Form->control('locale');
		echo $this->Form->control('locale_fallback');
		echo $this->Form->control('direction', ['options' => $language::directions()]);
		//echo $this->Form->control('status');
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit')); $this->Form->end();?>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List {0}', __('Languages')), ['action' => 'index']);?></li>
	</ul>
</div>
