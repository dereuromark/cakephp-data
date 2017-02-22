<?php
/**
 * @property \Cake\View\View $this
 */
use Cake\Core\Configure;
?>
<div class="page index">
<h2><?php echo __('Addresses');?></h2>

<table class="table">
<tr>
	<th><?php echo $this->Paginator->sort('country_id');?></th>
<?php if (Configure::read('Address.State')) { ?>
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
/** @var \Data\Model\Entity\Address[] $addresses */
foreach ($addresses as $address):
?>
	<tr>
		<td>
			<?php echo $this->Html->link($address['Country']['name'], ['controller' => 'countries', 'action' => 'view', $address['Country']['id']]); ?>
		</td>
<?php if (Configure::read('Address.State')) { ?>
		<td>
			<?php echo $this->Html->link($address['State']['name'], ['controller' => 'states', 'action' => 'view', $address['State']['id']]); ?>
		</td>
<?php } ?>
		<td>
			<?php echo h($address['first_name']); ?>
		</td>
		<td>
			<?php echo h($address['last_name']); ?>
		</td>
		<td>
			<?php echo h($address['street']); ?>
		</td>
		<td>
			<?php echo h($address['postal_code']); ?>
		</td>
		<td>
			<?php echo h($address['city']); ?>
		</td>
		<td>
			<?php
				if ((int)$address['lat'] != 0 || (int)$address['lng'] != 0) {
					echo number_format($address['lat'], 1, ',', '.');
					echo '/';
					echo number_format($address['lng'], 1, ',', '.');

					$markers = [];
					$markers[] = ['lat' => $address['lat'], 'lng' => $address['lng'], 'color' => 'green'];
					$mapMarkers = $this->GoogleMap->staticMarkers($markers);
					echo $this->Html->link($this->Format->icon('view', 'Zeigen'), $this->GoogleMap->staticMapUrl(['center' => $address['lat'] . ',' . $address['lng'], 'markers' => $mapMarkers, 'size' => '640x510', 'zoom' => 12]), ['id' => 'googleMap', 'class' => 'internal highslideImage', 'title' => __('click for full map'), 'escape' => false]);
				}
			 ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($address['last_used']); ?>
		</td>
		<td>
			<?php echo h($address['formatted_address']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Format->icon('view'), ['action' => 'view', $address['id']], ['escape' => false]); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), ['action' => 'edit', $address['id']], ['escape' => false]); ?>
			<?php echo $this->Form->postLink($this->Format->icon('delete'), ['action' => 'delete', $address['id']], ['escape' => false], __('Are you sure you want to delete # {0}?', $address['id'])); ?>
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
	</ul>
</div>
