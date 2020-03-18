<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\PostalCode[]|\Cake\Collection\CollectionInterface $postalCodes
 * @var array $overviewCode
 */
?>
<?php /**
 * @var \App\View\AppView $this
 */
$this->Html->script($this->GoogleMap->apiUrl(), ['inline' => false])?>

<h2>Area Codes</h2>
<h3>Map</h3>

<div>
<?php echo $this->Form->create($postalCode);?>
	<fieldset>
		<legend><?php echo __('Search {0}', __('Area Code')); ?></legend>
	<?php
		echo $this->Form->control('code');
		echo $this->Form->submit(__('Submit'));
	?>
	</fieldset>
<?php echo $this->Form->end();?>

</div>

<?php
if (!isset($numbers)) {
	$numbers = 0;
}

$zooms = [
	0 => 5,
	1 => 6, # 0 ... 9
	2 => 7, # 00 ... 99
	3 => 8, # 000 ... 999
	4 => 9, # 0000 ... 9999
	5 => 10, # 00001 ... 99999
];
$zoom = $zooms[$numbers];

$mapOptions = ['zoom' => $zoom];
if (!empty($overviewCode)) {
	$mapOptions['lat'] = $overviewCode['lat'];
	$mapOptions['lng'] = $overviewCode['lng'];
}
echo $this->GoogleMap->map(['map' => $mapOptions]);

/**
 * @var \Data\Model\Entity\PostalCode[] $postalCodes
 */
foreach ($postalCodes as $postalCode) {
	$title = $postalCode['sub'];
	$lat = $postalCode['lat'];
	$lng = $postalCode['lng'];

	$content = 'Area Code <b>' . $title . '</b>' . '<br>' . $postalCode['count'] . ' codes for this area';
	$content .= ' ' . $this->Html->link($this->Format->icon('map'), $this->GoogleMap->mapUrl(['to' => $lat . ',' . $lng]), ['escape' => false]);

	# more correct average location
	if (isset($postalCode['lat_sum'])) {
		$lat = ($postalCode['lat_sum'] / $postalCode['count']);
	}
	if (isset($postalCode['lng_sum'])) {
		$lng = ($postalCode['lng_sum'] / $postalCode['count']);
	}


	$this->GoogleMap->addMarker(['lat' => $lat, 'lng' => $lng, 'title' => $title, 'content' => $content]);
}

echo $this->GoogleMap->script();


//pr($postalCodes);

?>

<h3>Reverse Geocoding</h3>
Auf die Karte klicken, um Area Code zu erhalten
<br/>//TODO
<div>

</div>
