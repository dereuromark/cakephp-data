<?php
App::uses('DataAppModel', 'Data.Model');

class Location extends DataAppModel {

	public $actsAs = array('Tools.Geocoder' => array('min_accuracy' => 4, 'address' => array('name', 'country_name'), 'formatted_address' => 'formatted_address', 'real' => false, 'before' => 'validate', 'allow_inconclusive' => true, 'expect' => array())); //'postal_code', 'locality', 'sublocality', 'street_address'

	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
				'last' => true
			),
			'unique' => array(
				'rule' => array('validateUnique', array('country_id')),
				'message' => 'valErrRecordNameExists',
			),
		),
		'country_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'valErrMandatoryField',
				'last' => true
			),
		)
	);

	/**
	 * Location::beforeSave()
	 *
	 * @param mixed $options
	 * @return boolean Success
	 */
	public function beforeSave($options = array()) {
		parent::beforeSave($options);

		$additional = array('locality', 'sublocality');
		foreach ($additional as $field) {
			if (!empty($this->data[$this->alias]['geocoder_result'][$field])) {
				$this->data[$this->alias][$field] = $this->data[$this->alias]['geocoder_result'][$field];
			}
		}

		return true;
	}

	/**
	 * @param string $location
	 * @param integer $countryId
	 * @return array location on success, false otherwise
	 */
	public function getLocation($locationName, $countryId = null) {
		App::uses('Country', 'Data.Model');

		$country = !empty($countryId) ? ', ' . Country::addressList($countryId) : __('Germany');
		$countryId = !empty($countryId) ? $countryId : 1;

		if (is_numeric($locationName) && strlen($locationName) < 5) { //Country::zipCodeLength($countryId)
			$result = $this->find('first', array('conditions' => array('formatted_address LIKE' => $locationName . '%' . $country)));
		} else {
			$result = $this->find('first', array('conditions' => array('name' => $locationName, 'country_id' => $countryId)));
		}

		if (empty($result)) {
			$this->create();
			$this->set(array('Location' => array('name' => $locationName, 'country_id' => $countryId, 'country_name' => $country)));
			$result = $this->save();
		}

		if (empty($result['Location']['lat']) && empty($result['Location']['lng']) || !empty($result['Location']['inconclusive'])) {
			# delete lastest cached (and now not needed anymore) record
			$this->delete($this->id, false);
			return false;
		}
		return $result;
	}

	/**
	 * @return array
	 */
	public function findLocationByCoordinates($lat, $lng, $limit = 1) {
		if (!is_numeric($lat) || !is_numeric($lng) || !is_numeric($limit)) {
			return false;
		}
		$conditions = array(
			'Location.lat<>0',
			'Location.lng<>0',
			'1=1 HAVING distance<' . 75
		);
		$result = $this->find('all', array(
			'conditions' => $conditions,
			'fields' => array_merge(
				array('Location.id', 'Location.name', 'Location.formatted_address'),
				array(
					'6371.04 * ACOS( COS( PI()/2 - RADIANS(90 - Location.lat)) * ' .
					'COS( PI()/2 - RADIANS(90 - ' . $lat . ')) * ' .
					'COS( RADIANS(Location.lng) - RADIANS(' . $lng . ')) + ' .
					'SIN( PI()/2 - RADIANS(90 - Location.lat)) * ' .
					'SIN( PI()/2 - RADIANS(90 - ' . $lat . '))) ' .
					'AS distance'
				)),
				'order' => 'distance ASC',
				'limit' => $limit
		));
		return $result;
	}

	/**
	 * @return array or boolean false
	 */
	public function findLocationByIp() {
		$ip = $this->findIp();
		if (empty($ip)) {
			return false;
		}
		if (Validation::ip($ip)) {
			App::import('Vendor', 'geoip', array('file' => 'geoip' . DS . 'geoip.php'));
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
			if ($ip = Configure::read('App.defaultIp')) {
				return $ip;
			}
			return '127.0.0.1';
		}
		App::uses('Utility', 'Tools.Utility');
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
