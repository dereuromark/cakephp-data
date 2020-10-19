<?php
/**
 * @var \App\View\AppView $this
 * @var array $city
 */
?>
<div class="page view">
<h2><?php  echo __('City');?></h2>
	<dl>
		<dt><?php echo __('Country Id'); ?></dt>
		<dd>
			<?php echo h($city['country_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Official Id'); ?></dt>
		<dd>
			<?php echo h($city['official_key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('County Id'); ?></dt>
		<dd>
			<?php echo h($city['county_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($city['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Citizens'); ?></dt>
		<dd>
			<?php echo h($city['citizens']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Postal Code'); ?></dt>
		<dd>
			<?php echo h($city['postal_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lat'); ?></dt>
		<td>
			<?php echo $this->Number->format($city['lat']); ?>
		</td>
		<dt><?php echo __('Lng'); ?></dt>
		<td>
			<?php echo $this->Number->format($city['lng']); ?>
		</td>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo nl2br(h($city['description'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Postal Code Unique'); ?></dt>
		<dd>
			<?php echo $this->Format->yesNo($city['postal_code_unique']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo $this->Time->niceDate($city['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit {0}', __('City')), ['action' => 'edit', $city['id']]); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete {0}', __('City')), ['action' => 'delete', $city['id']], null, __('Are you sure you want to delete # {0}?', $city['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List {0}', __('Cities')), ['action' => 'index']); ?> </li>
	</ul>
</div>
