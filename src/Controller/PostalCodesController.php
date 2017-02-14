<?php
namespace Data\Controller;

use Data\Controller\DataAppController;

/**
 * PostalCodes Controller
 */
class PostalCodesController extends DataAppController {

	/**
	 * @return void
	 */
	public function map() {
		if ($this->Common->isPosted()) {
			$term = $this->request->data['PostalCode']['code'];

		} else {
			$term = '';
		}

		$length = max(1, strlen($term));
		$options = [
			'fields' => ['SUM(lng) as lng_sum', 'SUM(lat) as lat_sum', 'COUNT(*) as count', 'SUBSTRING(code FROM 1 FOR ' . $length . ') as sub', 'PostalCodes.*'],
			'conditions' => ['code LIKE' => $term . '%', 'country_id' => 1],
			//'limit' => 50,
			'group' => ['sub']
		];
		$postalCodes = $this->PostalCodes->find('all', $options);
		if (!empty($term)) {
			$overviewCode = $postalCodes[0];
			$this->set(compact('overviewCode'));

			$options = [
				'fields' => ['SUM(lng) as lng_sum', 'SUM(lat) as lat_sum', 'COUNT(*) as count', 'SUBSTRING(code FROM 1 FOR ' . ($length + 1) . ') as sub', 'PostalCodes.*'],
				'conditions' => ['code LIKE' => $term . '%', 'country_id' => 1],
				//'limit' => 50,
				'group' => ['sub']
			];
			$postalCodes = $this->PostalCodes->find('all', $options);
		}

		$numbers = strlen($term);
		$this->set(compact('postalCodes', 'numbers'));
		$this->helpers = array_merge($this->helpers, ['Geo.GoogleMap']);
	}

}
