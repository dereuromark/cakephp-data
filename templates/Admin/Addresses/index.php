<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Address[]|\Cake\Collection\CollectionInterface $addresses
 */
use Cake\Core\Configure;
?>
<div class="page index">
<h2><?php echo __('Addresses');?></h2>

<table class="table">
<tr>
	<th><?php echo $this->Paginator->sort('country_id');?></th>
<?php if (Configure::read('Data.Address.State')) { ?>
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
			<?php if ($address->country) {
				echo $this->Html->link($address->country->name, ['controller' => 'Countries', 'action' => 'view', $address->country->id]);
			} ?>
		</td>
<?php if (Configure::read('Data.Address.State')) { ?>
		<td>
			<?php if ($address->state) {
				echo $this->Html->link($address->state['name'], ['controller' => 'States', 'action' => 'view', $address->state['id']]);
			} ?>
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
				if ((int)$address->lat != 0 || (int)$address->lng != 0) {
					echo number_format($address->lat, 1, ',', '.');
					echo '/';
					echo number_format($address->lng, 1, ',', '.');
					echo ' ';

					$markers = [];
					$markers[] = ['lat' => $address->lat, 'lng' => $address->lng, 'color' => 'green'];

					if (Configure::read('GoogleMap.key')) {
						$mapMarkers = $this->GoogleMap->staticMarkers($markers);
						echo $this->Html->link($this->Icon->render('view', ['title' => __('Show')]), $this->GoogleMap->staticMapUrl(['center' => $address->lat . ',' . $address->lng, 'markers' => $mapMarkers, 'size' => '640x510', 'zoom' => 12]), ['id' => 'googleMap', 'class' => 'internal zoom-image highslideImage', 'title' => __('click for full map'), 'escape' => false, 'target' => '_blank']);
					} else {
						$options = [
							'to' => $address->lat . ',' . $address->lng,
						];
						echo $this->Html->link($this->Icon->render('view', [], ['title' => __('Show')]), $this->GoogleMap->mapUrl($options), ['class' => 'external', 'title' => __('click for full map'), 'escape' => false, 'target' => '_blank']);
					}
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
			<?php echo $this->Html->link($this->Icon->render('view'), ['action' => 'view', $address['id']], ['escape' => false]); ?>
			<?php echo $this->Html->link($this->Icon->render('edit'), ['action' => 'edit', $address['id']], ['escape' => false]); ?>
			<?php echo $this->Form->postLink($this->Icon->render('delete'), ['action' => 'delete', $address['id']], ['escape' => false, 'confirm' => 'Sure?']); ?>
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
