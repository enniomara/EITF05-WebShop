<?php

namespace App\Classes;

use App\Interfaces\DAO\ItemDAO;
use App\Classes\Models\Item;

class ItemService
{
    /**
     * @var ItemDAO
     */
    private $itemDAO;

    public function __construct(ItemDAO $itemDAO)
    {
        $this->itemDAO = $itemDAO;

    }

    /**
     * Find a list of all items.
     *
     * @return Item[]
     */
    public function findAllItems(): array
    {
        $databaseItems = $this->itemDAO->findAllItems();
        $response = [];

        foreach ($databaseItems as $item) {
            $response[] = new Item($item['id'], $item['name'], $item['price']);
        }

        return $response;
    }

    /**
     * Finds a list of items with the given ids.
     *
     * @param int ...$ids Id of items to retrieve.
     * @return Item[]
     */
    public function findAllByIds(int ...$ids): array
    {
        $databaseItems = $this->itemDAO->findAllByIds($ids);

        $response = [];
        foreach ($databaseItems as $item) {
            $response[] = new Item($item['id'], $item['name'], $item['price']);
        }

        return $response;
    }
}
