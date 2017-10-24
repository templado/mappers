<?php declare(strict_types = 1);
namespace Templado\Mappers;

use Templado\Engine\Exception;

class DomDocumentMapperException extends Exception {
    /**
     * @var \LibXMLError[]
     */
    private $errors;

    /**
     * @param \LibXMLError[] $errors
     */
    public function __construct(array $errors) {
        $this->errors = $errors;
        parent::__construct('Error parsing XML string');
    }

    /**
     * @return \LibXMLError[]
     */
    public function getErrors(): array {
        return $this->errors;
    }

}
