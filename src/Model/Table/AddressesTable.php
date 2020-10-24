<?php

namespace Data\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\I18n\Time;
use Data\Model\Entity\Address;
use Tools\Model\Table\Table;

if (!defined('CLASS_USERS')) {
	define('CLASS_USERS', 'Users');
}

/**
 * @method \Data\Model\Entity\Address get($primaryKey, $options = [])
 * @method \Data\Model\Entity\Address newEntity(array $data, array $options = [])
 * @method \Data\Model\Entity\Address[] newEntities(array $data, array $options = [])
 * @method \Data\Model\Entity\Address|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Data\Model\Entity\Address patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Data\Model\Entity\Address[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Data\Model\Entity\Address findOrCreate($search, ?callable $callback = null, $options = [])
 * @property \Data\Model\Table\CountriesTable&\Cake\ORM\Association\BelongsTo $Countries
 * @property \Data\Model\Table\StatesTable&\Cake\ORM\Association\BelongsTo $States
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @method \Data\Model\Entity\Address saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @mixin \Geo\Model\Behavior\GeocoderBehavior
 * @method \Data\Model\Entity\Address newEmptyEntity()
 * @method \Data\Model\Entity\Address[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Data\Model\Entity\Address[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Data\Model\Entity\Address[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Data\Model\Entity\Address[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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
	 * @param string $value
	 * @param array $context
	 *
	 * @return bool
	 */
	public function primaryUnique($value, array $context) {
		$data = $context['data'];
		if (empty($data['foreign_id']) || $data['address_type_id'] != Address::TYPE_MAIN) {
			return true;
		}
		$conditions = ['foreign_id' => $data['foreign_id'], 'address_type_id' => Address::TYPE_MAIN];
		if (!empty($data['user_id'])) {
			$conditions['user_id !='] = $data['user_id'];
		}
		if ($this->find('all', ['conditions' => $conditions])->first()) {
			return false;
		}

		return true;
	}

	/**
	 * Postal code validation.
	 *
	 * @param string $postalCode
	 * @param array $context
	 *
	 * @return bool
	 */
	public function correspondsWithCountry($postalCode, array $context) {
		$data = $context['data'];

		if (empty($postalCode) || empty($data['country_id'])) {
			return true;
		}

		/** @var \Data\Model\Entity\Country $res */
		$res = $this->Countries->find('all', [
			'conditions' => ['Countries.id' => $data['country_id']],
		])->first();
		if ($res === null) {
			return true;
		}

		if ($res->zip_length && $res->zip_length != mb_strlen($data['postal_code'])) {
			return false;
		}

		return true;
	}

	/**
	 * Validation of state_id
	 *
	 * @param int $stateId
	 * @param array $context
	 *
	 * @return bool
	 */
	public function fitsToCountry($stateId, $context) {
		$data = $context['data'];

		if (!isset($data['country_id']) || !$stateId) {
			return true;
		}

		$res = $this->Countries->States->find('all', [
			'conditions' => ['country_id' => $data['country_id']],
		])->find('list')->toArray();
		if (empty($res)) {
			//$data['state_id'] = null;
		} elseif (!isset($res[$stateId])) {
			return false;
		}

		return true;
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \ArrayObject $data
	 * @param \ArrayObject $options
	 *
	 * @return void
	 */
	public function _beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options) {
		# add country name for geocoder
		if (!empty($data['country_id'])) {
			$data['country'] = $this->Countries->fieldByConditions('name', ['id' => $data['country_id']]);
		}
		if (!empty($data['postal_code'])) {
			//unset($this->validate['city']['notBlank']);
		} elseif (!empty($data['city'])) {
			//unset($this->validate['postal_code']['notBlank']);
		}

		if (isset($data['foreign_id']) && empty($data['foreign_id'])) {
			$data['foreign_id'] = 0;
		}
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \Data\Model\Entity\Address $entity
	 * @param \ArrayObject $options
	 * @return void
	 */
	public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options) {
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

			# ensure state is correct

			if (isset($entity['state_id']) && !empty($entity['state_id']) && !empty($entity['geocoder_result']['country_province_code'])) {
				//$entity['state_id']
				$state = $this->Countries->States->find('all', ['conditions' => ['States.id' => $entity['state_id']]])->first();
				if (!empty($state) && strlen($state['code']) === strlen($entity['geocoder_result']['country_province_code']) && $state['code'] != $entity['geocoder_result']['country_province_code']) {
					//FIXME
					//$this->invalidate('state_id', 'Als Bundesland wurde für diese Adresse \'' . h($entity['geocoder_result']['country_province']) . '\' erwartet - du hast aber \'' . h($state['name']) . '\' angegeben. Liegt denn deine Adresse tatsächlich in einem anderen Bundesland? Dann gebe bitte die genaue PLZ und Ort an, damit das Bundesland dazu auch korrekt identifiziert werden kann.');
					return;
				}

			# enter new id
			} elseif (isset($entity['state_id']) && !empty($entity['geocoder_result']['country_province_code'])) {
				$state = $this->Countries->States->find('all', ['conditions' => ['OR' => ['States.code' => $entity['geocoder_result']['country_province_code'], 'States.name' => $entity['geocoder_result']['country_province']]]])->first();
				if (!empty($state)) {
					$entity['state_id'] = $state['id'];
				}
			}

			# enter new id
			if (isset($entity['country_id']) && empty($entity['country_id']) && !empty($entity['geocoder_result']['country_code'])) {
				$country = $this->Countries->find('all', ['conditions' => ['Country.iso2' => $entity['geocoder_result']['country_code']]])->first();
				if (!empty($country)) {
					$entity['country_id'] = $country->id;
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
