<div class="page index">

<div class="floatRight">

	<div class="floatRight">
		<?php echo $this->element('Data.CountryProvinces/search'); ?>
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
$i = 0;
foreach ($countryProvinces as $countryProvince):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>

		<td>
			<?php echo $this->Data->countryIcon($countryProvince->country['iso2']) . ' ' . h($countryProvince->country['name']); ?>
		</td>
		<td>
			<?php echo h($countryProvince['name']); ?>
		</td>
		<td>
			<?php echo h($countryProvince['abbr']); ?>
		</td>

		<td>
			<?php
			$coordinates = '';
			if ((int)$countryProvince['lat'] != 0 || (int)$countryProvince['lat'] != 0) {
				$coordinates = $countryProvince['lat'] . ',' . $countryProvince['lat'];
			}
			echo $this->Format->yesNo((int)!empty($coordinates), ['onTitle' => $coordinates, 'offTitle' => 'keine hinterlegt']);
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
		<li><?php echo $this->Html->link(__('List {0}', __('Countries')), array('controller' => 'countries', 'action' => 'index')); ?> </li>
	</ul>
</div>
