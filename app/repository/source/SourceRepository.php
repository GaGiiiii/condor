<?php

namespace App\Repository\Source;

use App\Database\Database;
use App\Logger\Logger;
use Exception;
use PDO;
use PDOException;

class SourceRepository implements ISourceRepository
{
    public function getAll(): array
    {
        try {
            $query = Database::getInstance()->getConnection()->prepare("SELECT * FROM `sources`");
            $query->execute();
            $sources = $query->fetchAll(PDO::FETCH_ASSOC);

            return $sources;
        } catch (PDOException $e) {
            Logger::log([$e]);

            return [];
        }
    }

    public function get()
    {
        throw new Exception("Unsupported operation.");
    }

    public function create()
    {
        throw new Exception("Unsupported operation.");
    }

    public function update()
    {
        throw new Exception("Unsupported operation.");
    }

    public function delete()
    {
        throw new Exception("Unsupported operation.");
    }
}
