<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Continent $continent
 * @var object $content
 */
?>
<div class="page view">
<h1><?php echo __('Continent');?></h1>

	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($continent['name']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Ori Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($continent['ori_name']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Parent Continent'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($continent->parent_continent['name'], ['controller' => 'Continents', 'action' => 'view', $continent->parent_continent['id']]); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($continent['status']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Time->niceDate($continent['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit {0}', __('Continent')), ['action' => 'edit', $continent['id']]); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete {0}', __('Continent')), ['action' => 'delete', $continent['id']], ['confirm' => __('Are you sure you want to delete # {0}?', $continent['id'])]); ?> </li>
	</ul>
</div>
