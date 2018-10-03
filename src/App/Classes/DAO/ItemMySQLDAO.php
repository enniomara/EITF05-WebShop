<?php

namespace App\Classes\DAO;

use App\Interfaces\DAO\ItemDAO;

class ItemMySQLDAO implements ItemDAO
{
    /**
     * @var \PDO
     */
    private $databaseConnection;

    public function __construct(\PDO $databaseConnection = null)
    {
        $this->databaseConnection = $databaseConnection;
    }

    /**
     * @inheritdoc
     */
    public function findAllItems(): array
    {
        $stmt = $this->databaseConnection->prepare('select id, name, price from items');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @inheritdoc
     */
    public function findAllByIds(array $ids): array
    {
        if (empty($ids)) {
            throw new \InvalidArgumentException('No id sent.');
        }

        // PDO requires '?' for every parameter. This creates a '?' for all the parameters given in $ids
        $in = str_repeat('?,', count($ids) - 1) . '?';
        $sql = "SELECT id, name, price FROM items WHERE id IN ($in)";
        $stmt = $this->databaseConnection->prepare($sql);
        $stmt->execute($ids);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
