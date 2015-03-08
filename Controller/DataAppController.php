<?php
App::uses('AppController', 'Controller');

class DataAppController extends AppController {

	public $components = ['Session', 'Tools.Common', 'Tools.Flash'];

	public $helpers = ['Tools.Common', 'Tools.Format', 'Tools.Datetime', 'Tools.Numeric', 'Data.Data'];

}
