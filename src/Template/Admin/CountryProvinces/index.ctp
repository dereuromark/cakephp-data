<?php $this->Html->script('highslide/highslide.js')?>
<?php $this->Html->script('highslide/highslide_config')?>

<div class="page index">

<div class="floatRight">
	<?php echo $this->element('Data.CountryProvinces/search'); ?>
</div>

<h2><?php echo __('Country Provinces');?></h2>

<table class="table">
<tr>
	<th><?php echo $this->Paginator->sort('country_id');?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('abbr');?></th>
	<th><?php echo __('Coordinates');?></th>
	<th><?php echo $this->Paginator->sort('modified', null, array('direction' => 'desc'));?></th>
	<th class="actions"><?php echo __('Actions');?></th>
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
			<?php echo $this->Data->countryIcon($countryProvince['Country']['iso2']); ?> <?php echo $this->Html->link($countryProvince['Country']['name'], array('controller' => 'countries', 'action' => 'view', $countryProvince['Country']['id'])); ?>
		</td>
		<td>
			<?php echo h($countryProvince['CountryProvince']['name']); ?>
		</td>
		<td>
			<?php echo h($countryProvince['CountryProvince']['abbr']); ?>
		</td>

		<td>
			<?php
			$coordinates = '';
			if ((int)$countryProvince['CountryProvince']['lat'] != 0 || (int)$countryProvince['CountryProvince']['lng'] != 0) {
				$coordinates = $countryProvince['CountryProvince']['lat'] . ',' . $countryProvince['CountryProvince']['lng'];
			}
			echo $this->Format->yesNo((int)!empty($coordinates), ['onTitle' => $coordinates, 'offTitke' => 'keine hinterlegt']);

			if (!empty($coordinates)) {
				$markers = array();
				$markers[] = array('lat' => $countryProvince['CountryProvince']['lat'], 'lng' => $countryProvince['CountryProvince']['lng'], 'color' => 'green');
				$mapMarkers = $this->GoogleMapV3->staticMarkers($markers);
				echo ' ' . $this->Html->link($this->Format->icon(ICON_DETAILS, [], ['title' => __('Show')]), $this->GoogleMapV3->staticMapUrl(array('center' => $countryProvince['CountryProvince']['lat'] . ',' . $countryProvince['CountryProvince']['lng'], 'markers' => $mapMarkers, 'size' => '640x510', 'zoom' => 5)), array('id' => 'googleMap', 'class' => 'internal highslideImage', 'title' => __('click for full map'), 'escape' => false));
			}

			?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($countryProvince['CountryProvince']['modified']); ?>
		</td>
		<td class="actions">
			<?php //echo $this->Html->link($this->Format->icon('view'), array('action'=>'view', $countryProvince['CountryProvince']['id']), array('escape'=>false)); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), array('action' => 'edit', $countryProvince['CountryProvince']['id']), array('escape' => false)); ?>

			<?php echo $this->Html->link($this->Format->icon('map-o', [], ['title' => __('Koordinaten updaten')]), array('action' => 'update_coordinates', $countryProvince['CountryProvince']['id']), array('escape' => false)); ?>

			<?php echo $this->Form->postLink($this->Format->icon('delete'), array('action' => 'delete', $countryProvince['CountryProvince']['id']), array('escape' => false), __('Are you sure you want to delete # {0}?', $countryProvince['CountryProvince']['id']), false); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('Tools.pagination'); ?>
</div>

<div class="actions">
	<ul>
<?php if (true || $this->AuthUser->hasRole(ROLE_SUPERADMIN)) { ?>
		<li><?php echo $this->Html->link(__('Update Coordinates'), array('action' => 'update_coordinates')); ?></li>
<?php } ?>
		<li><?php echo $this->Html->link(__('Add Country Province'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Countries')), array('controller' => 'countries', 'action' => 'index')); ?> </li>
	</ul>
</div>
