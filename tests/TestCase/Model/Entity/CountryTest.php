<?php

namespace Data\Test\TestCase\Model\Entity;

use Data\Model\Entity\Country;
use Shim\TestSuite\TestCase;

class CountryTest extends TestCase {

	/**
	 * @return void
	 */
	public function testTimezone() {
		$country = new Country();
		$country->timezone_offset = '3600,7200';

		$this->assertNotEmpty($country->timezone_offsets);
		$this->assertSame(['3600' => 3600, '7200' => 7200], $country->timezone_offsets);

		$this->assertNotEmpty($country->timezone_offset_string);
		$this->assertSame('+01:00,+02:00', $country->timezone_offset_string);

		$this->assertNotEmpty($country->timezone_offset_strings);
		$this->assertSame(['3600' => '+01:00', '7200' => '+02:00'], $country->timezone_offset_strings);
	}

}
