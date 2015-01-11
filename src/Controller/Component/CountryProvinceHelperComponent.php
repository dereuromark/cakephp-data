<?php
namespace Data\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 */
class CountryProvinceHelperComponent extends Component {

	public $Controller;

	public function startup(Event $event) {
		$this->Controller = $this->_registry->getController(); //$event->getSubject();
	}

	/**
	 * Call in methods where needed
	 */
	public function provideData($ignoreProvinces = false, $model = null, $defaultValue = 0) {
		if (!isset($this->Controller->Countries)) {
			$this->Controller->Countries = TableRegistry::get('Data.Countries');
		}
		$countries = $this->Controller->Countries->getList();
		$countryProvinces = array();

		if ($model === null) {
			$model = $this->Controller->modelClass;
		}

		if (!isset($this->Controller->CountryProvince)) {
			$this->Controller->CountryProvinces = TableRegistry::get('Data.CountryProvinces');
		}

		if (!empty($this->Controller->request->data[$model]['country_id'])) {
			$countryProvinces = $this->Controller->CountryProvincess->getListByCountry($this->Controller->request->data[$model]['country_id']);
		} elseif ($ignoreProvinces === true) {
			# do nothing
		} else {
			# use the id of the first country of the country-list
			foreach ($countries as $key => $value) {
				$countryProvinces = $this->Controller->CountryProvinces->getListByCountry($key);
				break;
			}
		}
		$this->Controller->set(compact('countries', 'countryProvinces', 'defaultValue'));
	}

}
