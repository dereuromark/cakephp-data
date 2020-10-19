<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $continents
 * @var object $content
 */
?>
<div class="page index">
<h2><?php echo __('Continents');?></h2>

<table class="table">
<tr>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('ori_name');?></th>
	<th><?php echo $this->Paginator->sort('parent_id');?></th>
	<th><?php echo $this->Paginator->sort('modified', null, ['direction' => 'desc']);?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($continents as $continent):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr>
		<td>
			<?php echo h($continent['name']); ?>
		</td>
		<td>
			<?php echo h($continent['ori_name']); ?>
		</td>
		<td>
			<?php echo $this->Html->link($continent->parent['name'], ['controller' => 'continents', 'action' => 'view', $content->parent['id']]); ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($continent['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Format->icon('view'), ['action' => 'view', $continent['id']], ['escape' => false]); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), ['action' => 'edit', $continent['id']], ['escape' => false]); ?>
			<?php echo $this->Form->postLink($this->Format->icon('delete'), ['action' => 'delete', $continent['id']], ['escape' => false, 'confirm' => 'Sure?']); ?>
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
		<li><?php echo $this->Html->link(__('List {0}', __('Continents')), ['controller' => 'continents', 'action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('List {0}', __('Countries')), ['controller' => 'countries', 'action' => 'index']); ?> </li>
	</ul>
</div>
