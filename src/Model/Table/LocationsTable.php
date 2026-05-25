<?php

namespace Data\Model\Table;

use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Log\Log;
use Cake\Validation\Validation;
use Cake\Validation\Validator;
use Data\Model\Entity\Location;
use Tools\Model\Table\Table;
use Tools\Utility\Utility;

/**
 * @deprecated Moved to Geo plugin.
 * @extends \Tools\Model\Table\Table<array<string, \Cake\ORM\Behavior>, \Data\Model\Entity\Location>
 * @method \Data\Model\Entity\Location newEntity(array $data, array $options = [])
 * @mixin \Geo\Model\Behavior\GeocoderBehavior
 */
class LocationsTable extends Table {

	/**
	 * @var array
	 */
	public array $actsAs = [
		'Geo.Geocoder' => ['min_accuracy' => 4, 'address' => ['name', 'country_name'], 'formatted_address' => 'formatted_address', 'real' => false, 'before' => 'validate', 'allow_inconclusive' => true, 'expect' => []], //'postal_code', 'locality', 'sublocality', 'street_address'
	];

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator): Validator {
		$validator
			->scalar('name')
			->notEmptyString('name', __d('data', 'valErrMandatoryField'))
			->add('name', 'unique', [
				'rule' => ['validateUnique', ['scope' => ['country_id']]],
				'message' => __d('data', 'valErrRecordNameExists'),
				'provider' => 'table',
			]);

		$validator
			->integer('country_id')
			->notEmptyString('country_id', __d('data', 'valErrMandatoryField'));

		return $validator;
	}

	/**
	 * FIXME
	 *
	 * @param \Cake\Event\EventInterface $event
	 * @param \Data\Model\Entity\Location $entity
	 * @return void
	 */
	public function _beforeSave(EventInterface $event, Location $entity): void {
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
	 * @return \Data\Model\Entity\Location|false
	 */
	public function getLocation($locationName, $countryId = null) {
		$country = $countryId !== null ? ', ' . $countryId : __d('data', 'Germany'); ////Country::addressList($countryId)
		$countryId ??= 1;

		/** @var \Data\Model\Entity\Location|null $location */
		$location = null;
		if (is_numeric($locationName) && strlen($locationName) < 5) { //Country::zipCodeLength($countryId)
			$location = $this->find('all', ...['conditions' => ['formatted_address LIKE' => $locationName . '%' . $country]])->first();
		} else {
			$location = $this->find('all', ...['conditions' => ['name' => $locationName, 'country_id' => $countryId]])->first();
		}

		if (empty($location)) {
			$location = $this->newEntity(['name' => $locationName, 'country_id' => $countryId, 'country_name' => $country]);
			if (!$this->save($location)) {
				return false;
			}
		}

		if (empty($location['lat']) && empty($location['lng']) || !empty($location['inconclusive'])) {
			# delete lastest cached (and now not needed anymore) record
			$this->delete($location);

			return false;
		}

		return $location;
	}

	/**
	 * @param float $lat
	 * @param float $lng
	 * @param int $limit
	 * @return \Cake\ORM\Query\SelectQuery|null
	 */
	public function findLocationByCoordinates($lat, $lng, $limit = 1) {
		if (!is_numeric($lat) || !is_numeric($lng) || !is_numeric($limit)) {
			return null;
		}

		// Cast and re-render through %F (locale-independent C-locale float format) before
		// embedding into the SQL expression. Without this, a stray comma decimal
		// separator (e.g. de_DE) or a non-canonical numeric string accepted by
		// is_numeric would slip into the SELECT clause.
		$latSafe = sprintf('%F', (float)$lat);
		$lngSafe = sprintf('%F', (float)$lng);
		$limitSafe = (int)$limit;

		$alias = $this->getAlias();
		$query = $this->find();
		$distance = '6371.04 * ACOS( COS( PI()/2 - RADIANS(90 - ' . $alias . '.lat)) * '
			. 'COS( PI()/2 - RADIANS(90 - ' . $latSafe . ')) * '
			. 'COS( RADIANS(' . $alias . '.lng) - RADIANS(' . $lngSafe . ')) + '
			. 'SIN( PI()/2 - RADIANS(90 - ' . $alias . '.lat)) * '
			. 'SIN( PI()/2 - RADIANS(90 - ' . $latSafe . ')))';

		return $query
			->select([
				$alias . '.id',
				$alias . '.name',
				$alias . '.formatted_address',
				'distance' => $query->newExpr($distance),
			])
			->where([
				$alias . '.lat <>' => 0,
				$alias . '.lng <>' => 0,
			])
			->having(['distance <' => 75])
			->orderBy(['distance' => 'ASC'])
			->limit($limitSafe);
	}

	/**
	 * @return \Cake\ORM\Query\SelectQuery|false|null
	 */
	public function findLocationByIp() {
		$ip = static::findIp();
		if (empty($ip)) {
			return false;
		}
		if (Validation::ip($ip)) {
			//App::import('Vendor', 'geoip', ['file' => 'geoip' . DS . 'geoip.php']);
			$record = []; //TODO
		} else {
			Log::write(LOG_WARNING, 'Invalid IP `' . $ip . '`');
		}

		return empty($record) ? false : $this->findLocationByCoordinates($record->latitude, $record->longitude, 1);
	}

	/**
	 * Returns current IP address.
	 * Note that in debug mode it will emulate it - and retrieve the preconfigured one.
	 *
	 * NEW: if many ips in row (ip1, ip2, ip3), use last (or first???) one!
	 *
	 * @return string|null IP
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
		if (str_contains($ip, ',')) {
			return null;

			//$ips = explode(',', $ip);
			//$ip = trim($ips[0]); # first
			//$ip = trim($ips[count($ips)-1]); # last
		}

		return $ip;
	}

}
