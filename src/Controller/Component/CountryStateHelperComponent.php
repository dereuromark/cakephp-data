<?php

namespace Data\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\EventInterface;

class CountryStateHelperComponent extends Component {

	/**
	 * @var \App\Controller\AppController
	 */
	public $Controller;

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @return void
	 */
	public function startup(EventInterface $event) {
		$this->Controller = $this->getController();
	}

	/**
	 * Call in methods where needed
	 *
	 * @param bool $ignoreStates
	 * @param string|null $prefix Data prefix if applicable (e.g. user_info.country_id)
	 * @param int $defaultValue
	 * @return void
	 */
	public function provideData($ignoreStates = false, $prefix = null, $defaultValue = 0) {
		$this->Controller->loadModel('Data.Countries');
		$countries = $this->Controller->Countries->findActive()->enableHydration(false)->find('list')->toArray();

		$states = [];
		$field = 'country_id';
		if ($prefix !== null) {
			$field = $prefix . '.' . $field;
		}

		if (!isset($this->Controller->States)) {
			$this->Controller->loadModel('Data.States');
		}

		$selectedCountry = $this->Controller->getRequest()->getQuery($field);
		if ($this->Controller->getRequest()->getData($field)) {
			$selectedCountry = $this->Controller->getRequest()->getData($field);
		}

		if ($selectedCountry) {
			$states = $this->Controller->States->getListByCountry($selectedCountry);
		} elseif ($ignoreStates === true) {
			# do nothing
		} else {
			# use the id of the first country of the country-list
			foreach ($countries as $key => $value) {
				$states = $this->Controller->States->getListByCountry($key);

				break;
			}
		}
		$this->Controller->set(compact('countries', 'states', 'defaultValue'));
	}

}
