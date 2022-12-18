<?php

namespace App\Repository;

interface IRepository
{
    public function getAll(): array;
    public function get();
    public function create();
    public function update();
    public function delete();
}
