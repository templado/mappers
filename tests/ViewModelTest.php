<?php declare(strict_types = 1);
namespace Templado\Mappers;

use PHPUnit\Framework\TestCase;

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

}
