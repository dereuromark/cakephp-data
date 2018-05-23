<?php
namespace App\Model\Behavior;

use Geocoder\Model\Address;
use Geocoder\Model\Bounds;
use Geocoder\Model\Country;
use Geo\Model\Behavior\GeocoderBehavior as ToolsGeocoderBehavior;

/**
 * A test mock
 */
class GeocoderBehavior extends ToolsGeocoderBehavior {

	/**
	 * @param string $address
	 * @return \Geocoder\Model\Address|null
	 */
	protected function _execute($address) {
		$country = new Country('DE', 'DE');
		$bounds = new Bounds(0, 0, 0, 0);
		$result = new Address(null, $bounds, 1, 'One', '12345', null, null, null, $country);

		return $result;
	}

}
