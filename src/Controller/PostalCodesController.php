<?php
namespace Data\Controller;

use Data\Controller\DataAppController;
use Tools\Lib\GeocodeLib;
use Tools\Lib\GeolocateLib;

/**
 * PostalCodes Controller
 *
 */
class PostalCodesController extends DataAppController {

	public $paginate = array();

	public function index() {
	}

	public function geolocate() {
		$this->admin_geolocate();
	}

	public function map() {
		if ($this->Common->isPosted()) {
			$term = $this->request->data['PostalCode']['code'];

		} else {
			$term = '';
		}

		$length = max(1, strlen($term));
		$options = array(
			'fields' => array('SUM(lng) as lng_sum', 'SUM(lat) as lat_sum', 'COUNT(*) as count', 'SUBSTRING(code FROM 1 FOR ' . $length . ') as sub', 'PostalCode.*'),
			'conditions' => array('code LIKE' => $term . '%', 'country_id' => 1),
			//'limit' => 50,
			'group' => array('sub')
		);
		$postalCodes = $this->PostalCode->find('all', $options);
		if (!empty($term)) {
			$overviewCode = $postalCodes[0];
			$this->set(compact('overviewCode'));

			$options = array(
				'fields' => array('SUM(lng) as lng_sum', 'SUM(lat) as lat_sum', 'COUNT(*) as count', 'SUBSTRING(code FROM 1 FOR ' . ($length + 1) . ') as sub', 'PostalCode.*'),
				'conditions' => array('code LIKE' => $term . '%', 'country_id' => 1),
				//'limit' => 50,
				'group' => array('sub')
			);
			$postalCodes = $this->PostalCode->find('all', $options);
			//pr($postalCodes);
		}

		$numbers = strlen($term);
		$this->set(compact('postalCodes', 'numbers'));
		$this->helpers = array_merge($this->helpers, array('Tools.GoogleMapV3'));
	}

}
