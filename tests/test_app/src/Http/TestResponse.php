<?php

namespace TestApp\Http;

use Cake\Http\Response;

class TestResponse extends Response {

	/**
	 * @return array
	 */
	public function getMimeTypes() {
		return $this->_mimeTypes;
	}

}
