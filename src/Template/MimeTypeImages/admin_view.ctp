<div class="page view">
<h2><?php echo __('Mime Type Image');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($mimeTypeImage['MimeTypeImage']['name']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Ext'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($mimeTypeImage['MimeTypeImage']['ext']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($mimeTypeImage['MimeTypeImage']['active']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Datetime->niceDate($mimeTypeImage['MimeTypeImage']['created']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Datetime->niceDate($mimeTypeImage['MimeTypeImage']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit Mime Type Image'), array('action' => 'edit', $mimeTypeImage['MimeTypeImage']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Mime Type Image'), array('action' => 'delete', $mimeTypeImage['MimeTypeImage']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $mimeTypeImage['MimeTypeImage']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Mime Type Images'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Add Mime Type Image'), array('action' => 'add')); ?> </li>
	</ul>
</div>