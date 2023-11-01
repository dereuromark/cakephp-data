<?php

namespace Data\Controller;

use App\Controller\AppController;
use Shim\Datasource\Paging\NumericPaginator;

/**
 * @property \Tools\Controller\Component\CommonComponent $Common
 */
class DataAppController extends AppController {

	protected array $paginate = [
		'className' => NumericPaginator::class,
	];

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->loadComponent('Tools.Common');

		$this->viewBuilder()->setHelpers(['Tools.Common', 'Tools.Format', 'Tools.Time', 'Tools.Number', 'Tools.Text', 'Data.Data']);
	}

}
