<?php

namespace TestApp\View;

use Cake\View\View;

/**
 * @property \Geo\View\Helper\GoogleMapHelper $GoogleMap
 * @property \Tools\View\Helper\TreeHelper $Tree
 * @property \Data\View\Helper\DataHelper $Data
 * @property \Data\View\Helper\MimeTypeHelper $MimeType
 * @property \Data\View\Helper\ContinentHelper $Continent
 */
class AppView extends View {

	/**
	 * @return void
	 */
	public function initialize(): void {
		$this->addHelper('Tools.Format');
		$this->addHelper('Tools.Icon');
		$this->addHelper('Tools.Time');
		$this->addHelper('Tools.Number');
		$this->addHelper('Tools.Text');
	}

}
