<?php
namespace Data\Model\Table;

use Cake\Core\Plugin;
use Tools\Model\Table\Table;

/**
 * @mixin \Search\Model\Behavior\SearchBehavior
 * @property \Data\Model\Table\CountriesTable|\Cake\ORM\Association\BelongsTo $Countries
 * @method \Data\Model\Entity\PostalCode get($primaryKey, $options = [])
 * @method \Data\Model\Entity\PostalCode newEntity($data = null, array $options = [])
 * @method \Data\Model\Entity\PostalCode[] newEntities(array $data, array $options = [])
 * @method \Data\Model\Entity\PostalCode|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\PostalCode patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Data\Model\Entity\PostalCode[] patchEntities($entities, array $data, array $options = [])
 * @method \Data\Model\Entity\PostalCode findOrCreate($search, callable $callback = null, $options = [])
 * @method \Data\Model\Entity\PostalCode|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @mixin \Geo\Model\Behavior\GeocoderBehavior
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
		'code' => ['notBlank'],
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

		if (!Plugin::isLoaded('Search')) {
			return;
		}

		$this->addBehavior('Search.Search');
		$this->searchManager()
			->like('code', ['before' => false, 'after' => false])
			->value('country');
	}

	/**
	 * @param string $code
	 * @param int|null $countryId
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
		];
		return $this->find('all', $options);
	}

	/**
	 * Postal codes per country
	 *
	 * @return array
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
