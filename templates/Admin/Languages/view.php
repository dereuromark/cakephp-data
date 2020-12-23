<?php
/**
 * @var \App\View\AppView $this
 * @var array $language
 */
?>
<div class="page view">
<h2><?php echo __('Language');?></h2>
	<dl>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($language['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ori Name'); ?></dt>
		<dd>
			<?php echo h($language['ori_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($language['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Locale'); ?></dt>
		<dd>
			<?php echo h($language['locale']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Locale Fallback'); ?></dt>
		<dd>
			<?php echo h($language['locale_fallback']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($language['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo $this->Time->niceDate($language['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit {0}', __('Language')), ['action' => 'edit', $language['id']]); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete {0}', __('Language')), ['action' => 'delete', $language['id']], ['confirm' => __('Are you sure you want to delete # {0}?', $language['id'])]); ?> </li>
		<li><?php echo $this->Html->link(__('List {0}', __('Languages')), ['action' => 'index']); ?> </li>
	</ul>
</div>
