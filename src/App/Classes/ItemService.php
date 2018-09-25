<?php

namespace App\Classes;

use App\Classes\Models\Item;

class ItemService
{
    /**
     * @var \PDO
     */
    private $databaseConnection;

    public function __construct(\PDO $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
    }

    /**
     * Find a list of all items.
     *
     * @return Item[]
     */
    public function findAllItems(): array
    {
        $stmt = $this->databaseConnection->prepare('select id, name, price from items');
        $stmt->execute();
        $databaseItems = $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
        // PDO requires '?' for every parameter. This creates a '?' for all the parameters given in $ids
        $in = str_repeat('?,', count($ids) - 1) . '?';
        $sql = "SELECT id, name, price FROM items WHERE id IN ($in)";
        $stmt = $this->databaseConnection->prepare($sql);
        $stmt->execute($ids);
        $databaseItems = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $response = [];
        foreach ($databaseItems as $item) {
            $response[] = new Item($item['id'], $item['name'], $item['price']);
        }

        return $response;
    }
}
