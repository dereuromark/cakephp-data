<?php
declare(strict_types = 1);

namespace Data\Controller;

use App\Controller\AppController;

/**
 * @property \Data\Model\Table\CurrenciesTable $Currencies
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Currency> paginate($object = null, array $settings = [])
 */
class CurrenciesController extends AppController {

	/**
	 * @return \Cake\Http\Response|null|void Renders view
	 */
	public function index() {
		$currencies = $this->paginate($this->Currencies);

		$this->set(compact('currencies'));
	}

}
