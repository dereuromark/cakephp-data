<?php
/**
 * @var \App\View\AppView $this
 */
use Cake\Core\Plugin;
?>

<div class="page index">
<h2><?php
	echo __('Currencies');?></h2>

<table class="table">
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
/** @var \Data\Model\Entity\Currency[] $currencies */
foreach ($currencies as $currency):
?>
	<tr>
		<td>
			<?php echo h($currency['name']); ?>
		</td>
		<td>
			<?php echo h($currency['code']); ?>
		</td>
		<td>
			<?php echo h($currency['symbol_left']); ?>
		</td>
		<td>
			<?php echo h($currency['symbol_right']); ?>
		</td>
		<td>
			<?php echo h($currency['decimal_places']); ?>
		</td>
		<td>

			<?php echo $this->Number->format($currency['value'], ['places' => 4]); ?>
			<?php if ($currency['value'] > 0) { ?>
			<div class="reverse"><small>1 <?php echo h($currency['code']); ?> = <?php echo $this->Number->format(1 / $currency['value'], ['places' => 4])?> <?php echo $baseCurrency['code']; ?></small></div>
			<?php } ?>
		</td>
		<td>
			<span class="ajaxToggling" id="ajaxToggle-<?php echo $currency['id']?>">
			<?php echo $this->Html->link($this->Format->yesNo($currency['active'], ['onTitle' => __('Active'), 'offTitle' => __('Inactive')]), ['action' => 'toggle', 'active', $currency['id']], ['escape' => false]); ?></span>&nbsp;&nbsp;<?php
			if ($currency['base'] && !empty($baseCurrency)) {
				echo $this->Format->yesNo($currency['base'], ['onTitle' => __('Base value')]);
			} else {
				echo $this->Html->link($this->Format->icon('check-square-o', ['title' => __('Zum Basis-Wert machen')]), ['action' => 'base', $currency['id']], ['escape' => false], 'Sicher?');
			} ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($currency['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Format->icon('view'), ['action' => 'view', $currency['id']], ['escape' => false]); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), ['action' => 'edit', $currency['id']], ['escape' => false]); ?>
			<?php echo $this->Form->postLink($this->Format->icon('delete'), ['action' => 'delete', $currency['id']], ['escape' => false], __('Are you sure you want to delete # {0}?', $currency['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('Tools.pagination'); ?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add {0}', __('Currency')), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__('Update {0}', __('Currency Values')), ['action' => 'update']); ?></li>
	</ul>
</div>
