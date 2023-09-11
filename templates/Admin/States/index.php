<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\State[]|\Cake\Collection\CollectionInterface $states
 */

use Cake\Core\Configure;
use Cake\Core\Plugin;

?>
<?php /**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\State[] $states
 */
//$this->Html->script('highslide/highslide.js')?>
<?php //$this->Html->script('highslide/highslide_config')?>

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
	<th><?php echo $this->Paginator->sort('modified', null, ['direction' => 'desc']);?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
foreach ($states as $state):
?>
	<tr>

		<td>
			<?php echo $this->Data->countryIcon($state->country->iso2); ?> <?php echo $this->Html->link($state->country->name, ['controller' => 'Countries', 'action' => 'view', $state->country->id]); ?>
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
			if ((int)$state->lat != 0 || (int)$state->lng != 0) {
				$coordinates = $state->lat . ',' . $state->lng;
			}
			echo $this->Format->yesNo((int)!empty($coordinates), ['onTitle' => $coordinates, 'offTitle' => 'n/a']) . ' ';

			if (!empty($coordinates)) {
				$markers = [];
				$markers[] = ['lat' => $state->lat, 'lng' => $state->lng, 'color' => 'green'];

				if (Configure::read('GoogleMap.key')) {
					$mapMarkers = $this->GoogleMap->staticMarkers($markers);
					echo ' ' . $this->Html->link($this->Icon->render('view', [], ['title' => __('Show')]), $this->GoogleMap->staticMapUrl(['center' => $state->lat . ',' . $state->lng, 'markers' => $mapMarkers, 'size' => '640x510', 'zoom' => 5]), ['id' => 'googleMap', 'class' => 'internal zoom-image highslideImage', 'title' => __('click for full map'), 'escape' => false, 'target' => '_blank']);
				} else {
					$options = [
						'to' => $state->lat . ',' . $state->lng,
					];
					echo $this->Html->link($this->Icon->render('view', [], ['title' => __('Show')]), $this->GoogleMap->mapUrl($options), ['class' => 'external', 'title' => __('click for full map'), 'escape' => false, 'target' => '_blank']);
				}
			}

			?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($state->modified); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Icon->render('edit'), ['action' => 'edit', $state['id']], ['escape' => false]); ?>

			<?php echo $this->Html->link($this->Icon->render('map-o', [], ['title' => __('Update coordinates')]), ['action' => 'updateCoordinates', $state['id']], ['escape' => false]); ?>

			<?php echo $this->Form->postLink($this->Icon->render('delete'), ['action' => 'delete', $state['id']], ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $state['id'])]); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('Tools.pagination'); ?>
</div>

<div class="actions">
	<ul>
<?php if (true || $this->AuthUser->hasRole('admin')) { ?>
		<li><?php echo $this->Html->link(__('Update Coordinates'), ['action' => 'updateCoordinates']); ?></li>
<?php } ?>
		<li><?php echo $this->Html->link(__('Add State'), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Countries')), ['controller' => 'Countries', 'action' => 'index']); ?> </li>
	</ul>
</div>
