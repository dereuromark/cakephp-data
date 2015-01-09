<?php

namespace Data\Test\TestCase\View\Helper;

use Cake\View\View;
use Data\View\Helper\DataHelper;
use Tools\TestSuite\TestCase;

class DataHelperTest extends TestCase {

	public $DataHelper;

	public function setUp() {
		parent::setUp();

		$this->DataHelper = new DataHelper(new View(null));
	}

	/**
	 * DataHelperTest::test()
	 *
	 * @return void
	 */
	public function testCountryAndProvince() {
		$data = array(
			'Country' => array(
				'iso2' => 'de',
				'name' => 'Deutschland'
			),
			'CountryProvince' => array(
				'abbr' => 'BAY',
				'name' => 'Bayern'
			)
		);
		$result = $this->DataHelper->countryAndProvince($data);
		$expected = '<span class="help" title="Deutschland - Bayern"><img src="/data/img/country_flags/de.gif" alt=""/>&nbsp;BAY</span>';
		$this->assertEquals($expected, $result);
	}

}
