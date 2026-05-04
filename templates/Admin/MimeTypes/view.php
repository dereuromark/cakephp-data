<?php
/**
 * @var \App\View\AppView $this
 * @var array $mimeType
 */
?>
<div class="page view">
<h2><?php echo __d('data', 'Mime Type');?></h2>
	<dl>
		<dt><?php echo __d('data', 'Name'); ?></dt>
		<dd>
			<?php echo h($mimeType['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Type'); ?></dt>
		<dd>
			<?php echo h($mimeType['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Active'); ?></dt>
		<dd>
			<?php echo h($mimeType['active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Created'); ?></dt>
		<dd>
			<?php echo $this->Time->niceDate($mimeType['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Modified'); ?></dt>
		<dd>
			<?php echo $this->Time->niceDate($mimeType['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('data', 'Edit Mime Type'), ['action' => 'edit', $mimeType['id']]); ?> </li>
		<li><?php echo $this->Form->postButton(__d('data', 'Delete Mime Type'), ['action' => 'delete', $mimeType['id']], [
			'escapeTitle' => false,
			'class' => 'btn btn-link p-0 align-baseline',
			'form' => [
				'class' => 'd-inline',
				'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $mimeType['id']),
			],
		]); ?> </li>
		<li><?php echo $this->Html->link(__d('data', 'List Mime Types'), ['action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__d('data', 'Add Mime Type'), ['action' => 'add']); ?> </li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
