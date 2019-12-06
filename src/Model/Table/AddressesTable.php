<?php

namespace Data\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\I18n\Time;
use Data\Model\Entity\Address;
use Tools\Model\Table\Table;

if (!defined('CLASS_USERS')) {
	define('CLASS_USERS', 'Users');
}

/**
 * @method \Data\Model\Entity\Address get($primaryKey, $options = [])
 * @method \Data\Model\Entity\Address newEntity($data = null, array $options = [])
 * @method \Data\Model\Entity\Address[] newEntities(array $data, array $options = [])
 * @method \Data\Model\Entity\Address|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\Address patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Data\Model\Entity\Address[] patchEntities($entities, array $data, array $options = [])
 * @method \Data\Model\Entity\Address findOrCreate($search, callable $callback = null, $options = [])
 * @property \Data\Model\Table\CountriesTable|\Cake\ORM\Association\BelongsTo $Countries
 * @property \Data\Model\Table\StatesTable|\Cake\ORM\Association\BelongsTo $States
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @method \Data\Model\Entity\Address|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @mixin \Geo\Model\Behavior\GeocoderBehavior
 */
class AddressesTable extends Table {

	/**
	 * @var string
	 */
	public $displayField = 'formatted_address';

	/**
	 * @var array
	 */
	public $actsAs = ['Geo.Geocoder' => ['real' => false, 'override' => true, 'allow_inconclusive' => true]]; //'before'=>'validate'

	/**
	 * @var array
	 */
	public $order = ['type_id' => 'ASC', 'formatted_address' => 'ASC'];

