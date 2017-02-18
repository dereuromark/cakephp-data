<?php
namespace Data\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 */
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
	 * @param null $model
	 * @param int $defaultValue
	 * @return void
	 */
	public function provideData($ignoreStates = false, $model = null, $defaultValue = 0) {
		if (!isset($this->Controller->Countries)) {
			$this->Controller->Countries = TableRegistry::get('Data.Countries');
		}
		$countries = $this->Controller->Countries->findActive()->hydrate(false)->find('list')->toArray();

		$states = [];
		if ($model === null) {
			$model = $this->Controller->modelClass;
		}

		if (!isset($this->Controller->States)) {
			$this->Controller->States = TableRegistry::get('Data.States');
		}

		if (!empty($this->Controller->request->data['country_id'])) {
			$states = $this->Controller->States->getListByCountry($this->Controller->request->data['country_id']);
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
