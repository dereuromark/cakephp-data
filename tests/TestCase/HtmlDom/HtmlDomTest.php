<?php

namespace Data\Test\TestCase\HtmlDom;

use Data\HtmlDom\HtmlDom;
use Shim\TestSuite\TestCase;

class HtmlDomTest extends TestCase {

	/**
	 * @var \Data\HtmlDom\HtmlDom
	 */
	protected $HtmlDom;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->skipIf(true, 'Broken');
	}

	/**
	 * HtmlDom test
	 *
	 * @return void
	 */
	public function testBasics() {
		$this->HtmlDom = new HtmlDom('<div id="hello">Hello</div><div id="world">World</div>');
		$result = $this->HtmlDom->find('div', 1)->innertext;
		$this->assertSame('World', $result);
	}

}
