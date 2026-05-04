<?php
/**
 * @var \App\View\AppView $this
 * @var array $city
 */
?>
<div class="page view">
<h2><?php  echo __d('data', 'City');?></h2>
	<dl>
		<dt><?php echo __d('data', 'Country Id'); ?></dt>
		<dd>
			<?php echo h($city['country_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Official Id'); ?></dt>
		<dd>
			<?php echo h($city['official_key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'County Id'); ?></dt>
		<dd>
			<?php echo h($city['county_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Name'); ?></dt>
		<dd>
			<?php echo h($city['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Citizens'); ?></dt>
		<dd>
			<?php echo h($city['citizens']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Postal Code'); ?></dt>
		<dd>
			<?php echo h($city['postal_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Lat'); ?></dt>
		<td>
			<?php echo $this->Number->format($city['lat']); ?>
		</td>
		<dt><?php echo __d('data', 'Lng'); ?></dt>
		<td>
			<?php echo $this->Number->format($city['lng']); ?>
		</td>
		<dt><?php echo __d('data', 'Description'); ?></dt>
		<dd>
			<?php echo nl2br(h($city['description'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Postal Code Unique'); ?></dt>
		<dd>
			<?php echo $this->Format->yesNo($city['postal_code_unique']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Modified'); ?></dt>
		<dd>
			<?php echo $this->Time->niceDate($city['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('data', 'Edit {0}', __d('data', 'City')), ['action' => 'edit', $city['id']]); ?> </li>
		<li><?php echo $this->Form->postButton(__d('data', 'Delete {0}', __d('data', 'City')), ['action' => 'delete', $city['id']], [
			'class' => 'btn btn-link p-0 align-baseline',
			'form' => [
				'class' => 'd-inline',
				'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $city['id']),
			],
		]); ?> </li>
		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'Cities')), ['action' => 'index']); ?> </li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
