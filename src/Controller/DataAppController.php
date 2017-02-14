<?php
namespace Data\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class DataAppController extends AppController {

	public $components = ['Tools.Common'];

	public $helpers = ['Tools.Common', 'Tools.Format', 'Tools.Time', 'Tools.Number', 'Tools.Text', 'Data.Data'];


	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		if (isset($this->Auth)) {
			$this->Auth->allow();
		}
	}
}
