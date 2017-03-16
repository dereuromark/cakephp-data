<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page view">
<h2><?php echo __('Mime Type Image');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($mimeTypeImage['name']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Ext'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($mimeTypeImage['ext']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($mimeTypeImage['active']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Time->niceDate($mimeTypeImage['created']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Time->niceDate($mimeTypeImage['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit Mime Type Image'), ['action' => 'edit', $mimeTypeImage['id']]); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Mime Type Image'), ['action' => 'delete', $mimeTypeImage['id']], ['escape' => false], __('Are you sure you want to delete # {0}?', $mimeTypeImage['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Mime Type Images'), ['action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('Add Mime Type Image'), ['action' => 'add']); ?> </li>
	</ul>
</div>
