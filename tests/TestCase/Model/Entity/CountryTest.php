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
		$country->timezone = '3600,7200';

		$this->assertNotEmpty($country->timezones);
		$this->assertSame(['3600' => 3600, '7200' => 7200], $country->timezones);

		$this->assertNotEmpty($country->timezoneString);
		$this->assertSame('+01:00,+02:00', $country->timezoneString);

		$this->assertNotEmpty($country->timezoneStrings);
		$this->assertSame(['3600' => '+01:00', '7200' => '+02:00'], $country->timezoneStrings);
	}

}
