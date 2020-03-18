<?php

namespace TestApp\Model\Behavior;

use Geocoder\Model\Address;
use Geocoder\Model\AdminLevelCollection;
use Geocoder\Model\Bounds;
use Geocoder\Model\Coordinates;
use Geocoder\Model\Country;
use Geo\Model\Behavior\GeocoderBehavior;

/**
 * A test mock
 */
class TestGeocoderBehavior extends GeocoderBehavior {

	/**
	 * @param string $address
	 * @return \Geocoder\Model\Address|null
	 */
	protected function _execute($address) {
		$country = new Country('DE', 'DE');
		$bounds = new Bounds(0, 0, 0, 0);
		$coordinates = new Coordinates(0, 0);
		$adminLevels = new AdminLevelCollection();
		$result = new Address('', $adminLevels, $coordinates, $bounds, 1, 'One', '12345', null, null, null, $country);

		return $result;
	}

}
