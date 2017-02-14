<?php
namespace Data\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class DataAppController extends AppController {

	/**
	 * @var array
	 */
	public $components = ['Tools.Common'];

	/**
	 * @var array
	 */
	public $helpers = ['Tools.Common', 'Tools.Format', 'Tools.Time', 'Tools.Number', 'Tools.Text', 'Data.Data'];

	/**
	 * @param \Cake\Event\Event $event
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		if (isset($this->Auth)) {
			$this->Auth->allow();
		}
	}

}
