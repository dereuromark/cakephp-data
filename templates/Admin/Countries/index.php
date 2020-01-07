<?php
/**
 * @var \Data\Model\Entity\Country[] $countries
 */
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Country[]|\Cake\Collection\CollectionInterface $countries
 */
use Cake\Core\Plugin;
?>

<?php $this->Html->css('highslide/highslide'); ?>

<?php $this->Html->script('highslide/highslide'); ?>
<?php $this->Html->script('highslide/highslide_config'); ?>

<div class="page index">
<h2><?php echo __('Countries');?></h2>

<?php if (Plugin::loaded('Search')) { ?>
<div class="search-box">
<?php
echo $this->Form->create();
echo $this->Form->control('search', ['placeholder' => __('wildcardSearch {0} and {1}', '*', '?')]);
echo $this->Form->submit(__('Search'), []);
echo $this->Form->end();
?>
</div>
<?php } ?>

<table class="table">
<tr>
	<th>&nbsp;</th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('ori_name');?></th>
	<th><?php echo $this->Paginator->sort('iso2');?></th>
	<th><?php echo $this->Paginator->sort('iso3');?></th>
	<th><?php echo $this->Paginator->sort('country_code');?></th>
	<th><?php echo __('Coordinates');?></th>
	<th><?php echo $this->Paginator->sort('sort');?></th>
	<th><?php echo $this->Paginator->sort('modified', null, ['direction' => 'desc']);?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
foreach ($countries as $country):
?>
	<tr>
		<td>
			<?php echo $this->Data->countryIcon($country['iso2']); ?>
		</td>
		<td>
			<?php echo $this->Html->link($country['name'], ['controller' => 'states', 'action' => 'index', $country['id']]); ?>
		</td>
		<td>
			<?php echo h($country['ori_name']); ?>
		</td>
		<td>
			<?php echo $country['iso2']; ?>
		</td>
		<td>
			<?php echo $country['iso3']; ?>
		</td>
		<td>
			<?php echo '+' . $country['country_code']; ?>
		</td>

		<td>
			<?php
			$coordinates = '';
			if ((int)$country['lat'] != 0 || (int)$country['lng'] != 0) {
				$coordinates = $country['lat'] . ',' . $country['lng'];
			}
			echo $this->Format->yesNo((int)!empty($coordinates), ['onTitle' => $coordinates, 'offTitle' => __('n/a')]);

			if (!empty($coordinates)) {
				$markers = [];
				$markers[] = ['lat' => $country['lat'], 'lng' => $country['lng'], 'color' => 'green'];
				$mapMarkers = $this->GoogleMap->staticMarkers($markers);
				echo ' ' . $this->Html->link($this->Format->icon('view', [], ['title' => __('Show')]), $this->GoogleMap->staticMapUrl(['center' => $country['lat'] . ',' . $country['lng'], 'markers' => $mapMarkers, 'size' => '640x510', 'zoom' => 3]), ['id' => 'googleMap', 'class' => 'internal highslideImage', 'title' => __('click for full map'), 'escape' => false]);
			}

			?>
		</td>

		<td>
			<?php echo $country['sort']; ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($country['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Format->icon('up'), ['action' => 'up', $country['id']], ['escape' => false]); ?>
			<?php echo $this->Html->link($this->Format->icon('down'), ['action' => 'down', $country['id']], ['escape' => false]); ?>
			<?php //echo $this->Html->link($this->Format->icon('view'), array('action'=>'view', $country['id']), array('escape'=>false)); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), ['action' => 'edit', $country['id']], ['escape' => false]); ?>

			<?php echo $this->Html->link($this->Format->icon('map-o', [], ['title' => __('Koordinaten updaten')]), ['action' => 'update_coordinates', $country['id']], ['escape' => false]); ?>

			<?php echo $this->Form->postLink($this->Format->icon('delete'), ['action' => 'delete', $country['id']], ['escape' => false], __('Are you sure you want to delete # {0}?', $country['id']), false); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('Tools.pagination'); ?>

</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add {0}', __('Country')), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__('Update Coordinates'), ['action' => 'update_coordinates']); ?></li>
		<li><?php echo $this->Html->link(__('Icons'), ['action' => 'icons']); ?></li>
	</ul>
</div>

<br/>
Hinweis:
<ul>
<li><?__('countryCodeExplanation')?></li>
</ul>

<br/>
<span class="keyList">Legende:</span>
<ul class="keyList">
<li><?php echo $this->Data->countryIcon(null); ?> = Default Icon</li>
</ul>
