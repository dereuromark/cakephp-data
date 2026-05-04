<?php
/**
 * @var \App\View\AppView $this
 * @var array $currency
 */
?>
<div class="page view">
<h2><?php echo __d('data', 'Currency');?></h2>
	<dl>
		<dt><?php echo __d('data', 'Name'); ?></dt>
		<dd>
			<?php echo h($currency['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Code'); ?></dt>
		<dd>
			<?php echo h($currency['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Symbol Left'); ?></dt>
		<dd>
			<?php echo h($currency['symbol_left']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Symbol Right'); ?></dt>
		<dd>
			<?php echo h($currency['symbol_right']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Decimal Places'); ?></dt>
		<dd>
			<?php echo h($currency['decimal_places']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Value'); ?></dt>
		<dd>
			<?php echo h($currency['value']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Modified'); ?></dt>
		<dd>
			<?php echo $this->Time->niceDate($currency['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('data', 'Edit {0}', __d('data', 'Currency')), ['action' => 'edit', $currency['id']]); ?> </li>
		<li><?php echo $this->Form->postButton(__d('data', 'Delete Currency'), ['action' => 'delete', $currency['id']], [
			'escapeTitle' => false,
			'class' => 'btn btn-link p-0 align-baseline',
			'form' => [
				'class' => 'd-inline',
				'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $currency['id']),
			],
		]); ?> </li>
		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'Currencies')), ['action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__d('data', 'Add {0}', __d('data', 'Currency')), ['action' => 'add']); ?> </li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
