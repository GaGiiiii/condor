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

    public function getLastAPICall($sourceName, $type)
    {
        try {
            $sql = "SELECT * FROM `source_api_calls` WHERE source_name = :name AND type = :type";
            $query = Database::getInstance()->getConnection()->prepare($sql);
            $query->execute([
                'name' => $sourceName,
                'type' => $type
            ]);

            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Logger::log([$e]);

            return null;
        }
    }

    public function insertLastAPICall(array $data)
    {
        try {
            $sql = "INSERT INTO source_api_calls (source_name, called_at, type, latest_data) VALUES (?, ?, ?, ?)";
            $query = Database::getInstance()->getConnection()->prepare($sql);
            $result = $query->execute([
                $data['source_name'],
                $data['called_at'],
                $data['type'],
                $data['latest_data'],
            ]);

            return $result;
        } catch (PDOException $e) {
            Logger::log([$e]);

            return false;
        }
    }

    public function updateLastAPICall(int $id, array $data)
    {
        try {
            $sql = "UPDATE `source_api_calls` SET source_name = ?, called_at = ?, type = ?, latest_data = ? WHERE id = ?";
            $query = Database::getInstance()->getConnection()->prepare($sql);
            $result = $query->execute([
                $data['source_name'],
                $data['called_at'],
                $data['type'],
                $data['latest_data'],
                $id,
            ]);

            return $result;
        } catch (PDOException $e) {
            Logger::log([$e]);

            return false;
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
