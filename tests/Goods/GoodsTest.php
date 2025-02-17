<?php

namespace Webit\WFirmaSDK\Goods;

use Webit\WFirmaSDK\Entity\AbstractApiTestCase;

class GoodsTest extends AbstractApiTestCase
{
    /** @var Good[] */
    private array $goods;

    protected function setUp(): void
    {
        $this->api = new GoodsApi($this->entityApi());
    }

    public function tearDown(): void
    {
        foreach ($this->goods as $contractor) {
            $this->api->delete($contractor->id());
        }
    }

    public function test_new_good_can_be_added(): void
    {
        $good = $this->createGood();

        $this->goods[] = $createdGood = $this->api->add($good);

        $this->assertGood($good, $createdGood);

        $this->assertInstanceOf(Good::class, $createdGood);
    }

    private function assertGood(Good $expected, Good $actual): void
    {
        $this->assertSame($expected->name(), $actual->name());
        $this->assertSame($expected->code(), $actual->code());
        $this->assertSame($expected->description(), $actual->description());
        $this->assertSame($expected->netto(), $actual->netto());
        $this->assertSame($expected->brutto(), $actual->brutto());
        $this->assertSame($expected->type(), $actual->type());
        $this->assertSame($expected->priceType(), $actual->priceType());
    }

    private function createGood(): Good
    {
        $netAmount = $this->faker()->randomNumber(5);
        $vat = 23;

        return new Good(
            $this->faker()->colorName,
            'usługa',
            (string) $vat,
            $this->faker()->word,
            $netAmount,
            $netAmount + ($netAmount * ($vat / 100)),
            'service',
            null,
            null,
            $this->faker()->sentence,
            'brutto'
        );
    }
}
