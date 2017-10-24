<?php declare(strict_types = 1);
namespace Templado\Mappers;

use DOMDocument;
use PHPUnit\Framework\TestCase;

class DomDocumentMapperTest extends TestCase {

    /**
     * @var DomDocumentMapper
     */
    private $mapper;

    /**
     * @var DOMDocument
     */
    private $dom;

    protected function setUp() {
        $this->mapper = new DomDocumentMapper();
        $this->dom = new DOMDocument();
    }

    public function testMapXMLString() {
        $result = $this->mapper->fromString('<?xml version="1.0" ?><test>value</test>');
        $this->assertInstanceOf(ViewModel::class, $result);
    }

    public function testInvalidXMLStringThrowsException() {
        $this->expectException(DomDocumentMapperException::class);
        $this->mapper->fromString('<?xml version="1.0" ?><invalid>');
    }

    public function testMapSimpleElementWithText() {
        $element = $this->dom->createElement('test','text-value');
        $result = $this->mapper->fromDomElement($element);

        $this->assertInstanceOf(ViewModel::class, $result);
        $this->assertEquals('text-value', $result->asString());
    }

    public function testMapSimpleElementWithAttributes() {
        $element = $this->dom->createElement('test');
        $element->setAttribute('a', 'value-a');
        $element->setAttribute('b', 'value-b');
        $result = $this->mapper->fromDomElement($element);

        $this->assertInstanceOf(ViewModel::class, $result);
        $this->assertEquals('value-a', $result->a());
        $this->assertEquals('value-b', $result->b());
    }

    public function testMapIgnoresComments() {
        $element = $this->dom->createElement('test');
        $element->appendChild($this->dom->createTextNode('text-value-1'));
        $element->appendChild($this->dom->createComment('comment'));
        $element->appendChild($this->dom->createTextNode('text-value-2'));
        $result = $this->mapper->fromDomElement($element);

        $this->assertInstanceOf(ViewModel::class, $result);
        $this->assertCount(2, $result->asString());
    }

    public function testMapNestedElements() {
        $element = $this->dom->createElement('test');
        $element->appendChild($this->dom->createElement('child','text-a'));
        $element->appendChild($this->dom->createElement('child','text-b'));
        $result = $this->mapper->fromDomElement($element);

        $this->assertInstanceOf(ViewModel::class, $result);
        $this->assertCount(2, $result->child());
        $this->assertInstanceOf(ViewModel::class, $result->child()[0]);
    }

    public function testMapDocument() {
        $element = $this->dom->createElement('test','text-value');
        $this->dom->appendChild($element);

        $result = $this->mapper->fromDomDocument($this->dom);

        $this->assertInstanceOf(ViewModel::class, $result);
        $this->assertEquals('text-value', $result->asString());
    }

}
