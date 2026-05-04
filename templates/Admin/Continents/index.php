<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Data\Model\Entity\Continent> $continents
 */
?>
<div class="page index">
<h2><?php echo __d('data', 'Continents');?></h2>

<table class="table">
<tr>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('code');?></th>
	<th><?php echo $this->Paginator->sort('parent_id');?></th>
	<th><?php echo $this->Paginator->sort('modified', null, ['direction' => 'desc']);?></th>
	<th class="actions"><?php echo __d('data', 'Actions');?></th>
</tr>
<?php
foreach ($continents as $continent):
?>
	<tr>
		<td>
			<?php echo h($continent['name']); ?>
		</td>
		<td>
			<?php echo h($continent['code']); ?>
		</td>
		<td>
			<?php echo $continent->parent_continent ? $this->Html->link($continent->parent_continent->name, ['controller' => 'Continents', 'action' => 'view', $continent->parent_continent['id']]) : ''; ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($continent['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Icon->render('view'), ['action' => 'view', $continent['id']], ['escapeTitle' => false]); ?>
			<?php echo $this->Html->link($this->Icon->render('edit'), ['action' => 'edit', $continent['id']], ['escapeTitle' => false]); ?>
			<?php echo $this->Form->postButton($this->Icon->render('delete'), ['action' => 'delete', $continent['id']], [
				'escapeTitle' => false,
				'class' => 'btn btn-link p-0 align-baseline',
				'form' => [
					'class' => 'd-inline',
					'data-confirm-message' => 'Sure?',
				],
			]); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<div class="pagination-container">
<?php echo $this->element('Tools.pagination'); ?></div>

</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('data', 'Add {0}', __d('data', 'Continent')), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__d('data', 'Tree'), ['action' => 'tree']); ?></li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
