<?php

namespace Data\Test\TestCase\Sync;

use Cake\Http\Client;
use Cake\Http\Client\Exception\NetworkException;
use Cake\Http\Client\Exception\RequestException;
use Cake\Http\Client\Request;
use Cake\Http\Client\Response;
use Cake\ORM\TableRegistry;
use Data\Model\Entity\Country;
use Data\Sync\Countries;
use Shim\TestSuite\TestCase;

class CountriesTest extends TestCase {

	protected array $fixtures = ['plugin.Data.Countries', 'plugin.Data.Continents', 'plugin.Data.States', 'plugin.Data.Timezones'];

	/**
	 * @var \Data\Sync\Countries
	 */
	protected $Countries;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->Countries = new Countries();
	}

	/**
	 * @return void
	 */
	public function testAll() {
		$result = $this->Countries->all();

		$this->assertNotEmpty($result);
		$this->assertTrue(count($result) > 247);

		foreach ($result as $row) {
			if (empty($row['timezones'])) {
				continue;
			}

			$timezones = [];
			foreach ($row['timezones'] as $timezone) {
				$this->assertIsNumeric($timezone['gmtOffset']);
				$timezones[] = $timezone['gmtOffset'];
			}

			$timezoneString = implode(', ', $timezones);
			$this->assertTrue(mb_strlen($timezoneString) < 255, $timezoneString . ': ' . mb_strlen($timezoneString));
		}
	}

	/**
	 * @return void
	 */
	public function testDiff() {
		$existing = [];
		$existing['DEU'] = new Country([
			'iso3' => 'DEU',
			'name' => 'Geeermany',
		]);
		$existing['BAD'] = new Country([
			'iso3' => 'BAD',
			'name' => 'Invalid Country',
		]);

		$result = $this->Countries->diff($existing);

		$keys = array_keys($result);
		$expected = [
			'add',
			'edit',
		];
		sort($keys);
		sort($expected);

		$this->assertSame($expected, $keys);
		$this->assertArrayNotHasKey('delete', $result);
		$this->assertCount(1, $result['edit']);
		$this->assertTrue(count($result['add']) >= 248);
	}

	public function testDiffUsesPersistedTimezoneField(): void {
		$sync = $this->getMockBuilder(Countries::class)->onlyMethods(['all'])->getMock();
		$sync->expects($this->once())->method('all')->willReturn([
			'DEU' => [
				'name' => 'Germany',
				'native' => 'Deutschland',
				'iso2' => 'DE',
				'phone_code' => '49',
				'timezones' => [['gmtOffset' => 3600]],
			],
		]);
		$country = new Country([
			'name' => 'Germany',
			'ori_name' => 'Deutschland',
			'iso2' => 'DE',
			'phone_code' => '49',
			'timezone_offset' => '0',
		]);
		$result = $sync->diff(['DEU' => $country], ['timezone_offset']);
		$this->assertSame(['timezone_offset' => '3600'], $result['edit'][0]['fields']);
	}

	public function testDiffHandlesMissingTimezones(): void {
		$sync = $this->getMockBuilder(Countries::class)->onlyMethods(['all'])->getMock();
		$sync->expects($this->once())->method('all')->willReturn([
			'DEU' => ['name' => 'Germany', 'native' => 'Deutschland', 'iso2' => 'DE', 'phone_code' => '49'],
		]);
		$country = new Country([
			'name' => 'Germany',
			'ori_name' => 'Deutschland',
			'iso2' => 'DE',
			'phone_code' => '49',
			'timezone_offset' => null,
		]);
		$this->assertSame([], $sync->diff(['DEU' => $country]));
	}

	public function testNewCountriesMapNativeNamesAndOffsets(): void {
		$sync = $this->getMockBuilder(Countries::class)->onlyMethods(['all'])->getMock();
		$sync->expects($this->once())->method('all')->willReturn([
			'DEU' => [
				'name' => 'Germany',
				'native' => 'Deutschland',
				'iso2' => 'DE',
				'iso3' => 'DEU',
				'timezones' => [['gmtOffset' => 3600]],
			],
		]);
		$result = $sync->diff([]);
		$this->assertSame('Deutschland', $result['add'][0]['data']['ori_name']);
		$this->assertSame('3600', $result['add'][0]['data']['timezone_offset']);
	}

	public function testEmptyUpstreamDoesNotProposeDeletions(): void {
		$sync = $this->getMockBuilder(Countries::class)->onlyMethods(['all'])->getMock();
		$sync->expects($this->once())->method('all')->willReturn([]);
		$this->assertSame([], $sync->diff(['DEU' => new Country(['name' => 'Existing'])]));
	}

	public function testUpstreamXmlCreatesSavableCountry(): void {
		$client = $this->createMock(Client::class);
		$client->expects($this->once())->method('get')->willReturn(new Response(
			['HTTP/1.1 200 OK'],
			file_get_contents(TESTS . 'test_files/xml/countries-sync.xml'),
		));
		$sync = new Countries($client);
		$result = $sync->diff([]);
		$data = $result['add'][0]['data'];
		$this->assertSame('93', $data['phone_code']);
		$this->assertArrayNotHasKey('timezones', $data);
		$countries = TableRegistry::getTableLocator()->get('Data.Countries');
		$country = $countries->newEntity($data);
		$this->assertSame([], $country->getErrors());
		$countries->saveOrFail($country);
		$this->assertSame('16200', $country->timezone_offset);
	}

	public function testUpstreamPhoneCodeIsPreservedInExistingCountry(): void {
		$sync = $this->getMockBuilder(Countries::class)->onlyMethods(['all'])->getMock();
		$sync->expects($this->once())->method('all')->willReturn([
			'AFG' => ['name' => 'Afghanistan', 'native' => 'Afghanistan', 'iso2' => 'AF', 'phonecode' => '93'],
		]);
		$country = new Country([
			'name' => 'Afghanistan',
			'ori_name' => 'Afghanistan',
			'iso2' => 'AF',
			'phone_code' => '93',
			'timezone_offset' => null,
		]);
		$this->assertSame([], $sync->diff(['AFG' => $country]));
	}

	public function testNetworkFailureReturnsUnavailableCatalog(): void {
		$client = $this->createMock(Client::class);
		$client->expects($this->once())->method('get')->willThrowException(
			new NetworkException('DNS unavailable', new Request('https://example.invalid')),
		);
		$sync = new Countries($client);
		$this->assertSame([], $sync->all());
		$this->assertFalse($sync->isSourceAvailable());
	}

	public function testMalformedXmlReturnsEmptyCatalog(): void {
		$client = $this->createMock(Client::class);
		$client->expects($this->once())->method('get')->willReturn(new Response(['HTTP/1.1 200 OK'], '<invalid'));
		$this->assertSame([], (new Countries($client))->all());
	}

	public function testPartialCatalogDoesNotProposeDeletions(): void {
		$sync = $this->getMockBuilder(Countries::class)->onlyMethods(['all'])->getMock();
		$sync->expects($this->once())->method('all')->willReturn([
			'DEU' => ['name' => 'Germany', 'native' => 'Deutschland', 'iso2' => 'DE', 'iso3' => 'DEU'],
		]);
		$result = $sync->diff(['AUT' => new Country(['name' => 'Austria'])]);
		$this->assertArrayNotHasKey('delete', $result);
	}

	public function testStreamRequestFailureReturnsUnavailableCatalog(): void {
		$sync = new class extends Countries {

			protected function fetchContent(): string {
				throw new RequestException('Stream connection failed', new Request('https://example.invalid'));
			}

		};
		$this->assertSame([], $sync->all());
		$this->assertFalse($sync->isSourceAvailable());
	}

}
