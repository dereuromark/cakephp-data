<?php

namespace TestApp\Utility;

use Data\Utility\Mime;

class TestMime extends Mime {

	/**
	 * @param bool $coreHasPrecedence
	 * @return array
	 */
	public function getMimeTypes($coreHasPrecedence = false) {
		return $this->_mimeTypesExt;
	}

}
