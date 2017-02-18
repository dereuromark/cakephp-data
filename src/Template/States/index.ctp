<div class="page index">

<div class="floatRight">

	<div class="floatRight">
		<?php echo $this->element('Data.States/search'); ?>
	</div>
</div>

<h2><?php echo __('Country Provinces');?></h2>

<table class="table">
<tr>
	<th><?php echo $this->Paginator->sort('country_id');?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('abbr');?></th>
	<th><?php echo __('Coordinates');?></th>
</tr>
<?php
/** @var \Data\Model\Entity\State[] $states */
foreach ($states as $state):
?>
	<tr>

		<td>
			<?php echo $this->Data->countryIcon($state->country['iso2']) . ' ' . h($state->country['name']); ?>
		</td>
		<td>
			<?php echo h($state['name']); ?>
		</td>
		<td>
			<?php echo h($state['abbr']); ?>
		</td>

		<td>
			<?php
			$coordinates = '';
			if ((int)$state['lat'] != 0 || (int)$state['lat'] != 0) {
				$coordinates = $state['lat'] . ',' . $state['lat'];
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
