<?php $this->Html->script('highslide/highslide.js')?>
<?php $this->Html->script('highslide/highslide_config')?>

<div class="page index">

<div class="floatRight">
	<?php echo $this->element('Data.States/search'); ?>
</div>

<h2><?php echo __('Country Provinces');?></h2>

<table class="table">
<tr>
	<th><?php echo $this->Paginator->sort('country_id');?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('abbr');?></th>
	<th><?php echo __('Coordinates');?></th>
	<th><?php echo $this->Paginator->sort('modified', null, ['direction' => 'desc']);?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
foreach ($states as $state):
?>
	<tr>

		<td>
			<?php echo $this->Data->countryIcon($state->country['iso2']); ?> <?php echo $this->Html->link($state->country['name'], ['controller' => 'Countries', 'action' => 'view', $state->country['id']]); ?>
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
			if ((int)$state['lat'] != 0 || (int)$state['lng'] != 0) {
				$coordinates = $state['lat'] . ',' . $state['lng'];
			}
			echo $this->Format->yesNo((int)!empty($coordinates), ['onTitle' => $coordinates, 'offTitke' => 'n/a']);

			if (!empty($coordinates)) {
				$markers = [];
				$markers[] = ['lat' => $state['lat'], 'lng' => $state['lng'], 'color' => 'green'];
				$mapMarkers = $this->GoogleMap->staticMarkers($markers);
				echo ' ' . $this->Html->link($this->Format->icon('view', [], ['title' => __('Show')]), $this->GoogleMap->staticMapUrl(['center' => $state['lat'] . ',' . $state['lng'], 'markers' => $mapMarkers, 'size' => '640x510', 'zoom' => 5]), ['id' => 'googleMap', 'class' => 'internal highslideImage', 'title' => __('click for full map'), 'escape' => false]);
			}

			?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($state['modified']); ?>
		</td>
		<td class="actions">
			<?php //echo $this->Html->link($this->Format->icon('view'), array('action'=>'view', $countryProvince['id']), array('escape'=>false)); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), ['action' => 'edit', $state['id']], ['escape' => false]); ?>

			<?php echo $this->Html->link($this->Format->icon('map-o', [], ['title' => __('Koordinaten updaten')]), ['action' => 'update_coordinates', $state['id']], ['escape' => false]); ?>

			<?php echo $this->Form->postLink($this->Format->icon('delete'), ['action' => 'delete', $state['id']], ['escape' => false], __('Are you sure you want to delete # {0}?', $state['id']), false); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('Tools.pagination'); ?>
</div>

<div class="actions">
	<ul>
<?php if (true || $this->AuthUser->hasRole(ROLE_SUPERADMIN)) { ?>
		<li><?php echo $this->Html->link(__('Update Coordinates'), ['action' => 'update_coordinates']); ?></li>
<?php } ?>
		<li><?php echo $this->Html->link(__('Add Country Province'), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Countries')), ['controller' => 'countries', 'action' => 'index']); ?> </li>
	</ul>
</div>
