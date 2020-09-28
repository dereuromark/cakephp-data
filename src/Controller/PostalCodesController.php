<?php

namespace Data\Controller;

/**
 * PostalCodes Controller
 *
 * @property \Data\Model\Table\PostalCodesTable $PostalCodes
 */
class PostalCodesController extends DataAppController {

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function map() {
		if ($this->Common->isPosted()) {
			$term = $this->request->getData('code');

		} else {
			$term = '';
		}

		$length = max(1, strlen($term));

		$query = $this->PostalCodes->find();
		$query->where(['code LIKE' => $term . '%', 'country_id' => 1])
			->select([
				'sub' => $query->newExpr('SUBSTRING(code FROM 1 FOR ' . $length . ')'),
				'count' => $query->count(),
				'lat_sum' => $query->newExpr('SUM(lat)'),
				'lng_sum' => $query->newExpr('SUM(lng)'),
			])
			->select($this->PostalCodes)
			->group('sub');
		$postalCodes = $query->all()->toArray();

		if (!empty($term)) {
			$overviewCode = $postalCodes[0];
			$this->set(compact('overviewCode'));

			$query = $this->PostalCodes->find();
			$query->where(['code LIKE' => $term . '%', 'country_id' => 1])
				->select([
					'sub' => $query->newExpr('SUBSTRING(code FROM 1 FOR ' . ($length + 1) . ')'),
					'count' => $query->count(),
					'lat_sum' => $query->newExpr('SUM(lat)'),
					'lng_sum' => $query->newExpr('SUM(lng)'),
				])
				->select($this->PostalCodes)
				->group('sub');
			$postalCodes = $query->all()->toArray();
		}

		$numbers = strlen($term);
		$this->set(compact('postalCodes', 'numbers'));
		$this->viewBuilder()->setHelpers(['Geo.GoogleMap']);
	}

}
