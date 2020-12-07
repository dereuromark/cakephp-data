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
	 * @param string|null $model
	 * @param int $defaultValue
	 * @return void
	 */
	public function provideData($ignoreStates = false, $model = null, $defaultValue = 0) {
		$this->Controller->loadModel('Data.Countries');
		$countries = $this->Controller->Countries->findActive()->enableHydration(false)->find('list')->toArray();

		$states = [];
		/*
		if ($model === null) {
			$model = $this->Controller->modelClass;
		}
		*/

		if (!isset($this->Controller->States)) {
			$this->Controller->loadModel('Data.States');
		}

		$selectedCountry = $this->Controller->getRequest()->getQuery('country_id');
		if ($this->Controller->getRequest()->getData('country_id')) {
			$selectedCountry = $this->Controller->getRequest()->getData('country_id');
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
