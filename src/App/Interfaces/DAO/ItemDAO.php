<?php

namespace App\Interfaces\DAO;

interface ItemDAO {
    /**
     * Find all items stored in the database.
     * @return array of database rows
     */
    public function findAllItems(): array;

    /**
     * Find all items with ids specified in argument.
     * @param array $ids
     * @return array of database rows
     */
    public function findAllByIds(array $ids): array;
}
