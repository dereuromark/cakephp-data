<?php

namespace Data\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;

/**
 * @property \Tools\Controller\Component\CommonComponent $Common
 */
class DataAppController extends AppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->loadComponent('Tools.Common');

		$this->viewBuilder()->setHelpers(['Tools.Common', 'Tools.Format', 'Tools.Time', 'Tools.Number', 'Tools.Text', 'Data.Data']);
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @return \Cake\Http\Response|null|void
	 */
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);

		if (isset($this->Auth)) {
			$this->Auth->allow();
		}
	}

}
