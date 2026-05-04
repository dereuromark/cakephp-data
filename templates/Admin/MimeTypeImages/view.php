<?php
/**
 * @var \App\View\AppView $this
 * @var array $mimeTypeImage
 */
?>
<div class="page view">
<h2><?php echo __d('data', 'Mime Type Image');?></h2>
	<dl>
		<dt><?php echo __d('data', 'Name'); ?></dt>
		<dd>
			<?php echo h($mimeTypeImage['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Ext'); ?></dt>
		<dd>
			<?php echo h($mimeTypeImage['ext']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Active'); ?></dt>
		<dd>
			<?php echo h($mimeTypeImage['active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Created'); ?></dt>
		<dd>
			<?php echo $this->Time->niceDate($mimeTypeImage['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Modified'); ?></dt>
		<dd>
			<?php echo $this->Time->niceDate($mimeTypeImage['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('data', 'Edit Mime Type Image'), ['action' => 'edit', $mimeTypeImage['id']]); ?> </li>
		<li><?php echo $this->Form->postButton(__d('data', 'Delete Mime Type Image'), ['action' => 'delete', $mimeTypeImage['id']], [
			'escapeTitle' => false,
			'class' => 'btn btn-link p-0 align-baseline',
			'form' => [
				'class' => 'd-inline',
				'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $mimeTypeImage['id']),
			],
		]); ?> </li>
		<li><?php echo $this->Html->link(__d('data', 'List Mime Type Images'), ['action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__d('data', 'Add Mime Type Image'), ['action' => 'add']); ?> </li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
