<?php

namespace Data\Controller;

/**
 * @property \Data\Model\Table\ContinentsTable $Continents
 */
class ContinentsController extends DataAppController {

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function index() {
		$continents = $this->Continents->find('threaded');

		$this->set(compact('continents'));

		$this->viewBuilder()->addHelper('Tools.Tree');
	}

}
