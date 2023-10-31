<?php

namespace Data\Test\TestCase\View\Helper;

use Cake\Core\Configure;
use Cake\View\View;
use Data\View\Helper\DataHelper;
use Shim\TestSuite\TestCase;

class DataHelperTest extends TestCase {

	/**
	 * @var \Data\View\Helper\DataHelper
	 */
	protected $DataHelper;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->DataHelper = new DataHelper(new View(null));
	}

	/**
	 * @return void
	 */
	public function testGetCountryIconPaths() {
		$result = $this->DataHelper->getCountryIconPaths();
		$this->assertNotEmpty($result);
	}

	/**
	 * @return void
	 */
	public function testCountryIcon() {
		$result = $this->DataHelper->countryIcon('de');
		$expected = '<img src="/data/country_flags/de.gif" alt="de" title="DE">';
		$this->assertSame($expected, $result);
	}

	/**
	 * @return void
	 */
	public function testCountryIconFont() {
		Configure::write('Country.iconFontClass', 'foo-bar');

		$result = $this->DataHelper->countryIcon('de');
		$expected = '<span class="foo-bar foo-bar-de" title="DE"></span>';
		$this->assertSame($expected, $result);
	}

	/**
	 * @return void
	 */
	public function testLanguageFlag() {
		$result = $this->DataHelper->languageFlag('de');
		$expected = '<img src="/language_flags/de.gif" alt="de" title="DE">';
		$this->assertSame($expected, $result);
	}

	/**
	 * @return void
	 */
	public function testLanguageFlagFont() {
		Configure::write('Language.iconFontClass', 'foo-bar');

		$result = $this->DataHelper->languageFlag('en');
		$expected = '<span class="foo-bar foo-bar-gb" title="GB"></span>';
		$this->assertSame($expected, $result);
	}

}
