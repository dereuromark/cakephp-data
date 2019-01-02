<?php
namespace Data\Model\Table;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\Validation\Validation;
use Data\Model\Entity\Country;
use Tools\Model\Table\Table;
use Tools\Utility\Utility;

/**
 * @mixin \Geo\Model\Behavior\GeocoderBehavior
 */
class LocationsTable extends Table {

	/**
	 * @var array
	 */
	public $actsAs = ['Geo.Geocoder' => ['min_accuracy' => 4, 'address' => ['name', 'country_name'], 'formatted_address' => 'formatted_address', 'real' => false, 'before' => 'validate', 'allow_inconclusive' => true, 'expect' => []]]; //'postal_code', 'locality', 'sublocality', 'street_address'

	/**
	 * @var array
	 */
	public $validate = [
		'name' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
				'last' => true
			],
			'unique' => [
				'rule' => ['validateUnique', ['scope' => ['country_id']]],
				'message' => 'valErrRecordNameExists',
				'provider' => 'table',
			],
		],
		'country_id' => [
			'numeric' => [
				'rule' => ['numeric'],
				'message' => 'valErrMandatoryField',
				'last' => true
			],
		]
	];

	/**
	 * FIXME
	 *
	 * @param \Cake\Event\Event $event
	 * @param \Cake\ORM\Entity $entity
	 * @return bool|void
	 */
	public function _beforeSave(Event $event, Entity $entity) {
		$additional = ['locality', 'sublocality'];
		foreach ($additional as $field) {
			if (!empty($entity['geocoder_result'][$field])) {
				$entity[$field] = $entity['geocoder_result'][$field];
			}
		}
	}

	/**
	 * @param string $locationName
	 * @param int|null $countryId
	 * @return array location on success, false otherwise
	 */
	public function getLocation($locationName, $countryId = null) {
		$country = !empty($countryId) ? ', ' . $countryId : __('Germany'); ////Country::addressList($countryId)
		$countryId = !empty($countryId) ? $countryId : 1;

		if (is_numeric($locationName) && strlen($locationName) < 5) { //Country::zipCodeLength($countryId)
			$result = $this->find('first', ['conditions' => ['formatted_address LIKE' => $locationName . '%' . $country]]);
		} else {
			$result = $this->find('first', ['conditions' => ['name' => $locationName, 'country_id' => $countryId]]);
		}

		if (empty($result)) {
			//$this->create();
			$this->set(['Location' => ['name' => $locationName, 'country_id' => $countryId, 'country_name' => $country]]);
			$result = $this->save();
		}

		if (empty($result['lat']) && empty($result['lng']) || !empty($result['inconclusive'])) {
			# delete lastest cached (and now not needed anymore) record
			$this->delete($this->id, false);
			return false;
		}
		return $result;
	}

	/**
	 * @param float $lat
	 * @param float $lng
	 * @param int $limit
	 * @return \Cake\ORM\Query|null
	 */
	public function findLocationByCoordinates($lat, $lng, $limit = 1) {
		if (!is_numeric($lat) || !is_numeric($lng) || !is_numeric($limit)) {
			return null;
		}
		$conditions = [
			'Location.lat<>0',
			'Location.lng<>0',
			'1=1 HAVING distance<' . 75
		];
		$result = $this->find('all', [
			'conditions' => $conditions,
			'fields' => array_merge(
				['Location.id', 'Location.name', 'Location.formatted_address'],
				[
					'6371.04 * ACOS( COS( PI()/2 - RADIANS(90 - Location.lat)) * ' .
					'COS( PI()/2 - RADIANS(90 - ' . $lat . ')) * ' .
					'COS( RADIANS(Location.lng) - RADIANS(' . $lng . ')) + ' .
					'SIN( PI()/2 - RADIANS(90 - Location.lat)) * ' .
					'SIN( PI()/2 - RADIANS(90 - ' . $lat . '))) ' .
					'AS distance'
				]),
				'order' => 'distance ASC',
				'limit' => $limit
		]);
		return $result;
	}

	/**
	 * @return \Cake\ORM\Query|false
	 */
	public function findLocationByIp() {
		$ip = $this->findIp();
		if (empty($ip)) {
			return false;
		}
		if (Validation::ip($ip)) {
			//App::import('Vendor', 'geoip', ['file' => 'geoip' . DS . 'geoip.php']);
			$gi = Net_GeoIP::getInstance(APP . 'vendors' . DS . 'geoip' . DS . 'GeoLiteCity.dat');
			$record = $gi->lookupLocation($ip);
			$gi->close();
		} else {
			$this->log('Invalid IP \'' . h($ip) . '\'', LOG_WARNING);
		}
		return !empty($record) ? $this->findLocationByCoordinates($record->latitude, $record->longitude, 1) : false;
	}

	/**
	 * Returns current IP address.
	 * Note that in debug mode it will emulate it - and retrieve the preconfigured one.
	 *
	 * NEW: if many ips in row (ip1, ip2, ip3), use last (or first???) one!
	 *
	 * @return string IP
	 */
	public static function findIp() {
		if ((int)Configure::read('debug') > 1) {
			$ip = Configure::read('App.defaultIp');
			if ($ip) {
				return $ip;
			}
			return '127.0.0.1';
		}
		$ip = Utility::getClientIp();
		# usually getClientIp already removes multiple ips in favor of one single ip. but seems to fail sometimes
		if (strpos($ip, ',') !== false) {
			return false;
			//$ips = explode(',', $ip);
			//$ip = trim($ips[0]); # first
			//$ip = trim($ips[count($ips)-1]); # last
		}
		return $ip;
	}

}
