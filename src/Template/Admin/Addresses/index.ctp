<div class="page index">
<h2><?php echo __('Addresses');?></h2>

<table class="table">
<tr>
	<th><?php echo $this->Paginator->sort('country_id');?></th>
<?php if (Configure::read('Address.CountryProvince')) { ?>
	<th><?php echo $this->Paginator->sort('country_province_id');?></th>
<?php } ?>
	<th><?php echo $this->Paginator->sort('first_name');?></th>
	<th><?php echo $this->Paginator->sort('last_name');?></th>
	<th><?php echo $this->Paginator->sort('street');?></th>
	<th><?php echo $this->Paginator->sort('postal_code');?></th>
	<th><?php echo $this->Paginator->sort('city');?></th>
	<th><?php echo __('Coordinates');?></th>
	<th><?php echo $this->Paginator->sort('last_used');?></th>
	<th><?php echo $this->Paginator->sort('formatted_address');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($addresses as $address):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr>
		<td>
			<?php echo $this->Html->link($address['Country']['name'], ['controller' => 'countries', 'action' => 'view', $address['Country']['id']]); ?>
		</td>
<?php if (Configure::read('Address.CountryProvince')) { ?>
		<td>
			<?php echo $this->Html->link($address['CountryProvince']['name'], ['controller' => 'country_provinces', 'action' => 'view', $address['CountryProvince']['id']]); ?>
		</td>
<?php } ?>
		<td>
			<?php echo h($address['Address']['first_name']); ?>
		</td>
		<td>
			<?php echo h($address['Address']['last_name']); ?>
		</td>
		<td>
			<?php echo h($address['Address']['street']); ?>
		</td>
		<td>
			<?php echo h($address['Address']['postal_code']); ?>
		</td>
		<td>
			<?php echo h($address['Address']['city']); ?>
		</td>
		<td>
			<?php
				if ((int)$address['Address']['lat'] != 0 || (int)$address['Address']['lng'] != 0) {
					echo number_format($address['Address']['lat'], 1, ',', '.');
					echo '/';
					echo number_format($address['Address']['lng'], 1, ',', '.');

					$markers = [];
					$markers[] = ['lat' => $address['Address']['lat'], 'lng' => $address['Address']['lng'], 'color' => 'green'];
					$mapMarkers = $this->GoogleMap->staticMarkers($markers);
					echo $this->Html->link($this->Format->icon('view', 'Zeigen'), $this->GoogleMap->staticMapUrl(['center' => $address['Address']['lat'] . ',' . $address['Address']['lng'], 'markers' => $mapMarkers, 'size' => '640x510', 'zoom' => 12]), ['id' => 'googleMap', 'class' => 'internal highslideImage', 'title' => __('click for full map'), 'escape' => false]);
				}
			 ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($address['Address']['last_used']); ?>
		</td>
		<td>
			<?php echo h($address['Address']['formatted_address']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Format->icon('view'), ['action' => 'view', $address['Address']['id']], ['escape' => false]); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), ['action' => 'edit', $address['Address']['id']], ['escape' => false]); ?>
			<?php echo $this->Form->postLink($this->Format->icon('delete'), ['action' => 'delete', $address['Address']['id']], ['escape' => false], __('Are you sure you want to delete # {0}?', $address['Address']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<div class="pagination-container">
<?php echo $this->element('Tools.pagination'); ?></div>

</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add {0}', __('Address')), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Countries')), ['controller' => 'countries', 'action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('List {0}', __('Country Provinces')), ['controller' => 'country_provinces', 'action' => 'index']); ?> </li>
	</ul>
</div>
