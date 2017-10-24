<?php declare(strict_types = 1);
namespace Templado\Mappers;

class ViewModel {
    /**
     * @var array
     */
    private $properties;

    /**
     * @param array $properties
     *
     */
    public function __construct(array $properties) {
        $this->properties = $properties;
    }

    /**
     * @param string $jsonString
     *
     * @return ViewModel
     */
    public static function fromJSON(string $jsonString) {
        return (new JsonMapper())->fromString($jsonString);
    }

    /**
     * @param string $xmlString
     *
     * @return ViewModel
     */
    public static function fromXML(string $xmlString) {
        return (new DomDocumentMapper())->fromString($xmlString);
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments) {

        if (!isset($this->properties[$name])) {
            return null;
        }

        return $this->properties[$name];
    }

}
