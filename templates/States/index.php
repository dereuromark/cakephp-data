<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Data\Model\Entity\State> $states
 */

use Cake\Core\Plugin;

?>
<div class="page index">

	<?php if (Plugin::isLoaded('Search')) { ?>
		<div class="search-box" style="float: right">
			<?php echo $this->element('Data.States/search'); ?>
		</div>
	<?php } ?>

<h2><?php echo __('States');?></h2>

<table class="table">
<tr>
	<th><?php echo $this->Paginator->sort('country_id');?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('ori_name');?></th>
	<th><?php echo $this->Paginator->sort('code');?></th>
	<th><?php echo __('Coordinates');?></th>
</tr>
<?php
/** @var \Data\Model\Entity\State[] $states */
foreach ($states as $state):
?>
	<tr>

		<td>
			<?php echo $this->Data->countryIcon($state->country->iso2) . ' ' . h($state->country->name); ?>
		</td>
		<td>
			<?php echo h($state->name); ?>
		</td>
		<td>
			<?php echo h((string)$state->ori_name); ?>
		</td>
		<td>
			<?php echo h($state->code); ?>
		</td>

		<td>
			<?php
			$coordinates = '';
			if ((int)$state->lat != 0 || (int)$state->lat != 0) {
				$coordinates = $state->lat . ',' . $state->lat;
			}
			echo $this->Format->yesNo((int)!empty($coordinates), ['onTitle' => $coordinates, 'offTitle' => 'n/a']);
			?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('Tools.pagination'); ?>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List {0}', __('Countries')), ['controller' => 'Countries', 'action' => 'index']); ?> </li>
	</ul>
</div>
