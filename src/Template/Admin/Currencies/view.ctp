<div class="page view">
<h2><?php echo __('Currency');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($currency['Currency']['name']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($currency['Currency']['code']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Symbol Left'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($currency['Currency']['symbol_left']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Symbol Right'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($currency['Currency']['symbol_right']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Decimal Places'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($currency['Currency']['decimal_places']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Value'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($currency['Currency']['value']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Time->niceDate($currency['Currency']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit {0}', __('Currency')), ['action' => 'edit', $currency['Currency']['id']]); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Currency'), ['action' => 'delete', $currency['Currency']['id']], ['escape' => false], __('Are you sure you want to delete # {0}?', $currency['Currency']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List {0}', __('Currencies')), ['action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('Add {0}', __('Currency')), ['action' => 'add']); ?> </li>
	</ul>
</div>