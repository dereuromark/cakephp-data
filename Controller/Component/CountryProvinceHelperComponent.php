<?php
App::uses('Component', 'Controller');

/**
 */
class CountryProvinceHelperComponent extends Component {

	public $Controller;

	public function initialize(Controller $Controller) {
		parent::initialize($Controller);

		$this->Controller = $Controller;
	}

	/**
	 * Call in methods where needed
	 */
	public function provideData($ignoreProvinces = false, $model = null, $defaultValue = 0) {
		if (!isset($this->Controller->Country)) {
			$this->Controller->Country = ClassRegistry::init('Data.Country');
		}
		$countries = $this->Controller->Country->getList();
		$countryProvinces = array();

		if ($model === null) {
			$model = $this->Controller->modelClass;
		}

		if (!isset($this->Controller->CountryProvince)) {
			$this->Controller->CountryProvince = ClassRegistry::init('Data.CountryProvince');
		}

		if (!empty($this->Controller->request->data[$model]['country_id'])) {
			$countryProvinces = $this->Controller->CountryProvince->getListByCountry($this->Controller->request->data[$model]['country_id']);
		} elseif ($ignoreProvinces === true) {
			# do nothing
		} else {
			# use the id of the first country of the country-list
			foreach ($countries as $key => $value) {
				$countryProvinces = $this->Controller->CountryProvince->getListByCountry($key);
				break;
			}
		}
		$this->Controller->set(compact('countries', 'countryProvinces', 'defaultValue'));
	}

}
