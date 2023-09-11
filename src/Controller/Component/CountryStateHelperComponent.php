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
		/** @var \App\Controller\AppController $controller */
		$controller = $this->getController();
		$this->Controller = $controller;
	}

	/**
	 * Call in methods where needed
	 *
	 * @param bool $ignoreStates
	 * @param string|null $prefix Data prefix if applicable (e.g. user_info.country_id)
	 * @param int $defaultValue
	 * @param int|null $selectedCountry
	 * @return void
	 */
	public function provideData($ignoreStates = false, $prefix = null, $defaultValue = 0, $selectedCountry = null) {
		/** @var \Data\Model\Table\CountriesTable $countriesTable */
		$countriesTable = $this->Controller->fetchTable('Data.Countries');
		$countries = $countriesTable->findActive()->enableHydration(false)->find('list')->toArray();

		$states = [];
		$field = 'country_id';
		if ($prefix !== null) {
			$field = $prefix . '.' . $field;
		}

		/** @var \Data\Model\Table\StatesTable $statesTable */
		$statesTable = $this->Controller->fetchTable('Data.States');

		if ($this->Controller->getRequest()->getData($field)) {
			$selectedCountry = $this->Controller->getRequest()->getData($field);
		} elseif ($this->Controller->getRequest()->getQuery($field)) {
			$selectedCountry = $this->Controller->getRequest()->getQuery($field);
		}

		if ($selectedCountry) {
			$states = $statesTable->getListByCountry($selectedCountry);
		} elseif ($ignoreStates === true) {
			# do nothing
		} else {
			# use the id of the first country of the country-list
			foreach ($countries as $key => $value) {
				$states = $statesTable->getListByCountry($key);

				break;
			}
		}
		$this->Controller->set(compact('countries', 'states', 'defaultValue'));
	}

}
