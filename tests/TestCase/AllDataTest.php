<?php
/**
 * Group test - Data
 */
class AllDataTest extends PHPUnit_Framework_TestSuite {

	/**
	 * Suite method, defines tests for this suite.
	 *
	 * @return void
	 */
	public static function suite() {
		$Suite = new CakeTestSuite('All Data tests');
		$path = dirname(__FILE__);
		$Suite->addTestDirectory($path . DS . 'Controller');
		$Suite->addTestDirectory($path . DS . 'Model');
		$Suite->addTestDirectory($path . DS . 'Controller' . DS . 'Component');
		$Suite->addTestDirectory($path . DS . 'View' . DS . 'Helper');
		return $Suite;
	}

}
