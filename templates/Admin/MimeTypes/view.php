<?php
/**
 * @var \App\View\AppView $this
 * @var array $mimeType
 */
?>
<div class="page view">
<h2><?php echo __('Mime Type');?></h2>
	<dl>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($mimeType['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($mimeType['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($mimeType['active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo $this->Time->niceDate($mimeType['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo $this->Time->niceDate($mimeType['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit Mime Type'), ['action' => 'edit', $mimeType['id']]); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Mime Type'), ['action' => 'delete', $mimeType['id']], ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $mimeType['id'])]); ?> </li>
		<li><?php echo $this->Html->link(__('List Mime Types'), ['action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('Add Mime Type'), ['action' => 'add']); ?> </li>
	</ul>
</div>
