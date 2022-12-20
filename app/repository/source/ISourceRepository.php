<?php

namespace App\Repository\Source;

use App\Repository\IRepository;

interface ISourceRepository extends IRepository
{
    public function getLastAPICall(string $sourceName, string $type);
    public function insertLastAPICall(array $data);
    public function updateLastAPICall(int $id, array $data);
}
