<?php declare(strict_types = 1);
namespace Templado\Mappers;

use DOMDocument;
use DOMElement;
use DOMText;

class DomDocumentMapper {

    public function fromString(string $xmlString) {
        $domDocument = $this->parseString($xmlString);
        return $this->fromDomElement($domDocument->documentElement);
    }

    public function fromDomDocument(DOMDocument $dom): ViewModel {
        return $this->fromDomElement($dom->documentElement);
    }

    public function fromDomElement(DOMElement $element): ViewModel {
        return $this->mapElement($element);
    }

    private function mapElement(DOMElement $element): ViewModel {
        $properties = [];
        foreach($element->attributes as $attribute) {
            $this->addToProperties($properties, $attribute->localName, $attribute->nodeValue);
        }

        foreach($element->childNodes as $childNode) {
            if ($childNode instanceof DOMText) {
                $this->addToProperties($properties, 'asString', $childNode->nodeValue);
                continue;
            }
            if (!$childNode instanceof DOMElement) {
                continue;
            }
            $this->addToProperties($properties, $childNode->localName, $this->mapElement($childNode));
        }

        return new ViewModel($properties);
    }

    private function addToProperties(array &$properties, string $name, $value) {
        if (!isset($properties[$name])) {
            $properties[$name] = $value;
            return;
        }

        if (!is_array($properties[$name])) {
            $properties[$name] = [$properties[$name]];
        }

        $properties[$name][] = $value;
    }

    /**
     * @param string $xmlString
     *
     * @return DOMDocument
     *
     * @throws DomDocumentMapperException
     */
    private function parseString(string $xmlString): DOMDocument {
        $org = libxml_use_internal_errors(true);
        libxml_clear_errors();
        $dom = new \DOMDocument();
        $res = $dom->loadXML($xmlString);
        libxml_use_internal_errors($org);
        if (!$res) {
            throw new DomDocumentMapperException(libxml_get_errors());
        }

        return $dom;
    }
}
