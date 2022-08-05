<?php
declare(strict_types = 1);

namespace Data\Controller;

use App\Controller\AppController;
use Cake\Core\Plugin;

/**
 * @property \Data\Model\Table\TimezonesTable $Timezones
 * @method \Cake\Datasource\ResultSetInterface<\Data\Model\Entity\Timezone> paginate($object = null, array $settings = [])
 * @property \Search\Controller\Component\SearchComponent $Search
 */
class TimezonesController extends AppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		if (Plugin::isLoaded('Search')) {
			$this->loadComponent('Search.Search', [
				'actions' => ['index'],
			]);
		}
	}

	/**
	 * @return \Cake\Http\Response|null|void Renders view
	 */
	public function index() {
		$timezones = $this->paginate($this->Timezones);

		$this->set(compact('timezones'));
	}

}
