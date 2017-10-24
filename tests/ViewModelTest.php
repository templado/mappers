<?php declare(strict_types = 1);
namespace Templado\Mappers;

use PHPUnit\Framework\TestCase;

/**
 * @covers Templado\Mappers\ViewModel
 */
class ViewModelTest extends TestCase {

    private $model;

    protected function setUp() {
        $this->model = new ViewModel(['a' => 'value']);
    }

    public function testCallReturnsValueForDefinedProperty() {
        $this->assertEquals(
            'value', $this->model->a()
        );
    }

    public function testCallReturnsNullForUndefinedProperty() {
        $this->assertNull($this->model->undef());
    }

    /**
     * @uses \Templado\Mappers\JsonMapper
     */
    public function testCanBeConstructedFromJsonString() {
        $this->assertInstanceOf(
            ViewModel::class,
            ViewModel::fromJSON('{"a":"value"}')
        );
    }

    /**
     * @uses \Templado\Mappers\DomDocumentMapper
     */
    public function testCanBeConstructedFromXmlString() {
        $this->assertInstanceOf(
            ViewModel::class,
            ViewModel::fromXML('<?xml version="1.0" ?><root>text</root>')
        );
    }
}
