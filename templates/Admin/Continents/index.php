<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Data\Model\Entity\Continent> $continents
 */
?>
<div class="page index">
<h2><?php echo __('Continents');?></h2>

<table class="table">
<tr>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('code');?></th>
	<th><?php echo $this->Paginator->sort('parent_id');?></th>
	<th><?php echo $this->Paginator->sort('modified', null, ['direction' => 'desc']);?></th>
	<th class="actions"><?php echo __('Actions');?></th>
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
			<?php echo $this->Html->link($this->Icon->render('view'), ['action' => 'view', $continent['id']], ['escape' => false]); ?>
			<?php echo $this->Html->link($this->Icon->render('edit'), ['action' => 'edit', $continent['id']], ['escape' => false]); ?>
			<?php echo $this->Form->postLink($this->Icon->render('delete'), ['action' => 'delete', $continent['id']], ['escape' => false, 'confirm' => 'Sure?']); ?>
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
		<li><?php echo $this->Html->link(__('Add {0}', __('Continent')), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__('Tree'), ['action' => 'tree']); ?></li>
	</ul>
</div>
