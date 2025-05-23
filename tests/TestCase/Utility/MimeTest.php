<?php

namespace Data\Test\TestCase\Utility;

use Cake\Core\Plugin;
use Shim\TestSuite\TestCase;
use Tools\Utility\Mime;

class MimeTest extends TestCase {

	/**
	 * @var \Tools\Utility\Mime
	 */
	protected $Mime;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->Mime = new Mime();
	}

	/**
	 * @return void
	 */
	public function testAll() {
		$res = $this->Mime->mimeTypes();
		$this->assertTrue(is_array($res) && count($res) > 100);
	}

	/**
	 * @return void
	 */
	public function testSingle() {
		$res = $this->Mime->getMimeTypeByAlias('odxs');
		$this->assertNull($res);

		$res = $this->Mime->getMimeTypeByAlias('ods');
		$this->assertEquals('application/vnd.oasis.opendocument.spreadsheet', $res);
	}

	/**
	 * @return void
	 */
	public function testOverwrite() {
		$res = $this->Mime->getMimeTypeByAlias('ics');
		$this->assertEquals('application/ics', $res);
	}

	/**
	 * @return void
	 */
	public function testReverseToSingle() {
		$res = $this->Mime->getMimeTypeByAlias('html');
		$this->assertEquals('text/html', $res);

		$res = $this->Mime->getMimeTypeByAlias('csv');
		$this->assertEquals('text/csv', $res);
	}

	/**
	 * @return void
	 */
	public function testReverseToMultiple() {
		$res = $this->Mime->getMimeTypeByAlias('html', false);
		$this->assertTrue(is_array($res));
		$this->assertSame(2, count($res));

		$res = $this->Mime->getMimeTypeByAlias('csv', false);
		$this->assertTrue(is_array($res)); //  && count($res) > 2
		$this->assertSame(2, count($res));
	}

	/**
	 * @return void
	 */
	public function testCorrectFileExtension() {
		file_put_contents(TMP . 'sometest.txt', 'xyz');
		$is = $this->Mime->detectMimeType(TMP . 'sometest.txt');
		//pr($is);
		$this->assertEquals($is, 'text/plain');
	}

	/**
	 * @return void
	 */
	public function testWrongFileExtension() {
		file_put_contents(TMP . 'sometest.zip', 'xyz');
		$is = $this->Mime->detectMimeType(TMP . 'sometest.zip');
		//pr($is);
		$this->assertEquals($is, 'text/plain');
		//Test failes? finfo_open not availaible??
	}

	/**
	 * @return void
	 */
	public function testgetMimeTypeByAlias() {
		$res = $this->Mime->detectMimeType('https://raw.githubusercontent.com/dereuromark/cakephp-ide-helper/master/docs/img/code_completion.png');
		$this->assertEquals('image/png', $res);

		$res = $this->Mime->detectMimeType('https://raw.githubusercontent.com/dereuromark/cakephp-ide-helper/master/docs/img/code_completion_invalid.png');
		$this->assertEquals('', $res);

		$file = Plugin::path('Data') . 'tests' . DS . 'test_files' . DS . 'json' . DS . 'bitcoincharts.json';
		$this->assertFileExists($file);
		$res = $this->Mime->detectMimeType($file);
		$this->assertEquals('application/json', $res);
	}

	/**
	 * @return void
	 */
	public function testEncoding() {
		file_put_contents(TMP . 'sometest.txt', 'xyz');
		$is = $this->Mime->getEncoding(TMP . 'sometest.txt');
		//pr($is);
		$this->assertEquals($is, 'us-ascii');

		file_put_contents(TMP . 'sometest.zip', utf8_encode('xäääyz'));
		$is = $this->Mime->getEncoding(TMP . 'sometest.zip');
		//pr($is);
		$this->assertEquals($is, 'utf-8');

		file_put_contents(TMP . 'sometest.zip', utf8_encode('xyz'));
		$is = $this->Mime->getEncoding(TMP . 'sometest.zip');
		//pr($is);
		$this->assertEquals($is, 'us-ascii');
		//Tests fail? finfo_open not availaible??
	}

}
