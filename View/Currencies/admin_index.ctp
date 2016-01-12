<div class="page index">
<h2><?php echo __('Currencies');?></h2>

<?php if (CakePlugin::loaded('Search')) { ?>
<div class="search-box">
<?php
echo $this->Form->create();
echo $this->Form->input('search', ['placeholder' => __('wildcardSearch %s and %s', '*', '?')]);
echo $this->Form->submit(__('Search'), []);
echo $this->Form->end();
?>
</div>
<?php } ?>

<table class="list">
<tr>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('code');?></th>
	<th><?php echo $this->Paginator->sort('symbol_left');?></th>
	<th><?php echo $this->Paginator->sort('symbol_right');?></th>
	<th><?php echo $this->Paginator->sort('decimal_places');?></th>
	<th><?php echo $this->Paginator->sort('value');?></th>
	<th class="actions"><?php echo __('Status');?></th>
	<th><?php echo $this->Paginator->sort('modified', null, ['direction' => 'desc']);?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($currencies as $currency):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo h($currency['Currency']['name']); ?>
		</td>
		<td>
			<?php echo h($currency['Currency']['code']); ?>
		</td>
		<td>
			<?php echo h($currency['Currency']['symbol_left']); ?>
		</td>
		<td>
			<?php echo h($currency['Currency']['symbol_right']); ?>
		</td>
		<td>
			<?php echo h($currency['Currency']['decimal_places']); ?>
		</td>
		<td>

			<?php echo $this->Numeric->format($currency['Currency']['value'], 4); ?>
			<?php if ($currency['Currency']['value'] > 0) { ?>
			<div class="reverse"><small>1 <?php echo h($currency['Currency']['code']); ?> = <?php echo $this->Numeric->format(1 / $currency['Currency']['value'], 4)?> <?php echo $baseCurrency['Currency']['code']; ?></small></div>
			<?php } ?>
		</td>
		<td>
			<span class="ajaxToggling" id="ajaxToggle-<?php echo $currency['Currency']['id']?>">
			<?php echo $this->Html->link($this->Format->yesNo($currency['Currency']['active'], ['onTitle' => __('Active'), 'offTitle' => __('Inactive')]), ['action' => 'toggle', 'active', $currency['Currency']['id']], ['escape' => false]); ?></span>&nbsp;&nbsp;<?php
			if ($currency['Currency']['base'] && !empty($baseCurrency)) {
				echo $this->Format->yesNo($currency['Currency']['base'], ['onTitle' => __('Base value')]);
			} else {
				echo $this->Html->link($this->Format->cIcon('checkbox_ticked.gif', 'Zum Basis-Wert machen'), ['action' => 'base', $currency['Currency']['id']], ['escape' => false, 'confirm' => __('Sure?')]);
			} ?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($currency['Currency']['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Format->icon('view'), ['action' => 'view', $currency['Currency']['id']], ['escape' => false]); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), ['action' => 'edit', $currency['Currency']['id']], ['escape' => false]); ?>
			<?php echo $this->Form->postLink($this->Format->icon('delete'), ['action' => 'delete', $currency['Currency']['id']], ['escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $currency['Currency']['id'])]); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('Tools.pagination'); ?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add %s', __('Currency')), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__('Update %s', __('Currency Values')), ['action' => 'update']); ?></li>
	</ul>
</div>
