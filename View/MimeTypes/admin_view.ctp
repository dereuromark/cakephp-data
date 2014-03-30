<div class="page view">
<h2><?php echo __('Mime Type');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($mimeType['MimeType']['name']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($mimeType['MimeType']['type']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($mimeType['MimeType']['active']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Datetime->niceDate($mimeType['MimeType']['created']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Datetime->niceDate($mimeType['MimeType']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit Mime Type'), array('action' => 'edit', $mimeType['MimeType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Mime Type'), array('action' => 'delete', $mimeType['MimeType']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $mimeType['MimeType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Mime Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Add Mime Type'), array('action' => 'add')); ?> </li>
	</ul>
</div>