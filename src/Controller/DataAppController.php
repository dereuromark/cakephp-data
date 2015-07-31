<?php
namespace Data\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class DataAppController extends AppController {

	public $components = array('Session', 'Tools.Common');

	public $helpers = array('Tools.Common', 'Tools.Format', 'Tools.Time', 'Tools.Number', 'Tools.Text', 'Data.Data');


	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		if (isset($this->Auth)) {
			$this->Auth->allow();
		}
	}
}
