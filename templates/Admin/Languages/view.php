<?php
/**
 * @var \App\View\AppView $this
 * @var array $language
 */
?>
<div class="page view">
<h2><?php echo __d('data', 'Language');?></h2>
	<dl>
		<dt><?php echo __d('data', 'Name'); ?></dt>
		<dd>
			<?php echo h($language['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Ori Name'); ?></dt>
		<dd>
			<?php echo h($language['ori_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Code'); ?></dt>
		<dd>
			<?php echo h($language['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Locale'); ?></dt>
		<dd>
			<?php echo h($language['locale']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Locale Fallback'); ?></dt>
		<dd>
			<?php echo h($language['locale_fallback']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Status'); ?></dt>
		<dd>
			<?php echo h($language['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Modified'); ?></dt>
		<dd>
			<?php echo $this->Time->niceDate($language['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('data', 'Edit {0}', __d('data', 'Language')), ['action' => 'edit', $language['id']]); ?> </li>
		<li><?php echo $this->Form->postButton(__d('data', 'Delete {0}', __d('data', 'Language')), ['action' => 'delete', $language['id']], [
			'class' => 'btn btn-link p-0 align-baseline',
			'form' => [
				'class' => 'd-inline',
				'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $language['id']),
			],
		]); ?> </li>
		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'Languages')), ['action' => 'index']); ?> </li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
