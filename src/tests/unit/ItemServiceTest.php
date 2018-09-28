<?php

namespace Tests\Unit;

use App\Classes\DAO\ItemMySQLDAO;
use App\Interfaces\DAO\ItemDAO;
use App\Classes\ItemService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\Classes\Models\Item;

class ItemServiceTest extends TestCase
{
    /**
     * @var ItemDAO|MockObject
     */
    private $itemDAOStub;

    /**
     * @var ItemService
     */
    private $itemService;

    protected function setUp()
    {
        parent::setUp();
        $this->itemDAOStub = $this->getMockBuilder(ItemMySQLDAO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemService = new ItemService($this->itemDAOStub);
    }

    public function testFindAllItems(): void
    {
        $dbResponse = [
            [
                'id' => 1,
                'name' => "Name",
                'price' => 8
            ],
            [
                'id' => 2,
                'name' => "Name2",
                'price' => 9
            ]];
        $this->itemDAOStub->expects($this->once())
            ->method('findAllItems')
            ->willReturn($dbResponse);

        $items = $this->itemService->findAllItems();

        $this->assertContainsOnly(Item::class, $items);
        $this->assertEquals([
            new Item($dbResponse[0]['id'], $dbResponse[0]['name'], $dbResponse[0]['price']),
            new Item($dbResponse[1]['id'], $dbResponse[1]['name'], $dbResponse[1]['price'])
        ], $items);
    }

    public function testFindAllByIds(): void
    {
        $dbResponse = [
            [
                'id' => 1,
                'name' => "Name",
                'price' => 8
            ],
            [
                'id' => 2,
                'name' => "Name2",
                'price' => 9
            ]];
        $this->itemDAOStub->expects($this->once())
            ->method('findAllByIds')
            ->with([1, 2, 3])
            ->willReturn($dbResponse);

        $items = $this->itemService->findAllByIds(1, 2, 3);
        // assert that items are sent back and that no item with id 3 is created
        $this->assertContainsOnly(Item::class, $items);
        $this->assertEquals([
            new Item($dbResponse[0]['id'], $dbResponse[0]['name'], $dbResponse[0]['price']),
            new Item($dbResponse[1]['id'], $dbResponse[1]['name'], $dbResponse[1]['price'])
        ], $items);
    }
}
