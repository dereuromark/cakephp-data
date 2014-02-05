<?php $this->Html->script($this->GoogleMapV3->apiUrl(), array('inline' => false))?>

<h2>Area Codes</h2>
<h3>Map</h3>

<div>
<?php echo $this->Form->create('PostalCode');?>
	<fieldset>
		<legend><?php echo __('Search %s', __('Area Code')); ?></legend>
	<?php
		echo $this->Form->input('code');
		echo $this->Form->submit(__('Submit'));
	?>
	</fieldset>
<?php echo $this->Form->end();?>

</div>

<?php
if (!isset($numbers)) {
	$numbers = 0;
}

$zooms = array(
	0 => 5,
	1 => 6, # 0 ... 9
	2 => 7, # 00 ... 99
	3 => 8, # 000 ... 999
	4 => 9, # 0000 ... 9999
	5 => 10, # 00001 ... 99999
);
$zoom = $zooms[$numbers];

$mapOptions = array('zoom' => $zoom);
if (!empty($overviewCode)) {
	$mapOptions['lat'] = $overviewCode['PostalCode']['lat'];
	$mapOptions['lng'] = $overviewCode['PostalCode']['lng'];
}
echo $this->GoogleMapV3->map(array('map' => $mapOptions));

foreach ($postalCodes as $code) {
	$title = $code[0]['sub'];
	$lat = $code['PostalCode']['lat'];
	$lng = $code['PostalCode']['lng'];

	$content = 'Area Code <b>' . $title . '</b>' . BR . $code[0]['count'] . ' codes for this area';
	$content .= ' ' . $this->Html->link($this->Format->cIcon(ICON_MAP), $this->GoogleMapV3->mapUrl(array('to' => $lat . ',' . $lng)), array('escape' => false));

	# more correct average location
	if (isset($code[0]['lat_sum'])) {
		$lat = ($code[0]['lat_sum'] / $code[0]['count']);
	}
	if (isset($code[0]['lng_sum'])) {
		$lng = ($code[0]['lng_sum'] / $code[0]['count']);
	}


	$this->GoogleMapV3->addMarker(array('lat' => $lat, 'lng' => $lng, 'title' => $title, 'content' => $content));
}

echo $this->GoogleMapV3->script();


//pr($postalCodes);

?>

<h3>Reverse Geocoding</h3>
Auf die Karte klicken, um Area Code zu erhalten
<br />//TODO
<div>

</div>