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
		// docs/img/* moved to docs/public/img/* in cakephp-ide-helper a while back; the
		// previous URL silently 404'd and emptied the response. Use the live path.
		$validUrl = 'https://raw.githubusercontent.com/dereuromark/cakephp-ide-helper/master/docs/public/img/code_completion.png';
		$invalidUrl = 'https://raw.githubusercontent.com/dereuromark/cakephp-ide-helper/master/docs/public/img/code_completion_does_not_exist.png';

		// Network sanity probe so this test skips cleanly when the runner cannot reach
		// raw.githubusercontent.com, instead of erroring out and turning the suite red.
		// We only probe the invalid URL (cheap 404 round-trip) — if that returns headers,
		// the host is reachable and the assertions below are meaningful.
		$probe = @get_headers($invalidUrl, false, stream_context_create(['http' => ['timeout' => 3]]));
		if ($probe === false) {
			$this->markTestSkipped('raw.githubusercontent.com not reachable from this runner.');
		}

		$res = $this->Mime->detectMimeType($validUrl);
		$this->assertSame('image/png', $res);

		$res = $this->Mime->detectMimeType($invalidUrl);
		$this->assertSame('', $res);

		$file = Plugin::path('Data') . 'tests' . DS . 'test_files' . DS . 'json' . DS . 'bitcoincharts.json';
		$this->assertFileExists($file);
		$res = $this->Mime->detectMimeType($file);
		$this->assertSame('application/json', $res);
	}

	/**
	 * @return void
	 */
	public function testEncoding() {
		file_put_contents(TMP . 'sometest.txt', 'xyz');
		$is = $this->Mime->getEncoding(TMP . 'sometest.txt');
		//pr($is);
		$this->assertEquals($is, 'us-ascii');

		file_put_contents(TMP . 'sometest.zip', mb_convert_encoding('xäääyz', 'UTF-8', 'ISO-8859-1'));
		$is = $this->Mime->getEncoding(TMP . 'sometest.zip');
		//pr($is);
		$this->assertEquals($is, 'utf-8');

		file_put_contents(TMP . 'sometest.zip', 'xyz');
		$is = $this->Mime->getEncoding(TMP . 'sometest.zip');
		//pr($is);
		$this->assertEquals($is, 'us-ascii');
		//Tests fail? finfo_open not availaible??
	}

}
