<?php
namespace Data\Model\Table;

use Cake\Core\Plugin;
use Tools\Model\Table\Table;

/**
 * @mixin \Search\Model\Behavior\SearchBehavior
 */
class PostalCodesTable extends Table {

	/**
	 * @var string
	 */
	public $displayField = 'code';

	/**
	 * @var array
	 */
	public $order = ['code' => 'ASC'];

	/**
	 * @var array
	 */
	public $actsAs = [
		'Geo.Geocoder' => ['min_accuracy' => 2, 'address' => ['code', 'country_name'], 'formatted_address' => 'official_address', 'real' => false, 'before' => 'validate', 'allow_inconclusive' => true]
	];

	/**
	 * @var array
	 */
	public $validate = [
		'code' => array('notBlank'),
		/*
		'official_address' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'valErrMandatoryField',
				'last' => true
			),
			/*
			'validateUnique' => array(
				'rule' => array('validateUnique', array('country_id', 'code')),
				'message' => 'valErrRecordNameExists',
				'last' => true,
			),

		),
		*/
	];

	/**
	 * @param array $config
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);

		$this->belongsTo('Countries', [
			'className' => 'Data.Countries'
		]);

		if (!Plugin::loaded('Search')) {
			return;
		}

		$this->addBehavior('Search.Search');
		$this->searchManager()
			->like('code', ['before' => false, 'after' => false])
			->value('country');
	}

	/**
	 * @param $code
	 * @param null $countryId
	 * @param array $options
	 *
	 * @return \Cake\ORM\Query
	 */
	public function searchLocation($code, $countryId = null, $options = []) {
		if (!empty($options['exact'])) {
			if (!empty($options['term'])) {
				$term = sprintf($options['term'], $code);
			} else {
				$term = $code . '%';
			}
			$search = ['code LIKE' => "$term"];
		} else {
			$search = ['code' => $code];
		}

		if ($countryId) {
			$search['country_id'] = (int)$countryId;
		}

		$options = [
			'conditions' => $search,
			'limit' => 15,
			//'order'=>'Company.name',
		];
		return $this->find('all', $options);
	}

	/**
	 * Postal codes per country
	 */
	public function stats() {
		$res = [];

		$query = $this->find();
		$list = $query
			->select(['count' => $query->count(), 'country_id'])
			->group('country_id')
			->hydrate(false)
			->all();

		foreach ($list as $x) {
			$res[$x['country_id']] = (int)$x['count'];
		}

		return $res;
	}

}
