<div class="page view">
<h2><?php echo __('Mime Type Image');?></h2>
	<dl>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($mimeTypeImage['MimeTypeImage']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ext'); ?></dt>
		<dd>
			<?php echo h($mimeTypeImage['MimeTypeImage']['ext']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($mimeTypeImage['MimeTypeImage']['active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo $this->Datetime->niceDate($mimeTypeImage['MimeTypeImage']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo $this->Datetime->niceDate($mimeTypeImage['MimeTypeImage']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit Mime Type Image'), ['action' => 'edit', $mimeTypeImage['MimeTypeImage']['id']]); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Mime Type Image'), ['action' => 'delete', $mimeTypeImage['MimeTypeImage']['id']], ['escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $mimeTypeImage['MimeTypeImage']['id'])]); ?> </li>
		<li><?php echo $this->Html->link(__('List Mime Type Images'), ['action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('Add Mime Type Image'), ['action' => 'add']); ?> </li>
	</ul>
</div>