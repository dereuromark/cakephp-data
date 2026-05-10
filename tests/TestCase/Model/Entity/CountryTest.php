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

	/**
	 * No constraints set: any input is accepted (countries with no declared format).
	 *
	 * @return void
	 */
	public function testValidatePostalCodeWithNoConstraints() {
		$country = new Country();
		$country->zip_length = 0;
		$country->zip_regexp = '';

		$this->assertTrue($country->validatePostalCode('12345'));
		$this->assertTrue($country->validatePostalCode('whatever'));
		// Empty input accepted only when no constraint is declared.
		$this->assertTrue($country->validatePostalCode(''));
	}

	/**
	 * zip_length-only validation: code's mb-length must match exactly.
	 *
	 * @return void
	 */
	public function testValidatePostalCodeByLength() {
		$country = new Country();
		$country->zip_length = 5;
		$country->zip_regexp = '';

		$this->assertTrue($country->validatePostalCode('12345'));
		$this->assertTrue($country->validatePostalCode('ABCDE'));
		$this->assertFalse($country->validatePostalCode('1234'));
		$this->assertFalse($country->validatePostalCode('123456'));
		// Empty rejected when a constraint is declared.
		$this->assertFalse($country->validatePostalCode(''));
	}

	/**
	 * zip_regexp takes precedence over zip_length when both are set.
	 *
	 * @return void
	 */
	public function testValidatePostalCodeRegexBeatsLength() {
		$country = new Country();
		$country->zip_length = 5;
		// US ZIP+4 pattern: stricter than length=5.
		$country->zip_regexp = '/^\d{5}(-\d{4})?$/';

		$this->assertTrue($country->validatePostalCode('12345'));
		$this->assertTrue($country->validatePostalCode('12345-6789'));
		// 5-char value that the length-only check would have accepted but the regex rejects.
		$this->assertFalse($country->validatePostalCode('ABCDE'));
		$this->assertFalse($country->validatePostalCode('12345-67'));
	}

	/**
	 * Multi-byte input must be handled correctly by the length branch.
	 *
	 * @return void
	 */
	public function testValidatePostalCodeMultibyteLength() {
		$country = new Country();
		$country->zip_length = 4;
		$country->zip_regexp = '';

		// Four CJK characters: mb_strlen=4, strlen would be 12 (UTF-8). Must use mb counting.
		$this->assertTrue($country->validatePostalCode('東京千代'));
		$this->assertFalse($country->validatePostalCode('東京'));
	}

	/**
	 * Malformed regex must not throw — it returns false so a bad row in the database
	 * does not crash the request.
	 *
	 * @return void
	 */
	public function testValidatePostalCodeMalformedRegexReturnsFalse() {
		$country = new Country();
		$country->zip_regexp = '/[unterminated';

		$this->assertFalse($country->validatePostalCode('12345'));
	}

	/**
	 * Whitespace-only zip_regexp values are treated as "no pattern" — fall back to length.
	 *
	 * @return void
	 */
	public function testValidatePostalCodeWhitespaceRegexFallsBackToLength() {
		$country = new Country();
		$country->zip_length = 4;
		$country->zip_regexp = '   ';

		$this->assertTrue($country->validatePostalCode('1234'));
		$this->assertFalse($country->validatePostalCode('12345'));
	}

}
