<?php

namespace Data\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class CountryStateHelperComponent extends Component {

	/**
	 * @var \Cake\Controller\Controller
	 */
	public $Controller;

	/**
	 * @param \Cake\Event\Event $event
	 * @return void
	 */
	public function startup(Event $event) {
		$this->Controller = $this->_registry->getController();
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
		$this->getController()->loadModel('Data.Countries');
		$countries = $this->getController()->Countries->findActive()->enableHydration(false)->find('list')->toArray();

		$states = [];
		/*
		if ($model === null) {
			$model = $this->getController()->modelClass;
		}
		*/

		if (!isset($this->getController()->States)) {
			$this->getController()->States = TableRegistry::get('Data.States');
		}

		$selectedCountry = $this->getController()->getRequest()->getQuery('country_id');
		if ($this->getController()->getRequest()->getData('country_id')) {
			$selectedCountry = $this->getController()->getRequest()->getData('country_id');
		}

		if ($selectedCountry) {
			$states = $this->getController()->States->getListByCountry($selectedCountry);
		} elseif ($ignoreStates === true) {
			# do nothing
		} else {
			# use the id of the first country of the country-list
			foreach ($countries as $key => $value) {
				$states = $this->getController()->States->getListByCountry($key);
				break;
			}
		}
		$this->getController()->set(compact('countries', 'states', 'defaultValue'));
	}

}
