<div class="page index">
<h2><?php echo __('Smileys');?></h2>

<table class="table"><tr>
	<th>&nbsp;</th>
<?php if (false) { ?>
	<th><?php echo $this->Paginator->sort('smiley_cat_id');?></th>
<?php } ?>
	<th><?php echo $this->Paginator->sort('prim_code');?></th>
	<th><?php echo $this->Paginator->sort('sec_code');?></th>
	<th><?php echo $this->Paginator->sort('title');?></th>
	<th><?php echo $this->Paginator->sort('is_base');?></th>
	<th><?php echo $this->Paginator->sort('active');?></th>
	<th><?php echo $this->Paginator->sort('modified', null, ['direction' => 'desc']);?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($smileys as $smiley):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr>
		<td>
			<?php echo $this->Html->imageIfExists('/data/img/smileys/default/' . $smiley['Smiley']['smiley_path'])?>
		</td>
<?php if (false) { ?>
		<td>
			<?php echo h($smiley['Smiley']['smiley_cat_id']); ?>
		</td>
<?php } ?>
		<td>
			<?php echo h($smiley['Smiley']['prim_code']); ?>
		</td>
		<td>
			<?php echo h($smiley['Smiley']['sec_code']); ?>
		</td>
		<td>
			<?php echo h($smiley['Smiley']['title']); ?>
		</td>
		<td>
			<span class="ajaxToggling" id="ajaxToggle-is_base-<?php echo $smiley['Smiley']['id']?>">
			<?php echo $this->Html->link($this->Format->yesNo($smiley['Smiley']['is_base'], ['onTitle' => 'Yes', 'offTitle' => 'No']), ['action' => 'toggle', 'is_base', $smiley['Smiley']['id']], ['escape' => false]); ?>
			</span>
		</td>
		<td>
			<span class="ajaxToggling" id="ajaxToggle-active-<?php echo $smiley['Smiley']['id']?>">
			<?php echo $this->Html->link($this->Format->yesNo($smiley['Smiley']['active'], ['onTitle' => 'Active', 'offTitle' => 'Inactive']), ['action' => 'toggle', 'active', $smiley['Smiley']['id']], ['escape' => false]); ?>
			</span>
		</td>
		<td>
			<?php echo $this->Time->niceDate($smiley['Smiley']['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Format->icon('view'), ['action' => 'view', $smiley['Smiley']['id']], ['escape' => false]); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), ['action' => 'edit', $smiley['Smiley']['id']], ['escape' => false]); ?>
			<?php echo $this->Form->postLink($this->Format->icon('delete'), ['action' => 'delete', $smiley['Smiley']['id']], ['escape' => false], __('Are you sure you want to delete # {0}?', $smiley['Smiley']['id'])); ?>
		</td>
	</tr>
<?php

?>
<?php endforeach; ?>
	</table>

<div class="pagination-container">
<?php echo $this->element('Tools.pagination'); ?></div>

</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add {0}', __('Smiley')), ['action' => 'add']); ?></li>
	</ul>
</div>
