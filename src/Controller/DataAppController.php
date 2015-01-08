<?php
namespace Data\Controller;

use App\Controller\AppController;

class DataAppController extends AppController {

	public $components = array('Session', 'Tools.Common');

	public $helpers = array('Tools.Common', 'Tools.Format', 'Tools.Time', 'Tools.Number', 'Tools.Text', 'Data.Data');

}
