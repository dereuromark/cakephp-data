<?php $this->Html->script($this->GoogleMapV3->apiUrl(), array('inline' => false))?>
<?php $this->Html->script($this->GoogleMapV3->gearsUrl(), array('inline' => false))?>

<h2>Geolocate</h2>
Funktioniert bisher nur in Cutting-Edge-Browsern wie Google Chrome (evtl noch Firefox).
<br />
Achtung: Muss man die Geo-Abfrage erst manuell erlauben. Ein Bestätigungs-Fenster ganz oben im Browser öffnet sich dazu (Öffnet es sich nicht, hat man es entweder global erlaubt oder der Browser ist zu alt)!!!
<h3>Map</h3>

<?php
$lat = 51;
$lng = 10;
$zoom = 6;
if (isset($ipData['lat'])) {
	$lat = $ipData['lat'];
}
if (isset($ipData['lng'])) {
	$lng = $ipData['lng'];
	$zoom = 10;
}

echo $this->GoogleMapV3->map(array('zoom' => $zoom, 'geolocate' => true, 'lat' => $lat, 'lng' => $lng));


$title = 'Eigene Position';
$content = 'Eigene Position';

$this->GoogleMapV3->addMarker(array('lat' => $lat, 'lng' => $lng, 'title' => $title, 'content' => $content));



$js = 'initialLocation = new google.maps.LatLng(lat, lng);';
$js .= 'gMarkers0[0].setPosition(initialLocation);';
$js .= 'map0.setCenter(initialLocation);';
$js .= 'map0.setZoom(15);';
$js .= '$(".geoResults").html(lat + ", " + lng);';

$this->GoogleMapV3->geolocateCallback($js);


echo $this->GoogleMapV3->script();


?>

<h3>Resultat (Achtung, wenn hier keine Koordinaten stehen, hats nich geklappt!)</h3>
<div class="geoResults">
<i>keines bisher</i>
</div>


<h3>Fallback-Resultat</h3>
Für den Fall, dass es nicht klappt (keine Koordinaten ermittelbar): Serverseitiges Auflösen der IP-Adresse
<?php
	echo pre($ipData);
?>


<h3>Hinweise</h3>
Angeblich funktioniert das deshalb in den meisten Fällen so genau, da diese Geolocation Funktion über den Browser Informationen über WLAN Netze die in der Nähe sind sammelt und diese Daten mit einer Datenbank von WLAN Netzen abgeglichen werden (<a href="http://board.protecus.de/t39165.htm" rel="external">Details</a>). Falls jemand auch ohne WLAN-Netz daheim hausgenau gefunden wird, bitte melden! :)
<br /><br />

Auf <a href="http://www.browsergeolocation.com/" rel="external">browsergeolocation.com/</a> steht, welche Browser geeignet sind.