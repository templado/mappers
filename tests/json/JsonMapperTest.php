<?php declare(strict_types = 1);
namespace Templado\Mappers;

use PHPUnit\Framework\TestCase;

class JsonMapperTest extends TestCase {

    public function testInvalidJsonThrowsException() {
        $this->expectException(JsonMapperException::class);
        (new JsonMapper())->fromString('not-json');
    }

    /**
     * @dataProvider jsonDataProvider
     */
    public function testJsonGetsMappedAsExcepted(string $jsonString, ViewModel $expected) {
        $result = (new JsonMapper())->fromString($jsonString);
        $this->assertEquals(
            $expected, $result
        );
    }

    public function jsonDataProvider(): array {
        return [
            'simple' => [
                '{"key":"value"}',
                new ViewModel(['key' => 'value'])
            ],
            'array'  => [
                '{"key": ["v1","v2"]}',
                new ViewModel(['key' => ["v1","v2"]])
            ],
            'array-of-array' => [
                '{"key": [["v1"],["v2"]]}',
                new ViewModel(['key' => [["v1"],["v2"]]])
            ],
            'object' => [
                '{"key": {"k":"v"}}',
                new ViewModel(['key' => new ViewModel(['k' => 'v'])])
            ],
            'array-of-object' => [
                '{"key": [{"k":"v1"},{"k":"v2"}]}',
                new ViewModel(['key' => [
                    new ViewModel(['k' => 'v1']),
                    new ViewModel(['k' => 'v2'])
                ]])
            ]
        ];
    }
}

