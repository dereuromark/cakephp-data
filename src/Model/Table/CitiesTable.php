<?php
namespace Data\Model\Table;

use Cake\Core\Configure;
use Tools\Model\Table\Table;

class CitiesTable extends Table {

	/**
	 * @var array
	 */
	public $order = ['name' => 'ASC'];

	/**
	 * @var array
	 */
	public $validate = [
		'name' => [
			'notBlank',
		]
	];

	/**
	 * @var array
	 */
	public $actsAs = ['Tools.Slugged' => ['label' => 'name', 'mode' => 'ascii', 'case' => 'low', 'unique' => true, 'overwrite' => false]];

	/**
	 * @var array
	 */
	public $hasMany = [
			'District' => ['className' => 'Data.District']
	];

	/**
	 * @var array
	 */
	public $belongsTo = [
		'County' => ['className' => 'Data.County'],
		'Country' => ['className' => 'Data.Country']
	];

	/**
	 * @param array $config
	 */
	public function __construct(array $config = []) {
		if (Configure::read('Data.City.District') === false) {
			unset($this->hasMany['District']);
		}
		if (Configure::read('Data.City.County') === false) {
			unset($this->belongsTo['County']);
		}

		parent::__construct($config);
	}

	/**
	 * @param string $name
	 *
	 * @return \Cake\ORM\Query
	 */
	public function autoCompleteName($name) {
		$options = [
			'conditions' => [
				$this->getAlias() . '.name LIKE' => $name . '%'
			],
			'fields' => ['id', 'postal_code', 'name']
		];
		return $this->find('all', $options);
	}

	/**
	 * @param int $country
	 * @param int $limit
	 *
	 * @return \Cake\ORM\Query
	 */
	public function largeCities($country, $limit = 0) {
		$options = [
			'conditions' => [$this->getAlias() . '.country_id' => $country],
			'order' => [$this->getAlias() . '.citizens' => 'desc'],
			'limit' => $limit
		];

		return $this->find('all', $options);
	}

	/**
	 * @param string $postalCode
	 *
	 * @return \Cake\ORM\Query|null
	 */
	public function getCitiesToPostalCode($postalCode) {
		preg_match("/\d+/", $postalCode, $matches);
		if (!isset($matches[0]) || strlen($matches[0]) !== 5) {
			return null;
		}
		return $this->find('all', ['conditions' => ['Cities.postal_code LIKE' => $matches[0]]]);
	}

	/**
	 * @param string $postalCode
	 *
	 * @return \Cake\Datasource\ResultSetInterface|null
	 */
	public function getCityToPostalCode($postalCode) {
		$result = $this->getCitiesToPostalCode($postalCode)->first();

		return $result;
	}

}