	/**
	 * @var array
	 */
	public $validate = [
		'state_id' => [
			'numeric' => [
				'rule' => ['numeric'],
				'message' => 'valErrMandatoryField',
				'last' => true,
			],
			'fitsToCountry' => [
				'rule' => ['fitsToCountry'],
				'message' => 'The province seems not be fit to the chosen country',
				'provider' => 'table',
			],
		],
		'country_id' => [
			'numeric' => [
				'rule' => ['numeric'],
				'message' => 'valErrMandatoryField',
				'last' => true,
			],

		],
		'address_type_id' => [
			'numeric' => [
				'rule' => ['numeric'],
				'message' => 'valErrMandatoryField',
				'last' => true,
			],
			'primaryUnique' => [
				'rule' => ['primaryUnique'],
				'message' => 'Es darf nur eine Adresse "Haupt-Wohnsitz" sein, bitte einen anderen Typ wählen',
				'last' => true,
				'provider' => 'table',
			],
		],
		'foreign_id' => [
		],
		'postal_code' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
				'last' => true,
			],
			'correspondsWithCountry' => [
				'rule' => ['correspondsWithCountry'],
				'message' => 'The zip code seems not to have the correct length',
				'provider' => 'table',
			],
		],
		'city' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'valErrMandatoryField',
			],
		],
		'street' => [
		],
		'formatted_address' => [
			'validateUnique' => [
				'rule' => ['validateUnique', ['scope' => ['foreign_id', 'model']]],
				'allowEmpty' => true,
				'message' => 'valErrRecordNameExists',
				'provider' => 'table',
			],
		],
		'lat' => [
			'decimal' => [
				'rule' => ['decimal', 6],
				'allowEmpty' => true,
				'message' => 'not a valid geografic number for latitude',
			],
		],
		'lng' => [
			'decimal' => [
				'rule' => ['decimal', 6],
				'allowEmpty' => true,
				'message' => 'not a valid geografic number for longitude',
			],
		],
	];

	/**
	 * @var array
	 */
	public $belongsTo = [
		'Country' => [
			'className' => 'Data.Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		],
		# redundant:
		'State' => [
			'className' => 'Data.State',
			'foreignKey' => 'state_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		],
		'User' => [
			'className' => CLASS_USERS,
			'foreignKey' => 'foreign_id',
			'conditions' => ['model' => 'User'],
			'fields' => ['id', 'username'],
			'order' => '',
		],
	];

	/**
	 * @param array $config
	 */
	public function __construct(array $config = []) {
		parent::__construct($config);

		/*
		$config = Configure::read('Data.Address');
		if ($config) {
			$vars = ['displayField', 'order', 'actsAs', 'validate', 'belongsTo'];
			foreach ($vars as $var) {
				if (isset($config[$var])) {
					$this->{$var} = $config[$var];
				}
			}
			if (isset($config) && $config === false && isset($this->belongsTo)) {
				unset($this->belongsTo);
			} else {
				$config = true;
			}
			if (!empty($config['debug'])) {
				$this->actsAs['Tools.Jsonable'] = ['fields' => ['debug'], 'map' => ['geocoder_result']];
			}
		}
		*/
	}

	/**
	 * @param string $data
	 *
	 * @return bool
	 */
	public function primaryUnique(&$data) {
		if (empty($entity['foreign_id']) || $entity['address_type_id'] != Address::TYPE_MAIN) {
			return true;
		}
		$conditions = ['foreign_id' => $entity['foreign_id'], 'address_type_id' => Address::TYPE_MAIN];
		if (!empty($entity['id'])) {
			$conditions['user_id !='] = $entity['id'];
		}
		if ($this->find('first', ['conditions' => $conditions])) {
			return false;
		}
		return true;
	}

	/**
	 * Zip Codes
	 *
	 * @param string $data
	 * @return bool
	 */
	public function correspondsWithCountry($data) {
		if (!empty($entity['postal_code'])) {
			$res = $this->Countries->find('first', [
				'conditions' => ['Country.id' => $entity['country_id']],
			]);
			if (empty($res)) {
				return true;
			}
			if (!empty($res['Country']['zip_length']) && $res['Country']['zip_length'] != mb_strlen($entity['postal_code'])) {
				return false;
			}

		}
		return true;
	}

	/**
	 * Validation of country_province_id
	 *
	 * @param string $data
	 * @return bool
	 */
	public function fitsToCountry($data) {
		if (!isset($data['country_id']) || !isset($data['country_province_id'])) {
			return true;
		}
		$res = $this->Countries->States->find('list', [
			'conditions' => ['country_id' => $data['country_id']],
		])->toArray();
		if (empty($res) || array_shift($data) == 0) {
			$data['country_province_id'] = 0;
		} elseif (empty($data['country_province_id']) || !array_key_exists($data['country_province_id'], $res)) {
			return false;
		}
		return true;
	}

	/**
	 * @param array $options
	 *
	 * @return void
	 */
	public function _beforeValidate($options = []) {
		parent::beforeValidate($options);

		# add country name for geocoder
		if (!empty($entity['country_id'])) {
			$entity['country'] = $this->Countries->fieldByConditions('name', ['id' => $entity['country_id']]);
		}
		if (!empty($entity['postal_code'])) {
			unset($this->validate['city']['notBlank']);
		} elseif (!empty($entity['city'])) {
			unset($this->validate['postal_code']['notBlank']);
		}

		if (isset($entity['foreign_id']) && empty($entity['foreign_id'])) {
			$entity['foreign_id'] = 0;
		}

		# prevents NULL inserts into DB
		if (isset($entity['lat'])) {
			$entity['lat'] = number_format((float)$entity['lat'], 6);
		}
		if (isset($entity['lng'])) {
			$entity['lng'] = number_format((float)$entity['lng'], 6);
		}
	}

	/**
	 * @param \Cake\Event\Event $event
	 * @param \Data\Model\Entity\Address $entity
	 * @param \ArrayObject $options
	 * @return void
	 */
	public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options) {
		if (!empty($entity['formatted_address']) && !empty($entity['geocoder_result'])) {
			# fix city/plz?
			if (isset($entity['postal_code']) && empty($entity['postal_code'])) {
				$entity['postal_code'] = $entity['geocoder_result']['postal_code'];
			}
			if (isset($entity['city']) && empty($entity['city'])) {
				# use sublocality too?
				$entity['city'] = $entity['geocoder_result']['locality'];
			}
			if (isset($entity['postal_code']) && empty($entity['postal_code']) && !empty($entity['geocoder_result']['postal_code'])) {
				# use postal_code
				$entity['postal_code'] = $entity['geocoder_result']['postal_code'];
			}

			# ensure province is correct

			if (isset($entity['country_province_id']) && !empty($entity['country_province_id']) && !empty($entity['geocoder_result']['country_province_code'])) {
				//$entity['country_province_id']
				$countryProvince = $this->Countries->States->find('first', ['conditions' => ['States.id' => $entity['country_province_id']]]);
				if (!empty($countryProvince) && strlen($countryProvince['abbr']) === strlen($entity['geocoder_result']['country_province_code']) && $countryProvince['abbr'] != $entity['geocoder_result']['country_province_code']) {
					$this->invalidate('country_province_id', 'Als Bundesland wurde für diese Adresse \'' . h($entity['geocoder_result']['country_province']) . '\' erwartet - du hast aber \'' . h($countryProvince['name']) . '\' angegeben. Liegt denn deine Adresse tatsächlich in einem anderen Bundesland? Dann gebe bitte die genaue PLZ und Ort an, damit das Bundesland dazu auch korrekt identifiziert werden kann.');
					return;
				}

			# enter new id
			} elseif (isset($entity['country_province_id']) && !empty($entity['geocoder_result']['country_province_code'])) {
				$countryProvince = $this->Countries->States->find('first', ['conditions' => ['OR' => ['States.abbr' => $entity['geocoder_result']['country_province_code'], 'States.name' => $entity['geocoder_result']['country_province']]]]);
				if (!empty($countryProvince)) {
					$entity['country_province_id'] = $countryProvince['id'];
				}
			}

			# enter new id
			if (isset($entity['country_id']) && empty($entity['country_id']) && !empty($entity['geocoder_result']['country_code'])) {
				$country = $this->Countries->find('first', ['conditions' => ['Country.iso2' => $entity['geocoder_result']['country_code']]]);
				if (!empty($country)) {
					$entity['country_id'] = $country['id'];
				}
			}
		}

		if (isset($entity['geocoder_result']) && !$this->behaviors()->has('Jsonable')) {
			unset($entity['geocoder_result']);
		}
	}

	/**
	 * Update last used timestamp
	 *
	 * @param int $addressId
	 * @return void
	 */
	public function touch($addressId) {
		$this->updateAll(['last_used' => new Time()], ['id' => $addressId]);
	}

	/**
	 * @param int|null $addressType Address Type (defaults to MAIN)
	 * @param int|null $id Id (foreign id)
	 * @return \Cake\ORM\Query
	 */
	public function getByType($addressType = null, $id = null) {
		if ($addressType === null) {
			$addressType = Address::TYPE_MAIN;
		}
		return $this->find()->where(['foreign_id' => $id, 'address_type_id' => $addressType]);
	}

}
