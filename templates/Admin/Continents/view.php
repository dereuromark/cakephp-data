<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Continent $continent
 */
?>
<div class="page view">
<h1><?php echo __d('data', 'Continent');?></h1>

	<h2><?php echo h($continent['name']); ?></h2>
	<dl>

		<dt><?php echo __d('data', 'Ori Name'); ?></dt>
		<dd>
			<?php echo h($continent['ori_name']); ?>
			&nbsp;
		</dd>

		<dt><?php echo __d('data', 'Code'); ?></dt>
		<dd>
			<?php echo h($continent->code); ?>
		</dd>

		<dt><?php echo __d('data', 'Parent Continent'); ?></dt>
		<dd>
			<?php echo $continent->parent_continent ? $this->Html->link($continent->parent_continent->name, ['controller' => 'Continents', 'action' => 'view', $continent->parent_continent['id']]) : ''; ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Status'); ?></dt>
		<dd>
			<?php echo h($continent['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Modified'); ?></dt>
		<dd>
			<?php echo $this->Time->niceDate($continent['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('data', 'Edit {0}', __d('data', 'Continent')), ['action' => 'edit', $continent['id']]); ?> </li>
		<li><?php echo $this->Form->postButton(__d('data', 'Delete {0}', __d('data', 'Continent')), ['action' => 'delete', $continent['id']], [
			'class' => 'btn btn-link p-0 align-baseline',
			'form' => [
				'class' => 'd-inline',
				'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $continent['id']),
			],
		]); ?> </li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
