<?php declare(strict_types = 1);
namespace Templado\Mappers;

use PHPUnit\Framework\TestCase;

class DomDocumentMapperExceptionTest extends TestCase {

    public function testErrorsCanBeRetrieved() {
        $list = [$this->createMock(\LibXMLError::class)];
        $exception = new DomDocumentMapperException($list);
        $this->assertEquals(
            $list,
            $exception->getErrors()
        );
    }
}
